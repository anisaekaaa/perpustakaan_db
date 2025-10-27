@extends('layouts.app')

@section('content')
<div class="container py-5" style="background: linear-gradient(135deg, #eef2f3, #dfe9f3); min-height: 100vh;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">📚 Koleksi Buku</h2>
        <a href="{{ route('buku.create') }}" class="btn btn-success fw-semibold">+ Tambah Buku</a>
    </div>

    {{-- 🔍 Search Bar --}}
    <form method="GET" action="{{ route('buku.index') }}" class="mb-5 d-flex align-items-center">
        <input type="text" name="search" value="{{ request('search') }}" 
               placeholder="Cari judul, penulis, atau penerbit..." 
               class="form-control me-2 rounded-3 shadow-sm p-3 flex-grow-1">
        <button type="submit" class="btn btn-primary rounded-3 px-3 py-2 fw-semibold me-2">
            🔍 Cari
        </button>
        <a href="{{ route('buku.index') }}" class="btn btn-secondary rounded-3 px-3 py-2 fw-semibold">
            ♻️ Reset
        </a>
    </form>

    {{-- 🔹 Grid Buku --}}
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($bukus as $buku)
        <div class="col">
            <div class="card shadow-sm border-0 rounded-4 h-100 p-3" 
                 style="background: #fff; transition: all 0.3s ease;">
                <div class="card-body">
                    <h5 class="card-title text-primary fw-bold">{{ $buku->judul }}</h5>
                    <p class="card-text mb-1">✍️ <strong>{{ $buku->penulis }}</strong></p>
                    <p class="card-text mb-1">🏢 {{ $buku->penerbit }}</p>
                    <p class="card-text">📅 {{ $buku->tahun_terbit }}</p>
                </div>

                {{-- 🔸 Tombol Aksi --}}
                <div class="card-footer bg-transparent border-0 d-flex justify-content-between">
                    <a href="{{ route('buku.show', $buku->id) }}" class="btn btn-info btn-sm text-white fw-semibold">
                        👁️ Detail
                    </a>
                    <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-warning btn-sm text-white fw-semibold">
                        ✏️ Edit
                    </a>
                    <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" onsubmit="return confirm('Yakin hapus buku ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm fw-semibold">
                            🗑️ Hapus
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
</div>
@endsection
