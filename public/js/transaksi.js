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

function renderTableBody(data, keys, primaryKey) {
    tbody.innerHTML = '';

    data.forEach(row => {
        const tr = createElement('tr');
        keys.forEach(key => {
            let value = getNestedProperty(row, key); // Use the utility here

            if (key === 'meja.kapasitas_kursi') {
                value = window.chairCapacity(value);
            }

            const td = createElement('td', { text: value !== null ? value : '-' }); // Fallback to '-' if null
            tr.appendChild(td);
        });

        const button = createElement('button', {
            text: 'Pilih',
            classes: ['button-primary'],
            type: 'button'
        });

        const primaryKeyInput = document.getElementById(primaryKey);
        const currentPrimaryKeyValue = primaryKeyInput ? primaryKeyInput._x_model.get() : null;

        // Disable button if the primary key value matches the row's key
        if (currentPrimaryKeyValue === row[primaryKey]) {
            button.disabled = true;
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

            // Update the state and disable the clicked button
            selectedRows[primaryKey] = row[primaryKey];
            primaryKeyInput._x_model.set(row[primaryKey]);
            button.disabled = true;
        });

        // Assign a unique identifier to the button for tracking
        button.setAttribute('data-id', row[primaryKey]);

        tr.appendChild(createElement('td', {}, [button]));
        tbody.appendChild(tr);
    });

    table.appendChild(tbody);
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

            if (type === 'menu') {
                renderMenuTableBody(data, keys);
            } else {
                renderTableBody(data, keys, primaryKey);
            }

            if (!dataFinderBox.contains(p)) {
                dataFinderBox.appendChild(table);
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

function findOrder(idPesanan = 0) {
    renderFinder(
        `http://127.0.0.1:8000/api/pesanan/get/${idPesanan}`,
        'Cari Pesanan',
        ['Kode Pesanan', 'Kode Meja', 'Kapasitas kursi dari meja yang dipesan', 'Nama pelanggan', 'User yang melayani', 'Aksi'],
        ['id_pesanan', 'id_meja', 'meja.kapasitas_kursi', 'pelanggan.nama_pelanggan', 'user.username'],
        'order',
        'id_pesanan'
    );
}