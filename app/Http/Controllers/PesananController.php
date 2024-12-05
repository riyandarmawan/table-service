<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use App\Models\DetailPesanan;

class PesananController extends Controller
{
    public function index()
    {
        $pesanan = new Pesanan();

        $pesanans = $pesanan->filter(request(['search']))->with(['menus', 'pelanggan', 'user', 'meja'])->paginate(10);

        $data = [
            'title' => 'Daftar Pesanan',
            'pesanans' => $pesanans,
        ];

        return view('pages.pesanan.index', $data);
    }

    public function create()
    {
        $pesanan = new Pesanan();

        $idPesanan = $pesanan->generateIdPesanan();

        $data = [
            'title' => 'Tambah Pesanan',
            'idPesanan' => $idPesanan
        ];

        return view('pages.pesanan.tambah', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pesanan' => 'required',
            'id_meja' => 'required',
            'id_pelanggan' => 'required',
            'id_user' => 'required',
            'jumlah' => 'required',
            'id_menu' => 'required',
        ], [
            // jumlah
            'jumlah.required' => 'Menu wajib dipilih!',

            // id_menu
            'id_menu.required' => 'Menu wajib dipilih!',
        ]);

        $pesanan = new Pesanan();

        $pesanan->id_pesanan = $request->input('id_pesanan');
        $pesanan->id_meja = $request->input('id_meja');
        $pesanan->id_pelanggan = $request->input('id_pelanggan');
        $pesanan->id_user = $request->input('id_user');

        $meja = Meja::find($request->input('id_meja'));
        $meja->is_tersedia = 'Tidak tersedia';
        $meja->save();

        if(!$pesanan->save()) {
            return redirect('/pesanan')->with('error', value: 'Pesanan baru gagal ditambahkan!');
        }

        foreach($request->input('id_menu') as $index => $id_menu) {
            $detailPesanan = new DetailPesanan();

            $detailPesanan->id_pesanan = $pesanan->id_pesanan;
            $detailPesanan->id_menu = $id_menu;
            $detailPesanan->jumlah = $request->input('jumlah')[$index];

            $detailPesanan->save();
        }
        
        return redirect('/pesanan')->with('success', 'Pesanan baru berhasil ditambahkan!');
    }

    public function detail($id_pesanan)
    {
        $pesanan = new Pesanan();

        $pesanan = $pesanan->find($id_pesanan);

        $idPesanan = $pesanan->id_pesanan;

        $data = [
            'title' => 'Daftar Pesanan',
            'pesanan' => $pesanan,
            'idPesanan' => $idPesanan
        ];

        return view('pages.pesanan.detail', $data);
    }

    public function update(Request $request, $id_pesanan)
    {
        $request->validate([
            'id_pesanan' => 'required',
            'id_meja' => 'required',
            'id_pelanggan' => 'required',
            'id_user' => 'required',
            'jumlah' => 'required',
            'id_menu' => 'required',
        ], [
            // jumlah
            'jumlah.required' => 'Menu wajib dipilih!',

            // id_menu
            'id_menu.required' => 'Menu wajib dipilih!',
        ]);

        // Find the existing pesanan
        $pesanan = Pesanan::find($id_pesanan);

        if (!$pesanan) {
            return redirect('/pesanan')->with('error', 'Pesanan tidak ditemukan!');
        }

        // Update the pesanan details
        $pesanan->id_pesanan = $request->input('id_pesanan');
        $pesanan->id_meja = $request->input('id_meja');
        $pesanan->id_pelanggan = $request->input('id_pelanggan');
        $pesanan->id_user = $request->input('id_user');

        $meja = Meja::find($request->input('id_meja'));
        $meja->is_tersedia = 'Tidak tersedia';
        $meja->save();

        if (!$pesanan->save()) {
            return redirect('/pesanan')->with('error', 'Pesanan gagal diubah!');
        }

        // Update or recreate the detail_pesanan rows
        $idMenus = $request->input('id_menu');
        $quantities = $request->input('jumlah');

        // Delete existing detail_pesanan rows for this pesanan
        DetailPesanan::where('id_pesanan', $id_pesanan)->delete();

        // Insert the new detail_pesanan rows
        foreach ($idMenus as $index => $id_menu) {
            DetailPesanan::create([
                'id_pesanan' => $pesanan->id_pesanan,
                'id_menu' => $id_menu,
                'jumlah' => $quantities[$index],
            ]);
        }

        return redirect('/pesanan')->with('success', 'Pesanan berhasil diubah!');
    }

    public function destroy($id_pesanan)
    {
        $pesanan = Pesanan::find($id_pesanan);

        if (!$pesanan) {
            return redirect('/pesanan')->with('error', 'Pesanan tidak ditemukan!');
        }

        // Delete related detail_pesanan rows
        $pesanan->menus()->delete();

        // Delete the pesanan itself
        if ($pesanan->delete()) {
            return redirect('/pesanan')->with('success', 'Pesanan berhasil dihapus!');
        }

        return redirect('/pesanan')->with('error', 'Pesanan gagal dihapus!');
    }

    public function get($searched_value = null, $related_id = null)
    {
        // Base query for Pesanan with relationships
        $pesananQuery = Pesanan::with(['meja', 'pelanggan', 'user', 'menus']);

        // Filter by searched_value if provided
        if (!empty($searched_value)) {
            $pesananQuery->where('id_pesanan', 'like', "%$searched_value%");
        }

        // Exclude Pesanan with transaksi, but include if related_id matches
        $pesananQuery->where(function ($query) {
            $query->whereDoesntHave('transaksi'); // Include all Pesanan without transaksi
        });

        if (!empty($related_id)) {
            $pesananQuery->orWhereHas('transaksi', function ($query) use ($related_id) {
                $query->where('id_pesanan', $related_id); // Include specific related_id
            });
        }

        // Get results
        $pesanans = $pesananQuery->get();

        // Return response
        if ($pesanans->isNotEmpty()) {
            return response()->json($pesanans, 200);
        }

        return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
    }
}
