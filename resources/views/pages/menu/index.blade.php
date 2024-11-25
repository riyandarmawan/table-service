<x-dashboard-layout :$title>
    <div x-data="{ showModalHapus: false }" class="p-4">
        <h1 class="mb-6 text-3xl font-bold">{{ $title }}</h1>

        <div class="flex flex-nowrap gap-4">
            <div class="min-w-72 h-fit rounded-md border bg-white p-4 shadow">
                <h1 class="mb-4 text-3xl font-bold">Tambah Menu</h1>
                <form action="{{ Request::is('menu') ? '/menu/create' : '/menu/update/' . $idMenu }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="id_menu" class="min-w-28 mr-4 inline-block font-medium">Kode Menu</label>
                        <input type="text" name="id_menu" id="id_menu"
                            value="{{ $errors->has('id_menu') ? $idMenu : old('id_menu', $idMenu) }}" readonly
                            {{ $errors->has('id_menu') ? 'focused' : '' }} required
                            class="{{ $errors->has('id_menu') ? 'input-invalid' : 'input-valid' }} w-full rounded border bg-gray-100 px-4 py-2 shadow outline-none focus:ring">
                        @error('id_menu')
                            <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="nama_menu" class="min-w-28 mr-4 inline-block font-medium">Nama Menu</label>
                        <input type="text" name="nama_menu" id="nama_menu"
                            value="{{ $errors->has('nama_menu') ? $menu->nama_menu ?? '' : old('nama_menu', $menu->nama_menu ?? '') }}"
                            {{ $errors->has('nama_menu') ? 'focused' : '' }} required
                            class="{{ $errors->has('nama_menu') ? 'input-invalid' : 'input-valid' }} w-full rounded border bg-gray-100 px-4 py-2 shadow outline-none focus:ring">
                        @error('nama_menu')
                            <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div x-data="{ harga: window.formatToIdr({{ $menu->harga ?? '' }}) || 'Rp. 0' }" class="mb-4">
                        <label for="harga" class="min-w-28 mr-4 inline-block font-medium">Harga Menu</label>
                        <input type="text" name="harga" id="harga" x-model="harga"
                            @input="harga = window.formatToIdr(harga)" :value="harga"
                            value="{{ $errors->has('harga') ? $menu->harga ?? '' : old('harga', $menu->harga ?? '') }}"
                            {{ $errors->has('harga') ? 'focused' : '' }} required
                            class="{{ $errors->has('harga') ? 'input-invalid' : 'input-valid' }} w-full rounded border bg-gray-100 px-4 py-2 shadow outline-none focus:ring">
                        @error('harga')
                            <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    @if (Request::is('menu'))
                        <button
                            class="w-full rounded bg-blue-500 px-4 py-2 font-medium text-white shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80">Tambah</button>
                    @else
                        <div class="grid gap-2">
                            <button
                                class="w-full rounded bg-yellow-500 px-4 py-2 font-medium shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80">Ubah
                                pilihan</button>
                            <button @click="showModalHapus = !showModalHapus" type="button"
                                class="w-full rounded bg-red-500 px-4 py-2 font-medium text-white shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80">Hapus
                                pilihan</button>
                            <a href="/menu"
                                class="w-full rounded bg-blue-500 px-4 py-2 text-center font-medium text-white shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80">Batalkan
                                pilihan</a>
                        </div>
                    @endif
                </form>
            </div>

            <div class="w-full overflow-y-auto" style="height: calc(100vh - 180px)">
                <table class="w-full table-auto border-collapse mb-4">
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
                                <td x-text="window.formatToIdr({{ $menu->harga }})"></td>
                                <td>
                                    <a href="/menu/choice/{{ $menu->id_menu }}"
                                        class="inline-block rounded bg-blue-500 px-4 py-2 text-lg font-medium text-white shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80">Pilih</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $menus->links() }}
            </div>
        </div>

        @if (!Request::is('menu'))
            <x-modal modalName="Hapus" bodyText="Peringatan apakah anda yakin ingin menghapus menu ini?"
                href="/menu/delete/{{ $idMenu ?? '' }}" confirmText="Ya, saya ingin menghapusnya"
                cancelText="Tidak"></x-modal>
        @endif
    </div>
</x-dashboard-layout>
