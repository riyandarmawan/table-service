<x-dashboard-layout :$title>
    <div x-data="{ showModalHapus: false }">
        <form action="/pesanan/update/{{ $idPesanan }}" method="POST">
            <div class="p-4">
                <div class="flex flex-nowrap gap-4">
                    <div class="h-fit rounded-md border bg-white p-4 shadow">
                        <h1 class="mb-4 text-3xl font-bold">Detail Pesanan</h1>
                        @csrf
                        <div x-data="{ id_pesanan: '{{ $errors->has('id_pesanan') ? $idPesanan : old('id_pesanan', $idPesanan) }}' }" class="mb-4">
                            <label for="id_pesanan" class="min-w-28 mr-4 inline-block font-medium">Kode Pesanan</label>
                            <input type="text" name="id_pesanan" id="id_pesanan" x-model="id_pesanan" readonly
                                {{ $errors->has('id_pesanan') ? 'focused' : '' }} required
                                class="{{ $errors->has('id_pesanan') ? 'input-invalid' : 'input-valid' }} w-full rounded border bg-gray-100 px-4 py-2 shadow outline-none focus:ring">
                            @error('id_pesanan')
                                <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div x-data="{ id_meja: '{{ $errors->has('id_meja') ? $pesanan->meja->id_meja : old('id_meja', $pesanan->meja->id_meja) }}' }" class="mb-4">
                            <label for="id_meja" class="min-w-28 mr-4 inline-block font-medium">Kode Meja</label>
                            <div class="flex items-center gap-2">
                                <input type="text" name="id_meja" id="id_meja" x-model="id_meja"
                                    :value="id_meja" @input="findTable(id_meja || 0)" x-init="findTable();
                                    setSelectedRows('id_meja', id_meja)"
                                    {{ $errors->has('id_meja') ? 'focused' : '' }} required
                                    class="{{ $errors->has('nama_pesanan') ? 'input-invalid' : 'input-valid' }} w-full rounded border bg-gray-100 px-4 py-2 shadow outline-none focus:ring">
                                <button @click="findTable()" type="button"
                                    class="rounded bg-gray-200 px-2 py-1 shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80">
                                    <span class="i-mdi-globe mt-1 text-2xl"></span>
                                </button>
                            </div>
                            @error('id_meja')
                                <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div x-data="{ id_pelanggan: '{{ $errors->has('id_pelanggan') ? $pesanan->pelanggan->id_pelanggan : old('id_pelanggan', $pesanan->pelanggan->id_pelanggan) }}' }" class="mb-4">
                            <label for="id_pelanggan" class="min-w-28 mr-4 inline-block font-medium">Kode
                                Pelanggan</label>
                            <div class="flex items-center gap-2">
                                <input type="text" name="id_pelanggan" id="id_pelanggan" x-model="id_pelanggan"
                                    :value="id_pelanggan" @input="findCustomer(id_pelanggan || 0)"
                                    x-init="setSelectedRows('id_pelanggan', id_pelanggan)" {{ $errors->has('id_pelanggan') ? 'focused' : '' }}
                                    required
                                    class="{{ $errors->has('nama_pesanan') ? 'input-invalid' : 'input-valid' }} w-full rounded border bg-gray-100 px-4 py-2 shadow outline-none focus:ring">
                                <button @click="findCustomer()" type="button"
                                    class="rounded bg-gray-200 px-2 py-1 shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80">
                                    <span class="i-mdi-globe mt-1 text-2xl"></span>
                                </button>
                            </div>
                            @error('id_pelanggan')
                                <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div x-data="{ searchMenu: '{{ $errors->has('searchMenu') ? $pesanan->pelanggan->searchMenu : old('searchMenu', $pesanan->pelanggan->searchMenu) }}' }" class="mb-4">
                            <label for="searchMenu" class="min-w-28 mr-4 inline-block font-medium">Cari Menu</label>
                            <div class="flex items-center gap-2">
                                <input type="text" id="searchMenu" x-model="searchMenu"
                                    :value="searchMenu" @input="findMenu(searchMenu || 0)"
                                    class="{{ $errors->has('nama_pesanan') ? 'input-invalid' : 'input-valid' }} w-full rounded border bg-gray-100 px-4 py-2 shadow outline-none focus:ring">
                                <button @click="findMenu()" type="button"
                                    class="rounded bg-gray-200 px-2 py-1 shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80">
                                    <span class="i-mdi-globe mt-1 text-2xl"></span>
                                </button>
                            </div>
                            @error('searchMenu')
                                <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div x-data="{ searchChosenMenu: '{{ $errors->has('searchChosenMenu') ? $pesanan->pelanggan->searchChosenMenu : old('searchChosenMenu', $pesanan->pelanggan->searchChosenMenu) }}' }" class="mb-4">
                            <label for="searchChosenMenu" class="min-w-28 mr-4 inline-block font-medium">Cari menu yang telah dipilih</label>
                            <div class="flex items-center gap-2">
                                <input type="text" id="searchChosenMenu" x-model="searchChosenMenu"
                                    :value="searchChosenMenu" @input="viewChosenMenus(searchChosenMenu || 0)"
                                    x-init="currentChosenMenus('{{ $idPesanan }}')"
                                    {{ $errors->has('searchChosenMenu') ? 'focused' : '' }}
                                    class="{{ $errors->has('nama_pesanan') ? 'input-invalid' : 'input-valid' }} w-full rounded border bg-gray-100 px-4 py-2 shadow outline-none focus:ring">
                                <button @click="viewChosenMenus()" type="button"
                                    class="rounded bg-gray-200 px-2 py-1 shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80">
                                    <span class="i-mdi-globe mt-1 text-2xl"></span>
                                </button>
                            </div>
                            @error('searchChosenMenu')
                                <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex flex-col gap-4">
                            <input type="hidden" id="id_user" name="id_user" value="{{ Auth::user()->id }}">
                            <button
                                class="w-full rounded bg-blue-500 px-4 py-2 font-medium text-white shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80">Ubah
                                pesanan</button>
                            <button type="button" @click="showModalHapus = !showModalHapus"
                                class="w-full rounded bg-red-500 px-4 py-2 font-medium text-white shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80">Hapus
                                pesanan</button>
                            <a href="/pesanan"
                                class="w-full rounded bg-blue-500 px-4 py-2 font-medium text-white shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80">Kembali ke daftar pesanan</a>
                        </div>
                    </div>

                    <div id="data-finder-box" class="relative w-full overflow-y-auto rounded border p-4 shadow"
                        style="height: calc(100vh - 120px)">
                    </div>
                </div>
            </div>
        </form>

        <x-modal modalName="Hapus" bodyText="Peringatan apakah anda yakin ingin menghapus pesanan ini?"
            href="/pesanan/delete/{{ $idPesanan ?? '' }}" confirmText="Ya, saya ingin menghapusnya"
            cancelText="Tidak"></x-modal>
    </div>

    <script src="/js/pesanan.js"></script>
</x-dashboard-layout>
