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
const quantityMap = {}; // Track the jumlah for each menu item

// Render Title
function renderTitle(title) {
    h1.textContent = title;
    dataFinderBox.appendChild(h1);
}

// Map to track selected rows globally
let selectedRows = {};

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
function renderMenuTableBody(data, keys, disabled = true) {
    tbody.innerHTML = '';

    data.forEach(row => {
        const tr = createElement('tr');

        let input = createElement('input', {
            value: row.id_menu,
            classes: ['text-center', 'w-full', 'outline-none', '!bg-gray-100', 'w-full', 'h-full'],
            readOnly: true,
            type: 'text',
            name: 'id_menu[]',
            disabled: disabled,
        });
        let td = createElement('td', {
            classes: ['p-0']
        }, [input]);
        tr.appendChild(td);

        keys.forEach(key => {
            const td = createElement('td', {
                text: key === 'harga' ? window.formatToIdr(row[key]) : row[key],
                classes: ['bg-gray-100']
            });
            tr.appendChild(td);
        });

        // Retrieve the stored quantity (if any) for this menu item
        const storedJumlah = quantityMap[row.id_menu] || 1; // Default to 1 if not yet set
        input = createElement('input', {
            value: storedJumlah,
            classes: ['text-center', 'w-full', 'outline-none', 'border', 'border-primary-500', 'h-full', 'w-full'],
            type: 'text',
            inputMode: 'numeric',
            name: 'jumlah[]',
            min: 1,
            readOnly: true, // Make it readOnly initially
            disabled: disabled,
        });

        // Update quantityMap when the user changes the quantity
        input.addEventListener('input', () => {
            quantityMap[row.id_menu] = parseInt(input.value, 10) || 1; // Ensure valid number input
        });

        td = createElement('td', {
            classes: ['p-0'],
        }, [input]);
        tr.appendChild(td);

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
            // If selected, make the input field editable
            input.readOnly = false;
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
                    // Set the input field back to readonly when not selected
                    input.readOnly = true;
                }
            } else {
                // Add the menu to the list of chosen menus
                listOfChosenMenus.push(row);

                // Update the button text to 'Hapus' if added
                button.textContent = 'Hapus';
                button.classList.replace('button-primary', 'button-delete');
                // Make the input field editable when selected
                input.readOnly = false;
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
        ['Kode Menu', 'Nama Menu', 'Harga', 'Pilih Jumlah', 'Aksi'],
        ['nama_menu', 'harga'],
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

    renderTitle('Daftar Menu yang Dipilih');
    if (listOfChosenMenus.length) {
        renderTableHead(['Kode Menu', 'Nama Menu', 'Harga', 'Pilih Jumlah', 'Aksi']);
        renderMenuTableBody(listOfChosenMenus, ['nama_menu', 'harga'], false);
        if (!dataFinderBox.contains(p)) {
            dataFinderBox.appendChild(table);
        }
    } else {
        renderNotFoundMessage('Kamu belum memilih menu nih :(');
    }
}
