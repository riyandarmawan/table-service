<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index() {
        $data = [
            'title' => 'Daftar Menu'
        ];

        return view('pages.menu.index', $data);
    }

    public function create(Request $request) {
        // $request->validate()
    }
}
