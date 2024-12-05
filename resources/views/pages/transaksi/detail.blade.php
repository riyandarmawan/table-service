<x-dashboard-layout :$title>
    <div x-data="{ showModalHapus: false }">
    <form action="/transaksi/update/{{ $idTransaksi }}" method="POST">
        <div class="p-4">
            <div class="flex flex-nowrap gap-4">
                <div class="overflow-y-scroll rounded-md border bg-white p-4 shadow" style="height: calc(100vh - 120px)">
                    <h1 class="mb-4 text-3xl font-bold">Detail Transaksi</h1>
                    @csrf
                    <div class="mb-4">
                        <label for="id_transaksi" class="min-w-28 mr-4 inline-block font-medium">Kode Transaksi</label>
                        <input type="text" name="id_transaksi" id="id_transaksi"
                            value="{{ $errors->has('id_transaksi') ? $idTransaksi : old('id_transaksi', $idTransaksi) }}"
                            readonly {{ $errors->has('id_transaksi') ? 'focused' : '' }} required
                            class="{{ $errors->has('id_transaksi') ? 'input-invalid' : 'input-valid' }} w-full rounded border bg-gray-100 px-4 py-2 shadow outline-none focus:ring">
                        @error('id_transaksi')
                            <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div x-data="{ id_pesanan: '{{ $errors->has('id_pesanan') ? $transaksi->id_pesanan : old('id_pesanan', $transaksi->id_pesanan) }}' }" class="mb-4">
                        <label for="id_pesanan" class="min-w-28 mr-4 inline-block font-medium">Kode Pesanan</label>
                        <div class="flex items-center gap-2">
                            <input type="text" name="id_pesanan" id="id_pesanan" x-model="id_pesanan"
                                :value="id_pesanan" @input="findOrder(id_pesanan || 0)" x-init="{{ old('id_pesanan') ? 'showMenus(id_pesanan)' : 'showMenus(id_pesanan)' }}"
                                {{ $errors->has('id_pesanan') ? 'focused' : '' }} required
                                class="{{ $errors->has('nama_transaksi') ? 'input-invalid' : 'input-valid' }} w-full rounded border bg-gray-100 px-4 py-2 shadow outline-none focus:ring">
                            <button @click="findOrder()" type="button"
                                class="rounded bg-gray-200 px-2 py-1 shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80">
                                <span class="i-mdi-globe mt-1 text-2xl"></span>
                            </button>
                        </div>
                        @error('id_pesanan')
                            <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div x-data="{ total: window.formatToIdr('{{ $errors->has('total') ? $transaksi->total : old('total', $transaksi->total) }}') || 'Rp. 0' }" class="mb-4">
                        <label for="total" class="min-w-28 mr-4 inline-block font-medium">Total Harga</label>
                        <input type="text" name="total" id="total" x-model="total"
                            @input="total = window.formatToIdr(total)" :value="total"
                            {{ $errors->has('total') ? 'focused' : '' }} readonly required
                            class="{{ $errors->has('total') ? 'input-invalid' : 'input-valid' }} w-full rounded border bg-gray-100 px-4 py-2 shadow outline-none focus:ring">
                        @error('total')
                            <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div x-data="{ bayar: window.formatToIdr('{{ $errors->has('bayar') ? $transaksi->bayar : old('bayar', $transaksi->bayar) }}') || 'Rp. 0' }" class="mb-4">
                        <label for="bayar" class="min-w-28 mr-4 inline-block font-medium">Bayar</label>
                        <input type="text" name="bayar" id="bayar" x-model="bayar"
                            @input="bayar = window.formatToIdr(bayar); updateKembalian(bayar)" :value="bayar"
                            {{ $errors->has('bayar') ? 'focused' : '' }} required
                            class="{{ $errors->has('bayar') ? 'input-invalid' : 'input-valid' }} w-full rounded border bg-gray-100 px-4 py-2 shadow outline-none focus:ring">
                        @error('bayar')
                            <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div x-data="{ kembalian: window.formatToIdr('{{ $errors->has('kembalian') ? $transaksi->kembalian : old('kembalian', $transaksi->kembalian) }}') || 'Rp. 0' }" class="mb-4">
                        <label for="kembalian" class="min-w-28 mr-4 inline-block font-medium">Kembalian</label>
                        <input type="text" name="kembalian" id="kembalian" x-model="kembalian"
                            @input="kembalian = window.formatToIdr(kembalian)" :value="kembalian"
                            {{ $errors->has('kembalian') ? 'focused' : '' }} readonly required
                            class="{{ $errors->has('kembalian') ? 'input-invalid' : 'input-valid' }} w-full rounded border bg-gray-100 px-4 py-2 shadow outline-none focus:ring">
                        @error('kembalian')
                            <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-4">
                        <button
                            class="w-full rounded bg-yellow-500 px-4 py-2 font-medium shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80">Ubah
                            transaksi</button>
                            <button type="button" @click="showModalHapus = !showModalHapus" class="button-delete">Hapus transaksi</button>
                        <a href="/transaksi"
                            class="w-full rounded bg-blue-500 px-4 py-2 text-center font-medium text-white shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80">Kembali
                            ke daftar transaksi</a>
                    </div>
                </div>

                <div id="data-finder-box" class="relative w-full overflow-y-auto rounded border p-4 shadow"
                    style="height: calc(100vh - 120px)">
                </div>
            </div>
        </div>
    </form>
    <x-modal modalName="Hapus" bodyText="Peringatan apakah anda yakin ingin menghapus transaksi ini?"
            href="/transaksi/delete/{{ $idTransaksi ?? '' }}" confirmText="Ya, saya ingin menghapusnya"
            cancelText="Tidak"></x-modal>
</div>

    <script src="/js/transaksi.js"></script>
</x-dashboard-layout>
