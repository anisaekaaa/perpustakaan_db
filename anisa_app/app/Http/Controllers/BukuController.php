<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\User;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 🟩 Daftar buku
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
            ->withQueryString();

        return view('buku.index', compact('bukus', 'search'));
    }

    // 🟦 Form tambah buku
    public function create()
    {
        $kategoris = Kategori::all();
        return view('buku.create', compact('kategoris'));
    }

    // 🟧 Simpan buku
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'        => 'required|string|max:255',
            'penulis'      => 'required|string|max:255',
            'penerbit'     => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|min:1000|max:' . date('Y'),
            'stok'         => 'required|integer|min:0',
            'deskripsi'    => 'nullable|string',
            'sampul'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'file_pdf'     => 'nullable|mimes:pdf',
            'kategori'     => 'required|array',
        ]);

        if ($request->hasFile('sampul')) {
            $filename = time() . '_' . $request->file('sampul')->getClientOriginalName();
            $request->file('sampul')->move(public_path('image'), $filename);
            $validated['sampul'] = $filename;
        }

        if ($request->hasFile('file_pdf')) {
            $pdfName = time() . '_' . $request->file('file_pdf')->getClientOriginalName();
            $request->file('file_pdf')->move(public_path('pdf'), $pdfName);
            $validated['file_pdf'] = $pdfName;
        }

        $buku = Buku::create($validated);
        $buku->kategoris()->sync($request->kategori);

        return redirect()->route('bukus.index')->with('success', '✅ Buku berhasil ditambahkan!');
    }

    // 🟪 Detail buku
    public function show(Buku $buku)
    {
        return view('buku.show', compact('buku'));
    }

    // 🟨 Edit buku
  public function edit(Buku $buku)
{
    $kategoris = Kategori::all();
    $selectedKategori = $buku->kategoris->pluck('id')->toArray(); // ✅ Tambahkan ini

    return view('buku.edit', compact('buku', 'kategoris', 'selectedKategori'));
}


    // 🟥 Update buku
    public function update(Request $request, Buku $buku)
    {
        $validated = $request->validate([
            'judul'        => 'required|string|max:255',
            'penulis'      => 'required|string|max:255',
            'penerbit'     => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|min:1000|max:' . date('Y'),
            'stok'         => 'required|integer|min:0',
            'deskripsi'    => 'nullable|string',
            'sampul'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'file_pdf'     => 'nullable|mimes:pdf',
            'kategori'     => 'required|array',
        ]);

        // Update sampul
        if ($request->hasFile('sampul')) {
            if ($buku->sampul && file_exists(public_path('image/' . $buku->sampul))) {
                unlink(public_path('image/' . $buku->sampul));
            }
            $filename = time() . '_' . $request->file('sampul')->getClientOriginalName();
            $request->file('sampul')->move(public_path('image'), $filename);
            $validated['sampul'] = $filename;
        }

        // Update PDF
        if ($request->hasFile('file_pdf')) {
            if ($buku->file_pdf && file_exists(public_path('pdf/' . $buku->file_pdf))) {
                unlink(public_path('pdf/' . $buku->file_pdf));
            }
            $pdfName = time() . '_' . $request->file('file_pdf')->getClientOriginalName();
            $request->file('file_pdf')->move(public_path('pdf'), $pdfName);
            $validated['file_pdf'] = $pdfName;
        }

        $buku->update($validated);
        $buku->kategoris()->sync($request->kategori);

        return redirect()->route('bukus.index')->with('success', '✏️ Buku berhasil diperbarui!');
    }

    // ⚫ Hapus buku
    public function destroy(Buku $buku)
    {
        if ($buku->sampul && file_exists(public_path('image/' . $buku->sampul))) {
            unlink(public_path('image/' . $buku->sampul));
        }

        if ($buku->file_pdf && file_exists(public_path('pdf/' . $buku->file_pdf))) {
            unlink(public_path('pdf/' . $buku->file_pdf));
        }

        $buku->kategoris()->detach();
        $buku->delete();

        return redirect()->route('bukus.index')->with('success', '🗑️ Buku berhasil dihapus!');
    }

    public function filterByKategori($id)
{
    $kategori = Kategori::findOrFail($id);

    // Ambil buku yang punya kategori ini
    $bukus = Buku::whereHas('kategoris', function ($q) use ($id) {
        $q->where('kategori_id', $id);
    })->paginate(10);

    return view('buku.index', compact('bukus', 'kategori'));
}

    // 📊 Dashboard Admin
    public function dashboard()
    {
        $totalBuku = Buku::count();
        $totalUser = User::count();
        $bukuTerbaru = Buku::latest()->take(2)->get();

        $statistik = Buku::select('penerbit', DB::raw('count(*) as total'))
            ->groupBy('penerbit')
            ->orderByDesc('total')
            ->get();

        return view('dashboard', compact('totalBuku', 'totalUser', 'bukuTerbaru', 'statistik'));
    }
}
