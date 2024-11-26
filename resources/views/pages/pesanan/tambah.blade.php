<x-dashboard-layout :$title>
    <div class="p-4">
        <div class="grid grid-cols-2 gap-4">
            <div class="h-fit rounded-md border bg-white p-4 shadow">
                <h1 class="mb-4 text-3xl font-bold">{{ Request::is('meja') ? 'Tambah' : 'Ubah' }} Pesanan</h1>
                <form action="{{ Request::is('pesanan') ? '/pesanan/create' : '/pesanan/update/' . $idPesanan }}"
                    method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="id_pesanan" class="min-w-28 mr-4 inline-block font-medium">Kode Pesanan</label>
                        <input type="text" name="id_pesanan" id="id_pesanan"
                            value="{{ $errors->has('id_pesanan') ? $idPesanan : old('id_pesanan', $idPesanan) }}"
                            readonly {{ $errors->has('id_pesanan') ? 'focused' : '' }} required
                            class="{{ $errors->has('id_pesanan') ? 'input-invalid' : 'input-valid' }} w-full rounded border bg-gray-100 px-4 py-2 shadow outline-none focus:ring">
                        @error('id_pesanan')
                            <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="nama_pesanan" class="min-w-28 mr-4 inline-block font-medium">Nama Pesanan</label>
                        <input type="text" name="nama_pesanan" id="nama_pesanan"
                            value="{{ $errors->has('nama_pesanan') ? $pesanan->nama_pesanan ?? '' : old('nama_pesanan', $pesanan->nama_pesanan ?? '') }}"
                            {{ $errors->has('nama_pesanan') ? 'focused' : '' }} required
                            class="{{ $errors->has('nama_pesanan') ? 'input-invalid' : 'input-valid' }} w-full rounded border bg-gray-100 px-4 py-2 shadow outline-none focus:ring">
                        @error('nama_pesanan')
                            <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div x-data="{ harga: window.formatToIdr({{ $pesanan->harga ?? '' }}) || 'Rp. 0' }" class="mb-4">
                        <label for="harga" class="min-w-28 mr-4 inline-block font-medium">Harga Pesanan</label>
                        <input type="text" name="harga" id="harga" x-model="harga"
                            @input="harga = window.formatToIdr(harga)" :value="harga"
                            value="{{ $errors->has('harga') ? $pesanan->harga ?? '' : old('harga', $pesanan->harga ?? '') }}"
                            {{ $errors->has('harga') ? 'focused' : '' }} required
                            class="{{ $errors->has('harga') ? 'input-invalid' : 'input-valid' }} w-full rounded border bg-gray-100 px-4 py-2 shadow outline-none focus:ring">
                        @error('harga')
                            <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <button
                        class="w-full rounded bg-blue-500 px-4 py-2 font-medium text-white shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80">Tambah</button>
                </form>
            </div>

            <div class="overflow-y-auto border shadow" style="height: calc(100vh - 180px)">
            </div>
        </div>
    </div>
</x-dashboard-layout>
