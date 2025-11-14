<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;

class LandingController extends Controller
{
    public function index()
    {
        return view('landing', [
            'koleksi'     => Buku::latest()->take(8)->get(),
            'rekomendasi' => Buku::inRandomOrder()->take(3)->get(),
            'kategoris'   => Kategori::all()  // 👈 WAJIB ADA & NAMA HARUS SAMA
        ]);
    }
}
