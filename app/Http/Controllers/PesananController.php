<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index()
    {
        $pesanan = new Pesanan();

        $pesanans = $pesanan->filter(request(['search']))->paginate(10);

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
            'id_menu' => 'required',
            'id_meja' => 'required',
            'id_pelanggan' => 'required',
            'jumlah' => 'required',
            'id_user' => 'required',
        ]);

        $pesanan = new Pesanan();

        $pesanan->id_pesanan = $request->input('id_pesanan');
        $pesanan->id_menu = $request->input('id_menu');
        $pesanan->id_meja = $request->input('id_meja');
        $pesanan->id_pelanggan = $request->input('id_pelanggan');
        $pesanan->jumlah = $request->input('jumlah');
        $pesanan->id_user = $request->input('id_user');

        if ($pesanan->save()) {
            return redirect('/pesanan')->with('success', 'Pesanan baru berhasil ditambahkan!');
        }

        return redirect('/pesanan')->with('error', value: 'Pesanan baru gagal ditambahkan!');
    }

    public function choice($id_pesanan)
    {
        $pesanan = new Pesanan();

        $pesanans = $pesanan->filter(request(['search']))->paginate(10);

        $pesanan = $pesanan->find($id_pesanan);

        $idPesanan = $pesanan->id_pesanan;

        $data = [
            'title' => 'Daftar Pesanan',
            'pesanans' => $pesanans,
            'pesanan' => $pesanan,
            'idPesanan' => $idPesanan
        ];

        return view('pages.pesanan.index', $data);
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
