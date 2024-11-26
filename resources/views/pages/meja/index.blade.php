<x-dashboard-layout :$title>
    <div x-data="{ showModalHapus: false }" class="p-4">
        <h1 class="mb-6 text-3xl font-bold">{{ $title }}</h1>

        <div class="flex flex-nowrap gap-4">
            <div class="min-w-72 h-fit rounded-md border bg-white p-4 shadow">
                <h1 class="mb-4 text-3xl font-bold">{{ Request::is('meja') ? 'Tambah' : 'Ubah' }} Meja</h1>
                <form action="{{ Request::is('meja') ? '/meja/create' : '/meja/update/' . $idMeja }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="id_meja" class="min-w-28 mr-4 inline-block font-medium">Kode Meja</label>
                        <input type="text" name="id_meja" id="id_meja"
                            value="{{ $errors->has('id_meja') ? $idMeja : old('id_meja', $idMeja) }}" readonly
                            {{ $errors->has('id_meja') ? 'focused' : '' }} required
                            class="{{ $errors->has('id_meja') ? 'input-invalid' : 'input-valid' }} w-full rounded border bg-gray-100 px-4 py-2 shadow outline-none focus:ring">
                        @error('id_meja')
                            <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="kapasitas_kursi" class="min-w-28 mr-4 inline-block font-medium">Kapasitas
                            Kursi</label>
                        <input type="text" name="kapasitas_kursi" id="kapasitas_kursi"
                            value="{{ $errors->has('kapasitas_kursi') ? '' : old('kapasitas_kursi', '') }}"
                            {{ $errors->has('kapasitas_kursi') ? 'focused' : '' }} required
                            class="{{ $errors->has('kapasitas_kursi') ? 'input-invalid' : 'input-valid' }} w-full rounded border bg-gray-100 px-4 py-2 shadow outline-none focus:ring">
                        @error('kapasitas_kursi')
                            <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    @if (Request::is('meja'))
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
                            <a href="/meja"
                                class="w-full rounded bg-blue-500 px-4 py-2 text-center font-medium text-white shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80">Batalkan
                                pilihan</a>
                        </div>
                    @endif
                </form>
            </div>

            <div class="w-full overflow-y-auto" style="height: calc(100vh - 180px)">
                <table class="mb-4 w-full table-auto border-collapse">
                    <thead>
                        <th>Kode Meja</th>
                        <th>Kapasitas Kursi</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        @foreach ($mejas as $meja)
                            <tr>
                                <td>{{ $meja->id_meja }}</td>
                                <td x-text="window.chairCapacity('{{ $meja->kapasitas_kursi }}')"></td>
                                <td>
                                    <a href="/meja/choice/{{ $meja->id_meja }}"
                                        class="inline-block rounded bg-blue-500 px-4 py-2 text-lg font-medium text-white shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80">Pilih</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $mejas->links() }}
            </div>
        </div>

        @if (!Request::is('meja'))
            <x-modal modalName="Hapus" bodyText="Peringatan apakah anda yakin ingin menghapus meja ini?"
                href="/meja/delete/{{ $idMeja ?? '' }}" confirmText="Ya, saya ingin menghapusnya"
                cancelText="Tidak"></x-modal>
        @endif
    </div>
</x-dashboard-layout>
