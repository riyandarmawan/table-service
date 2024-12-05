// Utility: Create DOM Elements
function createElement(tag, options = {}, children = []) {
    const element = document.createElement(tag);
    Object.entries(options).forEach(([key, value]) => {
        if (key === 'classes') element.classList.add(...value);
        else if (key === 'text') element.textContent = value;
        else element[key] = value;
    });
    children.forEach(child => element.appendChild(child));
    return element;
}

// Utility: Fetch API Data
async function fetchData(url) {
    const response = await fetch(url);
    if (!response.ok) throw new Error(`Error: ${response.status} - ${response.statusText}`);
    return response.json();
}

// Utility: Loading Animation
function createLoadingAnimation() {
    return createElement('div', { classes: ['modal-background'] }, [
        createElement('div', { classes: ['loading-animation'] })
    ]);
}

// Global Variables
const dataFinderBox = document.getElementById('data-finder-box');
const loadingAnimation = createLoadingAnimation();
const table = createElement('table');
const thead = createElement('thead');
const tbody = createElement('tbody');
const h1 = createElement('h1', {
    classes: ['font-bold', 'text-3xl', 'text-center', 'mb-4'],
});
const p = createElement('p', {
    classes: ['font-medium', 'text-red-500', 'text-center'],
});
let menuDetails = {};

// Map to track selected rows globally
let selectedRows = {};

function renderTitle(title) {
    h1.textContent = title;
    dataFinderBox.appendChild(h1);
}

function setSelectedRows(key, value) {
    selectedRows[key] = value;
}

function renderTableHead(columns) {
    thead.innerHTML = '';
    columns.forEach(column => {
        const th = createElement('th', { text: column });
        thead.appendChild(th);
    });
    table.appendChild(thead);
}

function getNestedProperty(obj, key) {
    return key.split('.').reduce((o, k) => (o && o[k] !== undefined ? o[k] : null), obj);
}

function renderTableBody(data, keys, primaryKey, type = '') {
    tbody.innerHTML = '';

    // Clear menuDetails when rendering menus
    if (type === 'menus') {
        menuDetails = {};
    }

    data.forEach(row => {
        const tr = createElement('tr');
        keys.forEach(key => {
            let value = getNestedProperty(row, key); // Use the utility here

            if (key === 'meja.kapasitas_kursi') {
                value = window.chairCapacity(value);
            }

            if (key === 'menu.harga') {
                value = window.formatToIdr(value);
            }

            const td = createElement('td', { text: value !== null ? value : '-' }); // Fallback to '-' if null
            tr.appendChild(td);
        });

        if (type === 'menus') {
            // Save menu data globally for total calculation
            menuDetails[row.id_menu] = {
                harga: row.menu.harga,
                jumlah: row.jumlah,
            };
        }

        if (type !== 'menus') {
            const button = createElement('button', {
                text: 'Pilih',
                classes: ['button-primary'],
                type: 'button'
            });

            const primaryKeyInput = document.getElementById(primaryKey);
            const currentPrimaryKeyValue = primaryKeyInput ? primaryKeyInput._x_model.get() : null;

            // Disable button if the primary key value matches the row's key
            if (currentPrimaryKeyValue === row[primaryKey]) {
                button.disabled = false;
            }

            button.addEventListener('click', () => {
                // Re-enable previously selected button if any
                if (selectedRows[primaryKey] && selectedRows[primaryKey] !== row[primaryKey]) {
                    const prevButton = tbody.querySelector(
                        `button[data-id="${selectedRows[primaryKey]}"]`
                    );
                    if (prevButton) {
                        prevButton.disabled = false;
                    }
                }
                showMenus(row.id_pesanan);

                // Update the state and disable the clicked button
                selectedRows[primaryKey] = row[primaryKey];
                primaryKeyInput._x_model.set(row[primaryKey]);
                button.disabled = false;
            });

            // Assign a unique identifier to the button for tracking
            button.setAttribute('data-id', row[primaryKey]);

            tr.appendChild(createElement('td', {
                classes: ['flex', 'items-center', 'gap-4']
            }, [button]));
        }
        tbody.appendChild(tr);
    });

    table.appendChild(tbody);

    // Calculate totalHarga if rendering menus
    if (type === 'menus') {
        calculateTotalHarga();
    }
}

function calculateTotalHarga() {
    let totalHarga = 0;

    Object.values(menuDetails).forEach(menu => {
        totalHarga += menu.harga * menu.jumlah;
    });

    updateTotalDisplay(totalHarga); // Update total display in UI (optional)
}

function updateTotalDisplay(totalHarga) {
    let totalDisplay = document.getElementById('total');

    totalDisplay._x_model.set(window.formatToIdr(totalHarga));
}

function updateKembalian(bayar) {
    const total = window.formatToInteger(document.getElementById('total')._x_model.get());
    const kembalian = window.formatToInteger(bayar) - total;

    document.getElementById('kembalian')._x_model.set(window.formatToIdr(kembalian > 0 ? kembalian : '0'));
}

// Render Not Found Message
function renderNotFoundMessage(message = 'Data tidak ditemukan :(') {
    p.textContent = message;
    if (!dataFinderBox.contains(table)) {
        dataFinderBox.appendChild(p);
    }
}

async function renderFinder(url, title, columns, keys, type, primaryKey = '') {
    try {
        // Clear previous content (table and loading animation)
        dataFinderBox.innerHTML = '';
        dataFinderBox.appendChild(loadingAnimation);

        if (!dataFinderBox.contains(h1)) {
            renderTitle(title);
        }

        const data = await fetchData(url);

        // Render Table if there is data
        if (data.length) {
            renderTableHead(columns);

            renderTableBody(data, keys, primaryKey, type);

            if (!dataFinderBox.contains(p)) {
                dataFinderBox.appendChild(table);
            }

            if (type === 'menus') {
                const button = createElement('button', {
                    text: 'Kembali ke daftar pesanan',
                    classes: ['button-delete']
                }, []);

                button.addEventListener('click', e => {
                    findOrder();
                });

                const div = createElement('div', {
                    classes: ['w-full', 'flex', 'justify-end', 'mt-4'],
                }, [button]);

                dataFinderBox.appendChild(div);
            }
        } else {
            renderNotFoundMessage();
        }
    } catch (error) {
        console.error(error);
        // Render Error message if there is an error
        renderNotFoundMessage('Terjadi kesalahan dalam memuat data.');
    } finally {
        // Remove loading animation once content is loaded or error occurs
        if (dataFinderBox.contains(loadingAnimation)) {
            dataFinderBox.removeChild(loadingAnimation);
        }
    }
}

function findOrder(idPesanan = 0, relatedId = 0) {
    renderFinder(
        `http://127.0.0.1:8000/api/pesanan/get/${idPesanan}/${relatedId}`,
        'Cari Pesanan',
        ['Kode Pesanan', 'Kode Meja', 'Kapasitas kursi', 'Nama pelanggan', 'User yang melayani', 'Aksi'],
        ['id_pesanan', 'id_meja', 'meja.kapasitas_kursi', 'pelanggan.nama_pelanggan', 'user.username'],
        'order',
        'id_pesanan'
    );
}

function showMenus(idPesanan = '') {
    renderFinder(
        `http://127.0.0.1:8000/api/detail-pesanan/choosen-menu/${idPesanan}`,
        'Daftar menu pesanan',
        ['Kode Menu', 'Nama Menu', 'Harga', 'Jumlah'],
        ['id_menu', 'menu.nama_menu', 'menu.harga', 'jumlah'],
        'menus',
    );
}