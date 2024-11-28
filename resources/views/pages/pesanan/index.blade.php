<x-dashboard-layout :$title>
    <div x-data="{ showModalHapus: false }" class="p-4">
        <h1 class="mb-6 text-3xl font-bold">{{ $title }}</h1>

        <a href="/pesanan/create" class="inline-block rounded bg-blue-500 px-4 py-2 text-lg font-medium text-white shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80 mb-4">Tambah Pesanan</a>

        <div class="flex flex-nowrap gap-4">
            <div class="w-full overflow-y-auto" style="height: calc(100vh - 180px)">
                <table class="mb-4 w-full table-auto border-collapse">
                    <thead>
                        <th>Kode Pesanan</th>
                        <th>Kode Menu</th>
                        <th>Nama Menu</th>
                        <th>Kode Meja</th>
                        <th>Kapasitas Kursi</th>
                        <th>Kode Pelanggan</th>
                        <th>Nama Pelanggan</th>
                        <th>Jumlah</th>
                        <th>Nama User</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        @foreach ($pesanans as $pesanan)
                            <tr>
                                <td>{{ $pesanan->id_pesanan }}</td>
                                <td>{{ $pesanan->menu->id_menu }}</td>
                                <td>{{ $pesanan->menu->nama_menu }}</td>
                                <td>{{ $pesanan->meja->id_meja }}</td>
                                <td>{{ $pesanan->meja->kapasitas_kursi }}</td>
                                <td>{{ $pesanan->pelanggan->id_pelanggan }}</td>
                                <td>{{ $pesanan->pelanggan->nama_pelanggan }}</td>
                                <td>{{ $pesanan->jumlah }}</td>
                                <td>{{ $pesanan->user->name }}</td>
                                <td>
                                    <a href="/pesanan/choice/{{ $pesanan->id_pesanan }}"
                                        class="inline-block rounded bg-blue-500 px-4 py-2 text-lg font-medium text-white shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80">Pilih</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $pesanans->links() }}
            </div>
        </div>

        @if (!Request::is('pesanan'))
            <x-modal modalName="Hapus" bodyText="Peringatan apakah anda yakin ingin menghapus pesanan ini?"
                href="/pesanan/delete/{{ $idPesanan ?? '' }}" confirmText="Ya, saya ingin menghapusnya"
                cancelText="Tidak"></x-modal>
        @endif
    </div>
</x-dashboard-layout>
