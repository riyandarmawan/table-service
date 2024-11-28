<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use Illuminate\Http\Request;

class MejaController extends Controller
{
    public function index()
    {
        $meja = new Meja();

        $mejas = $meja->filter(request(['search']))->paginate(10);

        $idMeja = $meja->generateIdMeja();

        $data = [
            'title' => 'Daftar Meja',
            'mejas' => $mejas,
            'idMeja' => $idMeja
        ];

        return view('pages.meja.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
        ]);

        $meja = new Meja();

        $meja->id_meja = $request->input('id_meja');
        $meja->kapasitas_kursi = $request->input('kapasitas_kursi');

        if ($meja->save()) {
            return redirect('/meja')->with('success', 'Meja baru berhasil ditambahkan!');
        }

        return redirect('/meja')->with('error', value: 'Meja baru gagal ditambahkan!');
    }

    public function choice($id_meja)
    {
        $meja = new Meja();

        $mejas = $meja->filter(request(['search']))->paginate(10);

        $meja = $meja->find($id_meja);

        $idMeja = $meja->id_meja;

        $data = [
            'title' => 'Daftar Meja',
            'mejas' => $mejas,
            'meja' => $meja,
            'idMeja' => $idMeja
        ];

        return view('pages.meja.index', $data);
    }

    public function update(Request $request, $id_meja)
    {
        $request->validate([
            'id_meja' => 'required',
        ]);

        $meja = Meja::find($id_meja);

        $meja->id_meja = $request->input('id_meja');
        $meja->kapasitas_kursi = $request->input('kapasitas_kursi');

        if ($meja->save()) {
            return redirect('/meja')->with('success', 'Meja berhasil diubah!');
        }

        return redirect('/meja')->with('error', value: 'Meja gagal diubah!');
    }

    public function destroy($id_meja)
    {
        $meja = new Meja();

        $meja = $meja->find($id_meja);

        if ($meja->delete()) {
            return redirect('/meja')->with('success', value: 'Meja berhasil dihapus!');
        }

        return redirect('/meja')->with('error', value: 'Meja gagal dihapus!');
    }

    public function get($id_meja)
    {
        $meja = new Meja();

        $mejas = $meja->where('id_meja', 'like', "%$id_meja%")->get() ?? $meja->all();

        if (count($mejas)) {
            return response()->json($mejas, 200);
        }

        return response()->json(['message' => 'Meja tidak ditemukan', 404]);
    }
}
