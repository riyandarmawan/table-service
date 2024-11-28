<x-dashboard-layout :$title>
    <div x-data="{ showModalHapus: false }" class="p-4">
        <div class="flex flex-nowrap gap-4">
            <div class="h-fit rounded-md border bg-white p-4 shadow">
                <h1 class="mb-4 text-3xl font-bold">{{ Request::is('meja') ? 'Tambah' : 'Ubah' }} Pesanan</h1>
                <form action="/pesanan/update/{{ $pesanan->id_pesanan }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="id_pesanan" class="min-w-28 mr-4 inline-block font-medium">Kode Pesanan</label>
                        <input type="text" name="id_pesanan" id="id_pesanan"
                            value="{{ $errors->has('id_pesanan') ? $pesanan->id_pesanan : old('id_pesanan', $pesanan->id_pesanan) }}"
                            readonly {{ $errors->has('id_pesanan') ? 'focused' : '' }} required
                            class="{{ $errors->has('id_pesanan') ? 'input-invalid' : 'input-valid' }} w-full rounded border bg-gray-100 px-4 py-2 shadow outline-none focus:ring">
                        @error('id_pesanan')
                            <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div x-data="{ id_meja: '{{ $errors->has('id_meja') ? $pesanan->meja->id_meja ?? '' : old('id_meja', $pesanan->meja->id_meja ?? '') }}' }" class="mb-4">
                        <label for="id_meja" class="min-w-28 mr-4 inline-block font-medium">Kode Meja</label>
                        <div class="flex items-center gap-2">
                            <input type="text" name="id_meja" id="id_meja" x-model="id_meja" :value="id_meja"
                                @input="mejaFinder(id_meja || 0)" x-init="mejaFinder()"
                                {{ $errors->has('id_meja') ? 'focused' : '' }} required
                                class="{{ $errors->has('nama_pesanan') ? 'input-invalid' : 'input-valid' }} w-full rounded border bg-gray-100 px-4 py-2 shadow outline-none focus:ring">
                            <button @click="mejaFinder()" type="button"
                                class="rounded bg-gray-200 px-2 py-1 shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80">
                                <span class="i-mdi-globe mt-1 text-2xl"></span>
                            </button>
                        </div>
                        @error('id_meja')
                            <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div x-data="{ id_pelanggan: '{{ $errors->has('id_pelanggan') ? $pesanan->pelanggan->id_pelanggan ?? '' : old('id_pelanggan', $pesanan->pelanggan->id_pelanggan ?? '') }}' }" class="mb-4">
                        <label for="id_pelanggan" class="min-w-28 mr-4 inline-block font-medium">Kode Pelanggan</label>
                        <div class="flex items-center gap-2">
                            <input type="text" name="id_pelanggan" id="id_pelanggan" x-model="id_pelanggan"
                                :value="id_pelanggan" @input="pelangganFinder(id_pelanggan || 0)"
                                {{ $errors->has('id_pelanggan') ? 'focused' : '' }} required
                                class="{{ $errors->has('nama_pesanan') ? 'input-invalid' : 'input-valid' }} w-full rounded border bg-gray-100 px-4 py-2 shadow outline-none focus:ring">
                            <button @click="pelangganFinder()" type="button"
                                class="rounded bg-gray-200 px-2 py-1 shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80">
                                <span class="i-mdi-globe mt-1 text-2xl"></span>
                            </button>
                        </div>
                        @error('id_pelanggan')
                            <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div x-data="{ id_menu: '{{ $errors->has('id_menu') ? $pesanan->menu->id_menu ?? '' : old('id_menu', $pesanan->menu->id_menu ?? '') }}' }" class="mb-4">
                        <label for="id_menu" class="min-w-28 mr-4 inline-block font-medium">Kode Menu</label>
                        <div class="flex items-center gap-2">
                            <input type="text" name="id_menu" id="id_menu" x-model="id_menu" :value="id_menu"
                                @input="menuFinder(id_menu || 0)" {{ $errors->has('id_menu') ? 'focused' : '' }}
                                required
                                class="{{ $errors->has('nama_pesanan') ? 'input-invalid' : 'input-valid' }} w-full rounded border bg-gray-100 px-4 py-2 shadow outline-none focus:ring">
                            <button @click="menuFinder()" type="button"
                                class="rounded bg-gray-200 px-2 py-1 shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80">
                                <span class="i-mdi-globe mt-1 text-2xl"></span>
                            </button>
                        </div>
                        @error('id_menu')
                            <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="jumlah" class="min-w-28 mr-4 inline-block font-medium">Jumlah</label>
                        <input type="text" name="jumlah" id="jumlah"
                            value="{{ $errors->has('jumlah') ? $pesanan->jumlah ?? '' : old('jumlah', $pesanan->jumlah ?? '') }}"
                            {{ $errors->has('jumlah') ? 'focused' : '' }} required
                            class="{{ $errors->has('jumlah') ? 'input-invalid' : 'input-valid' }} w-full rounded border bg-gray-100 px-4 py-2 shadow outline-none focus:ring">
                        @error('jumlah')
                            <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <input type="hidden" id="id_user" name="id_user" value="{{ Auth::user()->id }}">
                    <div class="grid gap-2">
                        <button
                            class="w-full rounded bg-yellow-500 px-4 py-2 font-medium shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80">Ubah
                            pilihan</button>
                        <button @click="showModalHapus = !showModalHapus" type="button"
                            class="w-full rounded bg-red-500 px-4 py-2 font-medium text-white shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80">Hapus
                            pilihan</button>
                        <a href="/pesanan"
                            class="w-full rounded bg-blue-500 px-4 py-2 text-center font-medium text-white shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80">Batalkan
                            pilihan</a>
                    </div>
                </form>
            </div>

            <div id="data-finder-box" class="relative w-full overflow-y-auto rounded border p-4 shadow"
                style="height: calc(100vh - 120px)">
            </div>
        </div>
        <x-modal modalName="Hapus" bodyText="Peringatan apakah anda yakin ingin menghapus pesanan ini?"
            href="/pesanan/delete/{{ $pesanan->id_pesanan ?? '' }}" confirmText="Ya, saya ingin menghapusnya"
            cancelText="Tidak"></x-modal>
    </div>

    <script src="/js/pesanan.js"></script>
</x-dashboard-layout>
