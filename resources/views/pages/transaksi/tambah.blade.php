<x-dashboard-layout :$title>
    <form action="" method="POST">
        <div class="p-4">
            <div class="flex flex-nowrap gap-4">
                <div class="overflow-y-scroll rounded-md border bg-white p-4 shadow" style="height: calc(100vh - 120px)">
                    <h1 class="mb-4 text-3xl font-bold">Tambah Transaksi</h1>
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
                    <div x-data="{ id_pesanan: '{{ $errors->has('id_pesanan') ? '' : old('id_pesanan') }}' }" class="mb-4">
                        <label for="id_pesanan" class="min-w-28 mr-4 inline-block font-medium">Kode Pesanan</label>
                        <div class="flex items-center gap-2">
                            <input type="text" name="id_pesanan" id="id_pesanan" x-model="id_pesanan" :value="id_pesanan"
                                @input="findOrder(id_pesanan || 0)" x-init="findOrder()"
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
                    <div x-data="{ total: window.formatToIdr({{ $menu->total ?? '' }}) || 'Rp. 0' }" class="mb-4">
                        <label for="total" class="min-w-28 mr-4 inline-block font-medium">Total Harga</label>
                        <input type="text" name="total" id="total" x-model="total"
                            @input="total = window.formatToIdr(total)" :value="total"
                            value="{{ $errors->has('total') ? $menu->total ?? '' : old('total', $menu->total ?? '') }}"
                            {{ $errors->has('total') ? 'focused' : '' }} readonly required
                            class="{{ $errors->has('total') ? 'input-invalid' : 'input-valid' }} w-full rounded border bg-gray-100 px-4 py-2 shadow outline-none focus:ring">
                        @error('total')
                            <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div x-data="{ bayar: window.formatToIdr({{ $menu->bayar ?? '' }}) || 'Rp. 0' }" class="mb-4">
                        <label for="bayar" class="min-w-28 mr-4 inline-block font-medium">Bayar</label>
                        <input type="text" name="bayar" id="bayar" x-model="bayar"
                            @input="bayar = window.formatToIdr(bayar); updateKembalian(bayar)" :value="bayar"
                            value="{{ $errors->has('bayar') ? $menu->bayar ?? '' : old('bayar', $menu->bayar ?? '') }}"
                            {{ $errors->has('bayar') ? 'focused' : '' }} required
                            class="{{ $errors->has('bayar') ? 'input-invalid' : 'input-valid' }} w-full rounded border bg-gray-100 px-4 py-2 shadow outline-none focus:ring">
                        @error('bayar')
                            <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div x-data="{ kembalian: window.formatToIdr({{ $menu->kembalian ?? '' }}) || 'Rp. 0' }" class="mb-4">
                        <label for="kembalian" class="min-w-28 mr-4 inline-block font-medium">Kembalian</label>
                        <input type="text" name="kembalian" id="kembalian" x-model="kembalian"
                            @input="kembalian = window.formatToIdr(kembalian)" :value="kembalian"
                            value="{{ $errors->has('kembalian') ? $menu->kembalian ?? '' : old('kembalian', $menu->kembalian ?? '') }}"
                            {{ $errors->has('kembalian') ? 'focused' : '' }} readonly required
                            class="{{ $errors->has('kembalian') ? 'input-invalid' : 'input-valid' }} w-full rounded border bg-gray-100 px-4 py-2 shadow outline-none focus:ring">
                        @error('kembalian')
                            <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-4">
                        <button
                            class="w-full rounded bg-blue-500 px-4 py-2 font-medium text-white shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80">Tambahkan
                            transaksi</button>
                        <a href="/transaksi"
                            class="w-full rounded bg-blue-500 px-4 py-2 font-medium text-white shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80 text-center">Kembali
                            ke daftar transaksi</a>
                    </div>
                </div>

                <div id="data-finder-box" class="relative w-full overflow-y-auto rounded border p-4 shadow"
                    style="height: calc(100vh - 120px)">
                </div>
            </div>
        </div>
    </form>

    <script>
        @if ($errors->any())
            const errors = @json($errors->all());
            errors.forEach(error => {
                window.errorAlert(error); // Display each error using your error notification system
            });
        @endif
    </script>

    <script src="/js/transaksi.js"></script>
</x-dashboard-layout>
