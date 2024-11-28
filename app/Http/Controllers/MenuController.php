<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menu = new Menu();

        $menus = $menu->filter(request(['search']))->paginate(10);

        $idMenu = $menu->generateIdMenu();

        $data = [
            'title' => 'Daftar Menu',
            'menus' => $menus,
            'idMenu' => $idMenu
        ];

        return view('pages.menu.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_menu' => 'required',
            'nama_menu' => 'required',
            'harga' => 'required',
        ]);

        $menu = new Menu();

        $menu->id_menu = $request->input('id_menu');
        $menu->nama_menu = $request->input('nama_menu');
        $hargaFormatted = $request->input('harga');
        $menu->harga = (int) preg_replace('/[^\d]/', '', $hargaFormatted);

        if ($menu->save()) {
            return redirect('/menu')->with('success', 'Menu baru berhasil ditambahkan!');
        }

        return redirect('/menu')->with('error', value: 'Menu baru gagal ditambahkan!');
    }

    public function choice($id_menu)
    {
        $menu = new Menu();

        $menus = $menu->filter(request(['search']))->paginate(10);

        $menu = $menu->find($id_menu);

        $idMenu = $menu->id_menu;

        $data = [
            'title' => 'Daftar Menu',
            'menus' => $menus,
            'menu' => $menu,
            'idMenu' => $idMenu
        ];

        return view('pages.menu.index', $data);
    }

    public function update(Request $request, $id_menu)
    {
        $request->validate([
            'id_menu' => 'required',
            'nama_menu' => 'required',
            'harga' => 'required',
        ]);

        $menu = Menu::find($id_menu);

        $menu->id_menu = $request->input('id_menu');
        $menu->nama_menu = $request->input('nama_menu');
        $hargaFormatted = $request->input('harga');
        $menu->harga = (int) preg_replace('/[^\d]/', '', $hargaFormatted);

        if ($menu->save()) {
            return redirect('/menu')->with('success', 'Menu berhasil diubah!');
        }

        return redirect('/menu')->with('error', value: 'Menu gagal diubah!');
    }

    public function destroy($id_menu)
    {
        $menu = new Menu();

        $menu = $menu->find($id_menu);

        if ($menu->delete()) {
            return redirect('/menu')->with('success', value: 'Menu berhasil dihapus!');
        }

        return redirect('/menu')->with('error', value: 'Menu gagal dihapus!');
    }

    public function get($id_menu)
    {
        $menu = new Menu();

        $menus = $menu->where('id_menu', 'like', "%$id_menu%")->get() ?? $menu->all();

        if (count($menus)) {
            return response()->json($menus, 200);
        }

        return response()->json(['message' => 'Menu tidak ditemukan', 404]);
    }
}
