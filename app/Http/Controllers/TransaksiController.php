<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = new Transaksi();

        $transaksis = $transaksi->filter(request(['search']))->paginate(10);


        $data = [
            'title' => 'Daftar Transaksi',
            'transaksis' => $transaksis,
        ];

        return view('pages.transaksi.index', $data);
    }

    public function create()
    {
        $transaksi = new Transaksi();

        $idTransaksi = $transaksi->generateIdTransaksi();

        $data = [
            'title' => 'Tambah Transaksi',
            'idTransaksi' => $idTransaksi
        ];

        return view('pages.transaksi.tambah', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_transaksi' => 'required',
            'total' => 'required',
            'bayar' => 'required',
            'kembalian' => 'required',
            'id_pesanan' => 'required',
        ], [
            // id_menu
            'id_pesanan.required' => 'Pesanan wajib dipilih!',
        ]);

        $transaksi = new Transaksi();

        $transaksi->id_transaksi = $request->input('id_transaksi');
        $total = (int) preg_replace('/[^\d]/', '', $request->input('total'));
        $bayar = (int) preg_replace('/[^\d]/', '', $request->input('bayar'));
        if ($bayar < $total) {
            return back()->withErrors(['bayar' => 'Uang anda kurang!'])->withInput($request->only(['id_pesanan', 'total', 'bayar', 'kembalian']));
        }
        $transaksi->total = $total;
        $transaksi->bayar = $bayar;
        $transaksi->kembalian = (int) preg_replace('/[^\d]/', '', $request->input('kembalian'));
        $transaksi->id_pesanan = $request->input('id_pesanan');

        if (!$transaksi->save()) {
            return redirect('/transaksi')->with('error', value: 'Transaksi baru gagal ditambahkan!');
        }

        $meja = Pesanan::find($request->input('id_pesanan'))->meja;
        $meja->is_tersedia = 'Tersedia';
        $meja->save();

        return redirect('/transaksi')->with('success', 'Transaksi baru berhasil ditambahkan!');
    }

    public function detail($id_transaksi)
    {
        $transaksi = new Transaksi();

        $transaksi = $transaksi->find($id_transaksi);

        $idTransaksi = $transaksi->id_transaksi;

        $data = [
            'title' => 'Daftar Transaksi',
            'transaksi' => $transaksi,
            'idTransaksi' => $idTransaksi
        ];

        return view('pages.transaksi.detail', $data);
    }

    public function update(Request $request, $id_transaksi)
    {
        $request->validate([
            'id_transaksi' => 'required',
            'total' => 'required',
            'bayar' => 'required',
            'kembalian' => 'required',
            'id_pesanan' => 'required',
        ], [
            // id_menu
            'id_pesanan.required' => 'Pesanan wajib dipilih!',
        ]);

        // Find the existing transaksi
        $transaksi = Transaksi::find($id_transaksi);

        if (!$transaksi) {
            return redirect('/transaksi')->with('error', 'Transaksi tidak ditemukan!');
        }

        // Update the transaksi details
        $transaksi->id_transaksi = $request->input('id_transaksi');
        $total = (int) preg_replace('/[^\d]/', '', $request->input('total'));
        $bayar = (int) preg_replace('/[^\d]/', '', $request->input('bayar'));
        if ($bayar < $total) {
            return back()->withErrors(['bayar' => 'Uang anda kurang!'])->withInput($request->only(['id_pesanan', 'total', 'bayar', 'kembalian']));
        }
        $transaksi->total = $total;
        $transaksi->bayar = $bayar;
        $transaksi->kembalian = (int) preg_replace('/[^\d]/', '', $request->input('kembalian'));
        $transaksi->id_pesanan = $request->input('id_pesanan');

        if (!$transaksi->save()) {
            return redirect('/transaksi')->with('error', 'Transaksi gagal diubah!');
        }

        $meja = Pesanan::find($request->input('id_pesanan'))->meja;
        $meja->is_tersedia = 'Tersedia';
        $meja->save();

        return redirect('/transaksi')->with('success', 'Transaksi berhasil diubah!');
    }

    public function destroy($id_transaksi)
    {
        $transaksi = Transaksi::find($id_transaksi);

        if (!$transaksi) {
            return redirect('/transaksi')->with('error', 'Transaksi tidak ditemukan!');
        }

        // Delete the transaksi itself
        if ($transaksi->delete()) {
            return redirect('/transaksi')->with('success', 'Transaksi berhasil dihapus!');
        }

        return redirect('/transaksi')->with('error', 'Transaksi gagal dihapus!');
    }
}
