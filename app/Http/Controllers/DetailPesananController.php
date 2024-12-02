<?php

namespace App\Http\Controllers;

use App\Models\DetailPesanan;
use Illuminate\Http\Request;

class DetailPesananController extends Controller
{
    public function chosenMenu($id_pesanan) {
        $detailPesanan = new DetailPesanan();

        $detailPesanans = $detailPesanan->where('id_pesanan', $id_pesanan)->with('menu')->get();

        if (count($detailPesanans)) {
            return response()->json($detailPesanans, 200);
        }

        return response()->json(['message' => 'Detail Pesanan tidak ditemukan', 404]);
    }
}
