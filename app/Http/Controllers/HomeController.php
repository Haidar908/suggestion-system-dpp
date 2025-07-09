<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman utama (landing page).
     */
    public function index()
    {
        // 'home' adalah nama file view yang akan kita buat selanjutnya
        return view('home');
    }
}