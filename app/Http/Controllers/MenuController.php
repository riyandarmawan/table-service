<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index() {
        $menu = new Menu();

        $data = [
            'title' => 'Daftar Menu',
            'menus' => $menu->all()
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

        if($menu->create($request->all())) {
            return redirect('/menu')->with('success', 'Menu baru berhasil ditambahkan!');
        }

        return redirect('/menu')->with('error', value: 'Menu baru gagal ditambahkan!');
    }
}
