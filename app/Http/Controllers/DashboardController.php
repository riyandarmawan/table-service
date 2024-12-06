<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\DetailPesanan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $startOfLast24Hours = Carbon::now()->subDay(); // 24 hours ago
        $endOfLast24Hours = Carbon::now(); // Current time

        $totalPemasukan = Transaksi::withoutTrashed()
            ->whereBetween('created_at', [$startOfLast24Hours, $endOfLast24Hours])
            ->sum('total');

        $totalJumlah = DetailPesanan::withoutTrashed()
            ->whereBetween('created_at', [$startOfLast24Hours, $endOfLast24Hours])
            ->sum('jumlah');

        $topMenus = DetailPesanan::select('id_menu', DB::raw('SUM(jumlah) as total_jumlah'))
            ->groupBy('id_menu')
            ->orderByDesc(DB::raw('SUM(jumlah)')) // Order by total jumlah in descending order
            ->limit(5)
            ->with('menu') // Assuming the relationship between DetailPesanan and Menu is defined
            ->get();

        $data = [
            'title' => 'Dashboard',
            'totalPemasukan' => $totalPemasukan,
            'totalJumlah' => $totalJumlah,
            'topMenus' => $topMenus
        ];

        return view('pages.dashboard.index', $data);
    }
}
