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
                @foreach ($menus as $menu)
                <tr>
                    <td>{{ $menu->id_menu }}</td>
                    <td>{{ $menu->nama_menu }}</td>
                    <td>{{ $menu->harga }}</td>
                    <td>
                        <a href="/menu/detail/{{ $menu->id_menu }}"
                            class="inline-block rounded bg-blue-500 px-4 py-2 text-lg font-medium text-white shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div x-show="showModalTambah" x-cloak
            class="absolute inset-0 z-20 flex items-center justify-center bg-gray-500 bg-opacity-50">
            <div @click.outside="showModalTambah = false" class="rounded-md border bg-white p-4 shadow">
                <h1 class="mb-4 text-3xl font-bold">Tambah Menu</h1>
                <form action="/menu/tambah" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="id_menu" class="min-w-28 mr-4 inline-block font-medium">Kode Menu</label>
                        <input type="text" name="id_menu" id="id_menu"
                            value="{{ $errors->has('id_menu') ? '' : old('id_menu') }}"
                            {{ $errors->has('id_menu') ? 'focused' : '' }} required
                            class="{{ $errors->has('id_menu') ? 'input-invalid' : 'input-valid' }} rounded border bg-gray-100 px-4 py-2 shadow outline-none focus:ring">
                    @error('id_menu')
                        <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                    @enderror
                    </div>
                    <div class="mb-4">
                        <label for="nama_menu" class="min-w-28 mr-4 inline-block font-medium">Nama Menu</label>
                        <input type="text" name="nama_menu" id="nama_menu"
                            value="{{ $errors->has('nama_menu') ? '' : old('nama_menu') }}"
                            {{ $errors->has('nama_menu') ? 'focused' : '' }} required
                            class="{{ $errors->has('nama_menu') ? 'input-invalid' : 'input-valid' }} rounded border bg-gray-100 px-4 py-2 shadow outline-none focus:ring">
                    @error('nama_menu')
                        <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                    @enderror
                    </div>
                    <div class="mb-4">
                        <label for="harga" class="min-w-28 mr-4 inline-block font-medium">Harga Menu</label>
                        <input type="text" name="harga" id="harga"
                            value="{{ $errors->has('harga') ? '' : old('harga') }}"
                            {{ $errors->has('harga') ? 'focused' : '' }} required
                            class="{{ $errors->has('harga') ? 'input-invalid' : 'input-valid' }} rounded border bg-gray-100 px-4 py-2 shadow outline-none focus:ring">
                    @error('harga')
                        <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                    @enderror
                    </div>
                    <button
                        class="w-full rounded bg-blue-500 px-4 py-2 font-medium text-white shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</x-dashboard-layout>
