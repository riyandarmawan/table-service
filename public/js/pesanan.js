const dataFinderBox = document.getElementById('data-finder-box');
const loadingAnimation = createLoadingAnimation();
const table = document.createElement('table');
const thead = document.createElement('thead');
const tbody = document.createElement('tbody');
const h1 = document.createElement('h1');
const p = document.createElement('p');

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
    h1.textContent = `Cari ${title}`;
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

function createTableBody(data, keys, inputElement, primaryKeyColumn) {
    tbody.innerHTML = '';

    data.forEach(row => {
        const tr = document.createElement('tr');

        keys.forEach(key => {
            const td = document.createElement('td');

            td.textContent = row[key];

            tr.appendChild(td);
        });

        const button = document.createElement('button');
        button.textContent = 'Pilih';
        button.classList.add('button-primary');
        button.type = 'button';
        button.addEventListener('click', () => {
            inputElement._x_model.set(row[primaryKeyColumn]);
        });

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

function dataNotFoundMessage() {
    p.textContent = 'Data menu tidak ditemukan nih :(';
    p.classList.add('font-medium', 'text-red-500', 'text-center');
}

async function menuFinder(idMenu = 0) {
    try {
        dataFinderBox.innerHTML = '';

        dataFinderBox.appendChild(loadingAnimation);

        const data = await requestData(`http://127.0.0.1:8000/api/menu/get/${idMenu}`);

        createTitle('Menu');

        if (data.length) {
            p.innerHTML = '';

            const idMenuElement = document.getElementById('id_menu');

            const columns = ['Kode Menu', 'Nama Menu', 'Harga', 'Aksi'];
            createTableHead(columns);

            const keys = ['id_menu', 'nama_menu', 'harga', 'id_menu'];

            createTableBody(data, keys, idMenuElement, 'id_menu');

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

        createTitle('Meja');

        if (data.length) {
            p.innerHTML = '';

            const idMejaElement = document.getElementById('id_meja');

            const columns = ['Kode Meja', 'Kapasitas Kursi', 'Aksi'];
            createTableHead(columns);

            const keys = ['id_meja', 'kapasitas_kursi'];

            createTableBody(data, keys, idMejaElement, 'id_meja');

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

        createTitle('Pelanggan');

        if (data.length) {
            p.innerHTML = '';

            const idPelangganElement = document.getElementById('id_pelanggan');

            const columns = ['Kode Pelanggan', 'Nama Pelanggan', 'Jenis Kelamin', 'No HP', 'Alamat', 'Aksi'];
            createTableHead(columns);

            const keys = ['id_pelanggan', 'nama_pelanggan', 'jenis_kelamin', 'no_hp', 'alamat'];

            createTableBody(data, keys, idPelangganElement, 'id_pelanggan');

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