<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggan = new Pelanggan();

        $idPelanggan = $pelanggan->generateIdPelanggan();

        $data = [
            'title' => 'Daftar Pelanggan',
            'pelanggans' => $pelanggan->all(),
            'idPelanggan' => $idPelanggan
        ];

        return view('pages.pelanggan.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pelanggan' => 'required',
            'nama_pelanggan' => 'required',
            'jenis_kelamin' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
        ]);

        $pelanggan = new Pelanggan();

        if ($pelanggan->create($request->all())) {
            return redirect('/pelanggan')->with('success', 'Pelanggan baru berhasil ditambahkan!');
        }

        return redirect('/pelanggan')->with('error', value: 'Pelanggan baru gagal ditambahkan!');
    }

    public function choice($id_pelanggan)
    {
        $pelanggan = new Pelanggan();

        $pelanggans = $pelanggan->all();

        $pelanggan = $pelanggan->find($id_pelanggan);

        $idPelanggan = $pelanggan->id_pelanggan;

        $data = [
            'title' => 'Daftar Pelanggan',
            'pelanggans' => $pelanggans,
            'pelanggan' => $pelanggan,
            'idPelanggan' => $idPelanggan
        ];

        return view('pages.pelanggan.index', $data);
    }

    public function update(Request $request, $id_pelanggan)
    {
        $request->validate([
            'id_pelanggan' => 'required',
            'nama_pelanggan' => 'required',
            'jenis_kelamin' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
        ]);

        $pelanggan = Pelanggan::find($id_pelanggan);

        $pelanggan->id_pelanggan = $request->input('id_pelanggan');
        $pelanggan->nama_pelanggan = $request->input('nama_pelanggan');
        $pelanggan->jenis_kelamin = $request->input('jenis_kelamin');
        $pelanggan->no_hp = $request->input('no_hp');
        $pelanggan->alamat = $request->input('alamat');

        if ($pelanggan->save()) {
            return redirect('/pelanggan')->with('success', 'Pelanggan berhasil diubah!');
        }

        return redirect('/pelanggan')->with('error', value: 'Pelanggan gagal diubah!');
    }

    public function destroy($id_pelanggan)
    {
        $pelanggan = new Pelanggan();

        $pelanggan = $pelanggan->find($id_pelanggan);

        if ($pelanggan->delete()) {
            return redirect('/pelanggan')->with('success', value: 'Pelanggan berhasil dihapus!');
        }

        return redirect('/pelanggan')->with('error', value: 'Pelanggan gagal dihapus!');
    }
}
