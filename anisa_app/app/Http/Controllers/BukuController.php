<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 🟩 Daftar semua buku
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
        return view('buku.create');
    }

    // 🟧 Simpan buku baru (gambar + PDF)
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
            'file_pdf'     => 'nullable|mimes:pdf|max:10240', // maksimal 10MB
        ]);

        // Upload sampul
        if ($request->hasFile('sampul')) {
            $file = $request->file('sampul');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('image'), $filename);
            $validated['sampul'] = $filename;
        }

        // Upload PDF
        if ($request->hasFile('file_pdf')) {
            $pdf = $request->file('file_pdf');
            $pdfName = time() . '_' . $pdf->getClientOriginalName();
            $pdf->move(public_path('pdf'), $pdfName);
            $validated['file_pdf'] = $pdfName;
        }

        Buku::create($validated);

        return redirect()->route('bukus.index')
                         ->with('success', '✅ Buku berhasil ditambahkan!');
    }

    // 🟪 Detail buku
    public function show(Buku $buku)
    {
        return view('buku.show', compact('buku'));
    }

    // 🟨 Form edit buku
    public function edit(Buku $buku)
    {
        return view('buku.edit', compact('buku'));
    }

    // 🟥 Update buku (gambar + PDF)
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
            'file_pdf'     => 'nullable|mimes:pdf|max:10240',
        ]);

        // Update sampul (hapus lama kalau ada)
        if ($request->hasFile('sampul')) {
            if ($buku->sampul && file_exists(public_path('image/' . $buku->sampul))) {
                unlink(public_path('image/' . $buku->sampul));
            }
            $file = $request->file('sampul');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('image'), $filename);
            $validated['sampul'] = $filename;
        }

        // Update PDF (hapus lama kalau ada)
        if ($request->hasFile('file_pdf')) {
            if ($buku->file_pdf && file_exists(public_path('pdf/' . $buku->file_pdf))) {
                unlink(public_path('pdf/' . $buku->file_pdf));
            }
            $pdf = $request->file('file_pdf');
            $pdfName = time() . '_' . $pdf->getClientOriginalName();
            $pdf->move(public_path('pdf'), $pdfName);
            $validated['file_pdf'] = $pdfName;
        }

        $buku->update($validated);

        return redirect()->route('bukus.index')
                         ->with('success', '✏️ Data buku berhasil diperbarui!');
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

        $buku->delete();

        return redirect()->route('bukus.index')
                         ->with('success', '🗑️ Buku berhasil dihapus!');
    }

    // 📊 Dashboard
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
