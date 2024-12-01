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
const h1 = createElement('h1', {
    classes: ['font-bold', 'text-3xl', 'text-center', 'mb-4'],
});
const p = createElement('p', {
    classes: ['font-medium', 'text-red-500', 'text-center'],
});
const table = createElement('table');
const thead = createElement('thead');
const tbody = createElement('tbody');
const listOfChosenMenus = [];

// Map to track selected rows globally
let selectedRows = {};

// Render Title
function renderTitle(title) {
    h1.textContent = title;
    dataFinderBox.appendChild(h1);
}

// Render Table Head
function renderTableHead(columns) {
    thead.innerHTML = '';
    columns.forEach(column => {
        const th = createElement('th', { text: column });
        thead.appendChild(th);
    });
    table.appendChild(thead);
}

// Render Table Body for Menu
function renderMenuTableBody(data, keys) {
    tbody.innerHTML = '';

    data.forEach(row => {
        const tr = createElement('tr');
        keys.forEach(key => {
            const td = createElement('td', {
                text: key === 'harga' ? window.formatToIdr(row[key]) : row[key]
            });
            tr.appendChild(td);
        });

        const button = createElement('button', {
            text: 'Pilih',
            classes: ['button-primary'],
            type: 'button'
        });

        // Check if the menu is already chosen
        const isSelected = listOfChosenMenus.some(menu => menu.id_menu === row.id_menu);

        // Update button state based on selection
        if (isSelected) {
            button.textContent = 'Hapus';
            button.classList.replace('button-primary', 'button-delete');
        }

        button.addEventListener('click', () => {
            if (isSelected) {
                // Remove the menu from the list
                const index = listOfChosenMenus.findIndex(menu => menu.id_menu === row.id_menu);
                if (index !== -1) {
                    listOfChosenMenus.splice(index, 1); // Remove menu from selected list

                    // After removing, update the button to 'Pilih' again
                    button.textContent = 'Pilih';
                    button.classList.replace('button-delete', 'button-primary');
                }
            } else {
                // Add the menu to the list of chosen menus
                listOfChosenMenus.push(row);

                // Update the button text to 'Hapus' if added
                button.textContent = 'Hapus';
                button.classList.replace('button-primary', 'button-delete');
            }

            // Re-render the table body to reflect the state changes immediately
            renderMenuTableBody(data, keys);
        });

        tr.appendChild(createElement('td', {}, [button]));
        tbody.appendChild(tr);
    });

    table.appendChild(tbody);
}

// Render Table Body for Generic Data (Customer, Table, etc.)
function renderTableBody(data, keys, primaryKey) {
    tbody.innerHTML = '';

    data.forEach(row => {
        const tr = createElement('tr');
        keys.forEach(key => {
            const td = createElement('td', { text: row[key] });
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

// Generic Finder
async function renderFinder(url, title, columns, keys, type, primaryKey = '') {
    try {
        // Clear previous content (table and loading animation)
        dataFinderBox.innerHTML = '';
        dataFinderBox.appendChild(loadingAnimation);

        const data = await fetchData(url);

        // Render Title only if there's a title
        if (!dataFinderBox.contains(h1)) {
            renderTitle(title);
        }

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

// Menu Finder
function findMenu(idMenu = 0) {
    renderFinder(
        `http://127.0.0.1:8000/api/menu/get/${idMenu}`,
        'Cari Menu',
        ['Kode Menu', 'Nama Menu', 'Harga', 'Aksi'],
        ['id_menu', 'nama_menu', 'harga'],
        'menu'
    );
}

// Table Finder
function findTable(idTable = 0) {
    renderFinder(
        `http://127.0.0.1:8000/api/meja/get/${idTable}`,
        'Cari Meja',
        ['Kode Meja', 'Kapasitas Kursi', 'Aksi'],
        ['id_meja', 'kapasitas_kursi'],
        'table',
        'id_meja'
    );
}

// Customer Finder
function findCustomer(idCustomer = 0) {
    renderFinder(
        `http://127.0.0.1:8000/api/pelanggan/get/${idCustomer}`,
        'Cari Pelanggan',
        ['Kode Pelanggan', 'Nama Pelanggan', 'Jenis Kelamin', 'No HP', 'Alamat', 'Aksi'],
        ['id_pelanggan', 'nama_pelanggan', 'jenis_kelamin', 'no_hp', 'alamat'],
        'customer',
        'id_pelanggan'
    );
}

// View Chosen Menus
function viewChosenMenus() {
    dataFinderBox.innerHTML = '';

    if (listOfChosenMenus.length) {
        renderTitle('Daftar Menu yang Dipilih');
        renderTableHead(['Kode Menu', 'Nama Menu', 'Harga', 'Aksi']);
        renderMenuTableBody(listOfChosenMenus, ['id_menu', 'nama_menu', 'harga']);
        if (!dataFinderBox.contains(p)) {
        dataFinderBox.appendChild(table);
        }
    } else {
        renderNotFoundMessage('Kamu belum memilih menu nih :(');
    }
}