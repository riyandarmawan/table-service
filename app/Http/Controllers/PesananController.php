<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use App\Models\DetailPesanan;

class PesananController extends Controller
{
    public function index()
    {
        $pesanan = new Pesanan();

        $pesanans = $pesanan->filter(request(['search']))->with(['menus', 'pelanggan', 'user', 'meja'])->paginate(10);

        $idPesanan = $pesanan->generateIdPesanan();

        $data = [
            'title' => 'Daftar Pesanan',
            'pesanans' => $pesanans,
            'idPesanan' => $idPesanan
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
            'id_menu' => 'required',
            'jumlah' => 'required',
        ]);

        $pesanan = new Pesanan();

        $pesanan->id_pesanan = $request->input('id_pesanan');
        $pesanan->id_meja = $request->input('id_meja');
        $pesanan->id_pelanggan = $request->input('id_pelanggan');
        $pesanan->id_user = $request->input('id_user');

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

    public function choice($id_pesanan)
    {
        $pesanan = new Pesanan();

        $pesanan = $pesanan->find($id_pesanan);

        $idPesanan = $pesanan->id_pesanan;

        $data = [
            'title' => 'Daftar Pesanan',
            'pesanan' => $pesanan,
            'idPesanan' => $idPesanan
        ];

        return view('pages.pesanan.pilih', $data);
    }

    public function update(Request $request, $id_pesanan)
    {
        $request->validate([
            'id_pesanan' => 'required',
            'id_menu' => 'required',
            'id_meja' => 'required',
            'id_pelanggan' => 'required',
            'jumlah' => 'required',
            'id_user' => 'required',
        ]);

        $pesanan = Pesanan::find($id_pesanan);

        $pesanan->id_pesanan = $request->input('id_pesanan');
        $pesanan->id_menu = $request->input('id_menu');
        $pesanan->id_meja = $request->input('id_meja');
        $pesanan->id_pelanggan = $request->input('id_pelanggan');
        $pesanan->jumlah = $request->input('jumlah');
        $pesanan->id_user = $request->input('id_user');

        if ($pesanan->save()) {
            return redirect('/pesanan')->with('success', 'Pesanan berhasil diubah!');
        }

        return redirect('/pesanan')->with('error', value: 'Pesanan gagal diubah!');
    }

    public function destroy($id_pesanan)
    {
        $pesanan = new Pesanan();

        $pesanan = $pesanan->find($id_pesanan);

        if ($pesanan->delete()) {
            return redirect('/pesanan')->with('success', value: 'Pesanan berhasil dihapus!');
        }

        return redirect('/pesanan')->with('error', value: 'Pesanan gagal dihapus!');
    }
}
