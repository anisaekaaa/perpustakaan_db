@extends('layouts.app')

@section('content')
@php
    use Illuminate\Support\Str;
@endphp

<div class="container py-5" 
     style="background: linear-gradient(135deg, #eef2f3, #dfe9f3); min-height: 100vh;">

    {{-- 🔹 Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">📚 Koleksi Buku</h2>
        <a href="{{ route('bukus.create') }}" class="btn btn-success fw-semibold shadow-sm">
            + Tambah Buku
        </a>
    </div>

    {{-- 🔍 Search Bar --}}
    <form method="GET" action="{{ route('bukus.index') }}" class="mb-5 d-flex align-items-center">
        <input type="text" name="search" value="{{ request('search') }}" 
               placeholder="Cari judul, penulis, atau penerbit..." 
               class="form-control me-2 rounded-3 shadow-sm p-3 flex-grow-1">
        <button type="submit" class="btn btn-primary rounded-3 px-3 py-2 fw-semibold me-2">
            Cari
        </button>
        <a href="{{ route('bukus.index') }}" class="btn btn-secondary rounded-3 px-3 py-2 fw-semibold">
            Reset
        </a>
    </form>

    {{-- 🔹 Jika tidak ada buku --}}
    @if ($bukus->isEmpty())
        <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
            <h3 class="text-muted fw-bold text-center">
                BELUM ADA BUKU YANG DITAMBAHKAN
            </h3>
        </div>

    @else

{{-- 🔹 Grid Buku --}}
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    @foreach ($bukus as $buku)
    <div class="col">
        <div class="card shadow-sm border-0 rounded-4 h-100 overflow-hidden buku-card"
             style="transition: all 0.3s ease;">

            {{-- 🖼️ Sampul Buku --}}
            <div class="text-center" style="height: 220px; overflow: hidden;">
                @if($buku->sampul)
                    <img src="{{ asset('image/' . $buku->sampul) }}" 
                         alt="{{ $buku->judul }}" 
                         class="img-fluid rounded-top" 
                         style="object-fit: cover; height: 100%; width: 100%;">
                @else
                    <img src="{{ asset('img/default-book.jpg') }}" 
                         alt="Sampul default" 
                         class="img-fluid rounded-top" 
                         style="object-fit: cover; height: 100%; width: 100%;">
                @endif
            </div>

            {{-- 📖 Info Buku --}}
            <div class="card-body">
                <h5 class="card-title text-primary fw-bold">{{ $buku->judul }}</h5>
                <p class="mb-1">✍️ <strong>{{ $buku->penulis }}</strong></p>
                <p class="mb-1">🏢 {{ $buku->penerbit }}</p>
                <p class="mb-1">📅 {{ $buku->tahun_terbit }}</p>
                <p class="text-muted small mt-2">
                    {{ Str::limit($buku->deskripsi, 80, '...') }}
                </p>
            </div>

            {{-- 🔸 Tombol Aksi --}}
            <div class="card-footer bg-transparent border-0 d-flex justify-content-between">
                <a href="{{ route('bukus.show', $buku->id) }}" 
                   class="btn btn-info btn-sm text-white fw-semibold shadow-sm">
                    Detail
                </a>
                <a href="{{ route('bukus.edit', $buku->id) }}" 
                   class="btn btn-warning btn-sm text-white fw-semibold shadow-sm">
                    Edit
                </a>
                <form action="{{ route('bukus.destroy', $buku->id) }}" method="POST"
                      onsubmit="return confirm('Yakin hapus buku ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm fw-semibold shadow-sm">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach 
</div>

    {{-- 🔻 Pagination --}}
    <div class="mt-5 d-flex justify-content-center">
        {{ $bukus->links() }}
    </div>

    @endif

</div>

{{-- ✨ Efek Hover --}}
<style>
.buku-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 8px 18px rgba(0, 0, 0, 0.1);
}
.card-footer .btn {
    margin-right: 4px;
}
</style>

@endsection
