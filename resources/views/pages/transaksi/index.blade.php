<x-dashboard-layout :$title>
    <div x-data="{ showModalHapus: false }" class="p-4">
        <h1 class="mb-6 text-3xl font-bold">{{ $title }}</h1>

        <a href="/transaksi/create" class="inline-block rounded bg-blue-500 px-4 py-2 text-lg font-medium text-white shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80 mb-4">Tambah Transaksi</a>

        <div class="flex flex-nowrap gap-4">
            <div class="w-full overflow-y-auto" style="height: calc(100vh - 180px)">
                <table class="mb-4 w-full table-auto border-collapse">
                    <thead>
                        <th>Kode Transaksi</th>
                        <th>Kode Pesanan</th>
                        <th>Total Harga</th>
                        <th>Bayar</th>
                        <th>Kembalian</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        @foreach ($transaksis as $transaksi)
                            <tr>
                                <td>{{ $transaksi->id_transaksi }}</td>
                                <td>{{ $transaksi->id_pesanan }}</td>
                                <td x-text="window.formatToIdr('{{ $transaksi->total }}')"></td>
                                <td x-text="window.formatToIdr('{{ $transaksi->bayar }}')"></td>
                                <td x-text="window.formatToIdr('{{ $transaksi->kembalian }}')"></td>
                                <td>
                                    <a href="/transaksi/detail/{{ $transaksi->id_transaksi }}"
                                        class="inline-block rounded bg-blue-500 px-4 py-2 text-lg font-medium text-white shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $transaksis->links() }}
            </div>
        </div>

        @if (!Request::is('transaksi'))
            <x-modal modalName="Hapus" bodyText="Peringatan apakah anda yakin ingin menghapus transaksi ini?"
                href="/transaksi/delete/{{ $idTransaksi ?? '' }}" confirmText="Ya, saya ingin menghapusnya"
                cancelText="Tidak"></x-modal>
        @endif
    </div>
</x-dashboard-layout>
