const dataFinderBox = document.getElementById('data-finder-box');
const loadingAnimation = createLoadingAnimation();
const table = document.createElement('table');
const thead = document.createElement('thead');
const tbody = document.createElement('tbody');
const h1 = document.createElement('h1');
const p = document.createElement('p');

const listOfChoosenMenu = [];

function createLoadingAnimation() {
    const loadingContainer = document.createElement('div');
    loadingContainer.classList.add('modal-background');

    const spinner = document.createElement('div');
    spinner.classList.add('loading-animation');

    loadingContainer.innerHTML = '';
    loadingContainer.appendChild(spinner);

    return loadingContainer;
}

function createTitle(title) {
    h1.textContent = `${title}`;
    h1.classList.add('font-bold', 'text-3xl', 'text-center', 'mb-4');

    dataFinderBox.appendChild(h1);
}

function createTableHead(columns) {
    thead.innerHTML = '';

    columns.forEach(column => {
        const th = document.createElement('th');
        th.textContent = column;

        thead.appendChild(th);
    });
    table.appendChild(thead);
}

function createTableBody(data, dataType, keys, inputElement, primaryKeyColumn) {
    tbody.innerHTML = '';

    data.forEach(row => {
        const tr = document.createElement('tr');

        keys.forEach(key => {
            const td = document.createElement('td');

            td.textContent = key === 'harga' ? window.formatToIdr(row[key]) : row[key];

            tr.appendChild(td);
        });

        const button = document.createElement('button');
        button.textContent = 'Pilih';
        button.classList.add('button-primary');
        button.type = 'button';
        if (dataType === 'menu' || dataType === 'choosenMenu') {
            button.addEventListener('click', (e) => {
                listOfChoosenMenu.push(row);
                e.textContent = 'Hapus';
                button.classList.replace('button-primary', 'button-delete');
            });
        } else {
            button.addEventListener('click', (e) => {
                inputElement ? inputElement._x_model.set(row[primaryKeyColumn]) : '';
                e.target.disabled = true;
            });
        }

        const td = document.createElement('td');
        td.appendChild(button);
        tr.appendChild(td);

        tbody.appendChild(tr);
        table.appendChild(tbody);
    });
}

async function requestData(url) {
    const response = await fetch(url);
    if (!response.ok) throw new Error(`Error: ${response.status} - ${response.statusText}`);
    return await response.json()
}

function dataNotFoundMessage(message = 'Data menu tidak ditemukan nih :(') {
    p.textContent = `${message}`;
    p.classList.add('font-medium', 'text-red-500', 'text-center');
}

async function menuFinder(idMenu = 0) {
    try {
        dataFinderBox.innerHTML = '';

        dataFinderBox.appendChild(loadingAnimation);

        const data = await requestData(`http://127.0.0.1:8000/api/menu/get/${idMenu}`);

        createTitle('Cari Menu');

        if (data.length) {
            p.innerHTML = '';

            const idMenuElement = document.getElementById('id_menu');

            const columns = ['Kode Menu', 'Nama Menu', 'Harga', 'Aksi'];
            createTableHead(columns);

            const keys = ['id_menu', 'nama_menu', 'harga'];

            createTableBody(data, 'menu', keys, idMenuElement, 'id_menu');

            dataFinderBox.appendChild(table);
        } else {
            table.innerHTML = '';

            dataNotFoundMessage();
            dataFinderBox.appendChild(p);
        }
    } catch (error) {
        console.error(error);
    } finally {
        if (dataFinderBox.contains(loadingAnimation)) {
            dataFinderBox.removeChild(loadingAnimation);
        }
    }
}

async function mejaFinder(idMeja = 0) {
    try {
        dataFinderBox.innerHTML = '';

        dataFinderBox.appendChild(loadingAnimation);

        const data = await requestData(`http://127.0.0.1:8000/api/meja/get/${idMeja}`);

        createTitle('Cari Meja');

        if (data.length) {
            p.innerHTML = '';

            const idMejaElement = document.getElementById('id_meja');

            const columns = ['Kode Meja', 'Kapasitas Kursi', 'Aksi'];
            createTableHead(columns);

            const keys = ['id_meja', 'kapasitas_kursi'];

            createTableBody(data, 'meja', keys, idMejaElement, 'id_meja');

            dataFinderBox.appendChild(table);
        } else {
            table.innerHTML = '';

            dataNotFoundMessage();
            dataFinderBox.appendChild(p);
        }
    } catch (error) {
        console.error(error);
    } finally {
        if (dataFinderBox.contains(loadingAnimation)) {
            dataFinderBox.removeChild(loadingAnimation);
        }
    }
}

async function pelangganFinder(idPelanggan = 0) {
    try {
        dataFinderBox.innerHTML = '';

        dataFinderBox.appendChild(loadingAnimation);

        const data = await requestData(`http://127.0.0.1:8000/api/pelanggan/get/${idPelanggan}`);

        createTitle('Cari Pelanggan');

        if (data.length) {
            p.innerHTML = '';

            const idPelangganElement = document.getElementById('id_pelanggan');

            const columns = ['Kode Pelanggan', 'Nama Pelanggan', 'Jenis Kelamin', 'No HP', 'Alamat', 'Aksi'];
            createTableHead(columns);

            const keys = ['id_pelanggan', 'nama_pelanggan', 'jenis_kelamin', 'no_hp', 'alamat'];

            createTableBody(data, 'pelanggan', keys, idPelangganElement, 'id_pelanggan');

            dataFinderBox.appendChild(table);
        } else {
            table.innerHTML = '';

            dataNotFoundMessage();
            dataFinderBox.appendChild(p);
        }
    } catch (error) {
        console.error(error);
    } finally {
        if (dataFinderBox.contains(loadingAnimation)) {
            dataFinderBox.removeChild(loadingAnimation);
        }
    }
}

function choosenMenu() {
    dataFinderBox.innerHTML = '';

    const data = listOfChoosenMenu;

    createTitle('Daftar menu yang dipilih');

    if (data.length) {
        p.innerHTML = '';

        const idMenuElement = document.getElementById('id_menu');

        const columns = ['Kode Menu', 'Nama Menu', 'Harga', 'Aksi'];
        createTableHead(columns);

        const keys = ['id_menu', 'nama_menu', 'harga'];

        createTableBody(data, 'choosenMenu', keys, idMenuElement, 'id_menu');

        dataFinderBox.appendChild(table);
    } else {
        table.innerHTML = '';

        dataNotFoundMessage('Kamu belum memilih menu nih :(');
        dataFinderBox.appendChild(p);

    }
}