const dataFinderBox = document.getElementById('data-finder-box');

const loadingContainer = document.createElement('div');

function loadingAnimation() {
    loadingContainer.classList.add('modal-background');

    const loadingAnimationElement = document.createElement('div');
    loadingAnimationElement.classList.add('loading-animation');

    loadingContainer.innerHTML = '';
    loadingContainer.appendChild(loadingAnimationElement);
}

loadingAnimation();

async function menuFinder(idMenu = 0) {
    try {
        if (!dataFinderBox.contains(loadingContainer)) {
            dataFinderBox.appendChild(loadingContainer);
        }

        const h1 = document.createElement('h1');
        h1.textContent = 'Cari Menu';
        h1.classList.add('font-bold', 'text-3xl', 'text-center', 'mb-4');

        const table = document.createElement('table');
        const thead = document.createElement('thead');
        const tbody = document.createElement('tbody');

        const columns = ['Kode Menu', 'Nama Menu', 'Harga', 'Aksi'];

        columns.forEach(value => {
            const th = document.createElement('th');
            th.textContent = value;

            thead.appendChild(th);
        });

        table.appendChild(thead);

        const response = await fetch(`http://127.0.0.1:8000/api/menu/get/${idMenu}`);

        if (!response.ok) throw new Error(`Error: ${response.status} - ${response.statusText}`);

        const data = await response.json();

        data.forEach(row => {
            const tr = document.createElement('tr');

            const keys = ['id_menu', 'nama_menu', 'harga'];

            keys.forEach(key => {
                const td = document.createElement('td');

                td.textContent = key == 'harga' ? window.formatToIdr(row[key]) : row[key];
                
                tr.appendChild(td);
            });

            const button = document.createElement('button');
            button.textContent = 'Pilih';
            button.classList.add('button-primary');
            
            const td = document.createElement('td');
            td.appendChild(button);
            tr.appendChild(td);

            tbody.appendChild(tr);
            table.appendChild(tbody);
        })

        const elements = [h1, table];

        elements.forEach(element => {
            dataFinderBox.appendChild(element);
        });
    } catch (error) {
        console.error(error);
    } finally {
        if (dataFinderBox.contains(loadingContainer)) {
            dataFinderBox.removeChild(loadingContainer);
        }
    }
}
