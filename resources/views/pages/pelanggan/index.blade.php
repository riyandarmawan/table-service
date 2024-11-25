<x-dashboard-layout :$title>
    <div x-data="{ showModalHapus: false }" class="p-4">
        <h1 class="mb-6 text-3xl font-bold">{{ $title }}</h1>

        <div class="flex flex-nowrap gap-4">
            <div class="min-w-72 h-fit rounded-md border bg-white p-4 shadow overflow-y-auto" style="max-height: calc(100vh - 180px)">
                <h1 class="mb-4 text-3xl font-bold">Tambah Pelanggan</h1>
                <form action="{{ Request::is('pelanggan') ? '/pelanggan/create' : '/pelanggan/update/' . $idPelanggan }}"
                    method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="id_pelanggan" class="min-w-28 mr-4 inline-block font-medium">Kode Pelanggan</label>
                        <input type="text" name="id_pelanggan" id="id_pelanggan"
                            value="{{ $errors->has('id_pelanggan') ? $idPelanggan : old('id_pelanggan', $idPelanggan) }}"
                            readonly {{ $errors->has('id_pelanggan') ? 'focused' : '' }} required
                            class="{{ $errors->has('id_pelanggan') ? 'input-invalid' : 'input-valid' }} w-full rounded border bg-gray-100 px-4 py-2 shadow outline-none focus:ring">
                        @error('id_pelanggan')
                            <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="nama_pelanggan" class="min-w-28 mr-4 inline-block font-medium">Nama
                            Pelanggan</label>
                        <input type="text" name="nama_pelanggan" id="nama_pelanggan"
                            value="{{ $errors->has('nama_pelanggan') ? $pelanggan->nama_pelanggan ?? '' : old('nama_pelanggan', $pelanggan->nama_pelanggan ?? '') }}"
                            {{ $errors->has('nama_pelanggan') ? 'focused' : '' }} required
                            class="{{ $errors->has('nama_pelanggan') ? 'input-invalid' : 'input-valid' }} w-full rounded border bg-gray-100 px-4 py-2 shadow outline-none focus:ring">
                        @error('nama_pelanggan')
                            <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="jenis_kelamin" class="min-w-28 mr-4 inline-block font-medium">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin"
                            {{ $errors->has('jenis_kelamin') ? 'focused' : '' }} required
                            class="{{ $errors->has('jenis_kelamin') ? 'input-invalid' : 'input-valid' }} w-full rounded border bg-gray-100 px-4 py-2 shadow outline-none focus:ring">
                            <option
                                {{ $errors->has('jenis_kelamin') ? ($pelanggan->jenis_kelamin === 'l' ? 'selected' : '') : (old('jenis_kelamin') === 'l' ? 'selected' : '') }}
                                value="l">Laki-laki</option>
                            <option
                                {{ $errors->has('jenis_kelamin') ? ($pelanggan->jenis_kelamin === 'p' ? 'selected' : '') : (old('jenis_kelamin') === 'p' ? 'selected' : '') }}
                                value="p">Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="no_hp" class="min-w-28 mr-4 inline-block font-medium">No HP</label>
                        <input type="text" inputmode="numeric" name="no_hp" id="no_hp"
                            value="{{ $errors->has('no_hp') ? $pelanggan->no_hp ?? '' : old('no_hp', $pelanggan->no_hp ?? '') }}"
                            {{ $errors->has('no_hp') ? 'focused' : '' }} required
                            class="{{ $errors->has('no_hp') ? 'input-invalid' : 'input-valid' }} w-full rounded border bg-gray-100 px-4 py-2 shadow outline-none focus:ring">
                        @error('no_hp')
                            <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="alamat" class="min-w-28 mr-4 inline-block font-medium">Alamat</label>
                        <textarea type="text" name="alamat" id="alamat" {{ $errors->has('alamat') ? 'focused' : '' }} required
                            class="{{ $errors->has('alamat') ? 'input-invalid' : 'input-valid' }} w-full rounded border bg-gray-100 px-4 py-2 shadow outline-none focus:ring">
                            {{ $errors->has('alamat') ? ($pelanggan->alamat ?? '') : old('alamat', $pelanggan->alamat ?? '') }}
                        </textarea>
                        @error('alamat')
                            <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    @if (Request::is('pelanggan'))
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
                            <a href="/pelanggan"
                                class="w-full rounded bg-blue-500 px-4 py-2 text-center font-medium text-white shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80">Batalkan
                                pilihan</a>
                        </div>
                    @endif
                </form>
            </div>

            <div class="w-full overflow-y-auto" style="height: calc(100vh - 180px)">
                <table class="w-full table-auto border-collapse mb-4">
                    <thead>
                        <th>Kode Pelanggan</th>
                        <th>Nama Pelanggan</th>
                        <th>Jenis Kelamin</th>
                        <th>No HP</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        @foreach ($pelanggans as $pelanggan)
                            <tr>
                                <td>{{ $pelanggan->id_pelanggan }}</td>
                                <td>{{ $pelanggan->nama_pelanggan }}</td>
                                <td x-text="window.gender('{{ $pelanggan->jenis_kelamin }}')"></td>
                                <td>{{ $pelanggan->no_hp }}</td>
                                <td>{{ $pelanggan->alamat }}</td>
                                <td>
                                    <a href="/pelanggan/choice/{{ $pelanggan->id_pelanggan }}"
                                        class="inline-block rounded bg-blue-500 px-4 py-2 text-lg font-medium text-white shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80">Pilih</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $pelanggans->links() }}
            </div>
        </div>

        @if (!Request::is('pelanggan'))
            <x-modal modalName="Hapus" bodyText="Peringatan apakah anda yakin ingin menghapus pelanggan ini?"
                href="/pelanggan/delete/{{ $idPelanggan ?? '' }}" confirmText="Ya, saya ingin menghapusnya"
                cancelText="Tidak"></x-modal>
        @endif
    </div>
</x-dashboard-layout>
