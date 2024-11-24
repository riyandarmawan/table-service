<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index() {
        $menu = new Menu();

        $idMenu = $menu->generateIdMenu();

        $data = [
            'title' => 'Daftar Menu',
            'menus' => $menu->all(),
            'idMenu' => $idMenu
        ];

        return view('pages.menu.index', $data);
    }

    public function store(Request $request) {
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

        if($menu->save()) {
            return redirect('/menu')->with('success', 'Menu baru berhasil ditambahkan!');
        }

        return redirect('/menu')->with('error', value: 'Menu baru gagal ditambahkan!');
    }
}
