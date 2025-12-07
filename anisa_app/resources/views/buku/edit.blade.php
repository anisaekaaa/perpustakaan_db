@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 700px;">
    <h2 class="fw-bold mb-4 text-primary text-center">✏️ Edit Data Buku</h2>

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

    {{-- 📝 Form Edit Buku --}}
    <form action="{{ route('bukus.update', $buku->id) }}" method="POST" enctype="multipart/form-data" class="shadow p-4 rounded-4 bg-white">
        @csrf
        @method('PUT')

        {{-- Judul --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Judul Buku</label>
            <input type="text" name="judul" value="{{ old('judul', $buku->judul) }}" class="form-control rounded-3" required>
        </div>

        {{-- Penulis --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Penulis</label>
            <input type="text" name="penulis" value="{{ old('penulis', $buku->penulis) }}" class="form-control rounded-3" required>
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
            <label class="form-label fw-semibold">Penerbit</label>
            <input type="text" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}" class="form-control rounded-3" required>
        </div>

        {{-- Tahun Terbit --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Tahun Terbit</label>
            <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" class="form-control rounded-3" required>
        </div>

        {{-- Deskripsi --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Deskripsi</label>
            <textarea name="deskripsi" class="form-control rounded-3" rows="4" placeholder="Tuliskan deskripsi buku...">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
        </div>

        {{-- Sampul Buku --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">📸 Sampul Buku</label><br>

            {{-- Gambar sampul lama --}}
            @if($buku->sampul && file_exists(public_path('image/' . $buku->sampul)))
                <div class="text-center mb-3">
                    <img src="{{ asset('image/' . $buku->sampul) }}" 
                         alt="Sampul Buku" class="rounded shadow-sm border" style="max-height: 180px;">
                </div>
            @else
                <p class="text-muted text-center fst-italic">Belum ada sampul yang diunggah.</p>
            @endif

            {{-- Input file baru --}}
            <input type="file" name="sampul" class="form-control rounded-3" accept="image/*" id="sampulInput">
            <small class="text-muted">Kosongkan jika tidak ingin mengganti sampul.</small>

            {{-- Preview gambar baru --}}
            <div class="mt-3 text-center">
                <img id="previewImage" src="#" alt="Preview Sampul Baru"
                     class="rounded shadow-sm border d-none" style="max-height: 200px;">
            </div>
        </div>

        {{-- Upload PDF --}}
        <div class="mb-3">
            <label for="file_pdf" class="form-label fw-semibold">📕 Upload File Buku (PDF)</label>
            <input type="file" name="file_pdf" class="form-control rounded-3" accept="application/pdf">
            <small class="text-muted">Kosongkan jika tidak ingin mengganti file PDF.</small>

            {{-- Jika sudah ada file PDF lama --}}
            @if($buku->file_pdf && file_exists(public_path('pdf/' . $buku->file_pdf)))
                <p class="mt-2">
                    📄 File saat ini: 
                    <a href="{{ asset('pdf/' . $buku->file_pdf) }}" target="_blank" class="text-decoration-none">
                        {{ $buku->file_pdf }}
                    </a>
                </p>
            @endif
        </div>

        {{-- Tombol Aksi --}}
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('bukus.index') }}" class="btn btn-secondary px-4 fw-semibold">← Kembali</a>
            <button type="submit" class="btn btn-primary px-4 fw-semibold">💾 Simpan Perubahan</button>
        </div>
    </form>
</div>

{{-- 🖼️ Script Preview Gambar Baru --}}
<script>
document.getElementById('sampulInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('previewImage');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
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
