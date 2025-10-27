<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    // 🟩 Tampilkan semua data (dengan fitur search + pagination)
    public function index(Request $request)
    {
        $search = $request->input('search');

        $bukus = Buku::when($search, function ($query, $search) {
                return $query->where('judul', 'like', "%{$search}%")
                             ->orWhere('penulis', 'like', "%{$search}%")
                             ->orWhere('penerbit', 'like', "%{$search}%")
                             ->orWhere('tahun_terbit', 'like', "%{$search}%");
            })
            ->orderBy('judul', 'asc')
            ->paginate(10)
            ->withQueryString(); // biar pagination tetap ingat keyword search

        return view('buku.index', compact('bukus', 'search'));
    }

    // 🟦 Form tambah buku
    public function create()
    {
        return view('buku.create');
    }

    // 🟧 Simpan data buku baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|min:1000|max:' . date('Y'),
            'stok' => 'required|integer|min:0',
        ]);

        Buku::create($validated);

        return redirect()->route('buku.index')->with('success', '✅ Buku berhasil ditambahkan!');
    }

    // 🟪 Detail satu buku
    public function show(Buku $buku)
    {
        return view('buku.show', compact('buku'));
    }

    // 🟨 Form edit buku
    public function edit(Buku $buku)
    {
        return view('buku.edit', compact('buku'));
    }

    // 🟥 Update data buku
    public function update(Request $request, Buku $buku)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|min:1000|max:' . date('Y'),
            'stok' => 'required|integer|min:0',
        ]);

        $buku->update($validated);

        return redirect()->route('buku.index')->with('success', '✏️ Data buku berhasil diperbarui!');
    }

    // ⚫ Hapus buku
    public function destroy(Buku $buku)
    {
        $buku->delete();
        return redirect()->route('buku.index')->with('success', '🗑️ Buku berhasil dihapus!');
    }
}
