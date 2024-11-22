<x-dashboard-layout :$title>
    <div x-data="{ showModalTambah: false }" class="p-4">
        <h1 class="mb-6 text-3xl font-bold">{{ $title }}</h1>
        <button @click="showModalTambah = !showModalTambah" type="button"
            class="rounded bg-blue-500 px-4 py-2 text-lg font-medium text-white shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80">Tambah
            menu</button>

        <table class="mt-8 w-full table-auto border-collapse">
            <thead>
                <th>Kode Menu</th>
                <th>Nama Menu</th>
                <th>Harga</th>
                <th>Aksi</th>
            </thead>
            <tbody>
                <tr>
                    <td>M-001</td>
                    <td>Fried Chicken with Chili Sauce</td>
                    <td>Rp. 13.000</td>
                    <td>
                        <a href="/menu/detail/M-001"
                            class="inline-block rounded bg-blue-500 px-4 py-2 text-lg font-medium text-white shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80">Detail</a>
                    </td>
                </tr>
            </tbody>
        </table>

        <div x-show="showModalTambah" x-cloak
            class="absolute inset-0 z-20 flex items-center justify-center bg-gray-500 bg-opacity-50">
            <div @click.outside="showModalTambah = false" class="rounded-md border bg-white p-4 shadow">
                <h1 class="mb-4 text-3xl font-bold">Tambah Menu</h1>
                <form x-data="{ id_menu: '', nama_menu: '', harga: '' }" action="/menu/tambah" method="POST">
                    <div class="mb-4">
                        <label for="id_menu" class="min-w-28 mr-4 inline-block font-medium">Kode Menu</label>
                        <input x-ref="id_menu" x-model="id_menu" type="text" name="id_menu" id="id_menu"
                            class="rounded bg-gray-100 px-4 py-2 shadow outline-none">
                    </div>
                    <div class="mb-4">
                        <label for="nama_menu" class="min-w-28 mr-4 inline-block font-medium">Nama Menu</label>
                        <input x-ref="nama_menu" x-model="nama_menu" type="text" name="nama_menu" id="nama_menu"
                            class="rounded bg-gray-100 px-4 py-2 shadow outline-none">
                    </div>
                    <div class="mb-4">
                        <label for="harga" class="min-w-28 mr-4 inline-block font-medium">Harga Menu</label>
                        <input x-ref="harga" x-model="harga" type="text" name="harga" id="harga"
                            class="rounded bg-gray-100 px-4 py-2 shadow outline-none">
                    </div>
                    <button
                        class="w-full rounded bg-blue-500 px-4 py-2 font-medium text-white shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</x-dashboard-layout>
