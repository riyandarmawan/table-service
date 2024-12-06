<x-dashboard-layout :$title>
    <div class="grid grid-cols-2 p-4 gap-4">
        <div class="bg-blue-500 p-4 shaodw rounded">
            <h2 class="mb-4 text-center text-3xl font-bold text-white">Total Pemasukan Hari Ini</h2>
            <h1 x-text="window.formatToIdr('{{ $totalPemasukan }}')" class="text-center text-5xl font-bold text-white">
            </h1>
        </div>
        <div class="bg-blue-500 p-4 shaodw rounded">
            <h2 class="mb-4 text-center text-3xl font-bold text-white">Jumlah menu yang dibeli hari ini</h2>
            <h1 class="text-center text-5xl font-bold text-white">
                {{ $totalJumlah }}
            </h1>
        </div>
        <div class="bg-blue-500 p-4 shaodw rounded col-span-2">
            <h2 class="mb-4 text-center text-3xl font-bold text-white">Top 5 menu hari ini</h2>
            <table class="text-white">
                <thead>
                    <th>Kode Menu</th>
                    <th>Nama Menu</th>
                    <th>Harga Menu</th>
                    <th>Jumlah menu yang dibeli</th>
                    <th>Pemasukan</th>
                </thead>
                <tbody>
                    @foreach ($topMenus as $detail)
                        <tr>
                            <td>{{ $detail->id_menu }}</td>
                            <td>{{ $detail->menu->nama_menu }}</td>
                            <td>{{ $detail->menu->harga }}</td>
                            <td>{{ $detail->total_jumlah }}</td>
                            <td x-text="window.formatToIdr('{{ $detail->menu->harga * $detail->total_jumlah }}')"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-dashboard-layout>
