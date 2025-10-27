@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Detail Buku</h3>
    <div class="card mt-3">
        <div class="card-body">
            <p><strong>Judul:</strong> {{ $buku->judul }}</p>
            <p><strong>Penulis:</strong> {{ $buku->penulis }}</p>
            <p><strong>Penerbit:</strong> {{ $buku->penerbit }}</p>
            <p><strong>Tahun Terbit:</strong> {{ $buku->tahun_terbit }}</p>
            <p><strong>Stok:</strong> {{ $buku->stok }}</p>
            <a href="{{ route('buku.index') }}" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>
</div>
@endsection
