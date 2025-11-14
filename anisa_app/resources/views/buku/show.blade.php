@extends('layouts.app')

@section('content')
<div class="container py-5" 
     style="background: linear-gradient(135deg, #eef2f3, #dfe9f3); min-height: 100vh;">

    @php
        $previous = url()->previous();
    @endphp

    <div class="card shadow-lg border-0 rounded-4 overflow-hidden mx-auto" style="max-width: 700px;">

        {{-- 🖼️ Sampul Buku --}}
        @if($buku->sampul)
            <img src="{{ asset('image/' . $buku->sampul) }}" 
                 class="card-img-top" 
                 alt="{{ $buku->judul }}" 
                 style="max-height: 380px; object-fit: cover;">
        @else
            <img src="{{ asset('img/default-book.jpg') }}" 
                 class="card-img-top" 
                 alt="Sampul default" 
                 style="max-height: 380px; object-fit: cover;">
        @endif

        {{-- 📚 Detail Buku --}}
        <div class="card-body p-4 text-center">
            <h3 class="fw-bold text-primary mb-3">{{ $buku->judul }}</h3>
            
            <ul class="list-unstyled mb-4 text-start d-inline-block">
                <li><strong>✍️ Penulis:</strong> {{ $buku->penulis }}</li>
                <li><strong>🏢 Penerbit:</strong> {{ $buku->penerbit }}</li>
                <li><strong>📅 Tahun Terbit:</strong> {{ $buku->tahun_terbit }}</li>
                <li><strong>📦 Stok:</strong> {{ $buku->stok }}</li>
            </ul>

            <p class="text-muted text-start d-inline-block" style="white-space: pre-line;">
                <strong>📝 Deskripsi:</strong><br>
                {{ $buku->deskripsi }}
            </p>

            {{-- 🏷️ Kategori --}}
            <p class="mt-3"><strong>Kategori:</strong>
                @foreach ($buku->kategoris as $kategori)
                    <span class="badge bg-primary">{{ $kategori->nama }}</span>
                @endforeach
            </p>

            <p><strong>Kategori:</strong>
@foreach ($buku->kategoris as $kategori)
    <span class="badge bg-primary">{{ $kategori->nama }}</span>
@endforeach
</p>


            {{-- 🎓 Tombol aksi --}}
            <div class="mt-4">
                @auth
                <a href="{{ $previous }}" class="btn btn-secondary rounded-3 fw-semibold shadow-sm px-4">
                ← Kembali
            </a>
            @else
    
    @if (str_contains($previous, route('landing')))
        <a href="{{ route('landing') }}" class="btn btn-secondary rounded-3 fw-semibold shadow-sm px-4">
            ← Kembali
        </a>
    @else
        <a href="{{ $previous }}" class="btn btn-secondary rounded-3 fw-semibold shadow-sm px-4">
            ← Kembali
        </a>
    @endif
@endauth

                @auth
                <a href="{{ route('bukus.edit', $buku->id) }}" 
                   class="btn btn-warning text-white rounded-3 fw-semibold shadow-sm px-4 ms-2">
                    ✏️ Edit
                </a>
                @endauth
            </div>

            {{-- 📖 Tombol Baca Buku (PDF) --}}
            @if($buku->file_pdf && file_exists(public_path('pdf/' . $buku->file_pdf)))
                <div class="mt-4">
                    <a href="{{ asset('pdf/' . $buku->file_pdf) }}" 
                       target="_blank" 
                       class="btn btn-success rounded-3 fw-semibold shadow-sm px-4">
                        📖 Baca Buku
                    </a>
                </div>
            @else
                <p class="text-muted mt-3 fst-italic">Tidak ada file PDF yang tersedia untuk buku ini.</p>
            @endif
        </div>
    </div>
</div>

{{-- ✨ Efek hover --}}
<style>
.card:hover {
    transform: scale(1.01);
    transition: all 0.3s ease;
}
</style>
@endsection
