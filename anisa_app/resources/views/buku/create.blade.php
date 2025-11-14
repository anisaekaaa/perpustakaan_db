@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 700px;">
    <h2 class="fw-bold mb-4 text-primary text-center">➕ Tambah Buku Baru</h2>

    {{-- 🔹 Alert jika ada error validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan!</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 📝 Form Tambah Buku --}}
    <form action="{{ route('bukus.store') }}" method="POST" enctype="multipart/form-data" 
          class="shadow p-4 rounded-4 bg-white border-0">
        @csrf

        {{-- Judul --}}
        <div class="mb-3">
            <label for="judul" class="form-label fw-semibold">Judul Buku</label>
            <input type="text" id="judul" name="judul" value="{{ old('judul') }}"
                   class="form-control rounded-3" placeholder="Masukkan judul buku..." required>
        </div>

        {{-- Penulis --}}
        <div class="mb-3">
            <label for="penulis" class="form-label fw-semibold">Penulis</label>
            <input type="text" id="penulis" name="penulis" value="{{ old('penulis') }}"
                   class="form-control rounded-3" placeholder="Masukkan nama penulis..." required>
        </div>

        {{-- Kategori --}}

        <div class="form-group mb-3">
    <label class="mb-2">Kategori Buku</label>

    <div class="d-flex flex-column gap-2">

        @foreach($kategoris as $kategori)
            <label class="d-flex align-items-center" style="gap: 6px;">
                <input 
                    type="checkbox" 
                    name="kategori[]" 
                    value="{{ $kategori->id }}"
                    @if(isset($buku) && $buku->kategoris->contains($kategori->id)) checked @endif
                >
                {{ $kategori->nama }}
            </label>
        @endforeach

    </div>
</div>

        {{-- Penerbit --}}
        <div class="mb-3">
            <label for="penerbit" class="form-label fw-semibold">Penerbit</label>
            <input type="text" id="penerbit" name="penerbit" value="{{ old('penerbit') }}"
                   class="form-control rounded-3" placeholder="Masukkan nama penerbit..." required>
        </div>

        {{-- Tahun Terbit --}}
        <div class="mb-3">
            <label for="tahun_terbit" class="form-label fw-semibold">Tahun Terbit</label>
            <input type="number" id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit') }}"
                   class="form-control rounded-3" placeholder="Contoh: 2024" required>
        </div>

        {{-- Stok --}}
        <div class="mb-3">
            <label for="stok" class="form-label fw-semibold">Stok</label>
            <input type="number" id="stok" name="stok" value="{{ old('stok') }}"
                   class="form-control rounded-3" min="0" placeholder="Masukkan jumlah stok..." required>
        </div>

        {{-- Deskripsi --}}
        <div class="mb-3">
            <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" class="form-control rounded-3" rows="4"
                      placeholder="Tuliskan deskripsi buku...">{{ old('deskripsi') }}</textarea>
        </div>

        {{-- Sampul Buku --}}
        <div class="mb-3">
            <label for="sampulInput" class="form-label fw-semibold">📸 Sampul Buku</label>
            <input type="file" id="sampulInput" name="sampul" 
                   class="form-control rounded-3" accept="image/*">

            {{-- Preview Gambar --}}
            <div class="mt-3 text-center">
                <img id="previewImage" src="#" alt="Preview Sampul" 
                     class="rounded shadow-sm d-none" style="max-height: 200px;">
            </div>
        </div>

        {{-- Upload PDF --}}
        <div class="mb-3">
            <label for="file_pdf" class="form-label fw-semibold">📕 Upload File Buku (PDF)</label>
            <input type="file" name="file_pdf" class="form-control rounded-3" accept="application/pdf">
            <small class="text-muted">*Opsional, hanya file PDF maksimal 10MB</small>
        </div>

        {{-- Tombol Aksi --}}
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('bukus.index') }}" class="btn btn-secondary px-4 fw-semibold">
                ← Kembali
            </a>
            <button type="submit" class="btn btn-success px-4 fw-semibold">
                💾 Simpan Buku
            </button>
        </div>
    </form>
</div>


{{-- 🖼️ Script Preview Gambar --}}
<script>
    document.getElementById('sampulInput').addEventListener('change', function (event) {
        const file = event.target.files[0];
        const preview = document.getElementById('previewImage');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        } else {
            preview.classList.add('d-none');
            preview.src = '#';
        }
    });
</script>
@endsection
