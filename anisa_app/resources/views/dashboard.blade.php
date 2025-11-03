@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="text-center mt-5">
    {{-- Judul Utama --}}
    <h1 class="fw-bold text-primary mb-2" style="font-size: 2.8rem; letter-spacing: 1px;">
        🏛️ Dashboard Perpustakaan 🏛️
    </h1>

    {{-- Tanggal --}}
    <p class="text-muted mb-1" style="font-size: 1.1rem;">
        {{ now()->translatedFormat('l, d F Y') }}
    </p>

    {{-- Sambutan --}}
    <h4 class="fw-semibold text-dark">
        👋 Selamat datang, <span class="text-success">{{ Auth::user()->name }}</span>!
    </h4>
</div>

{{-- Kartu Info di Tengah --}}
<div class="d-flex justify-content-center align-items-center gap-4 mt-5 flex-wrap">
    {{-- Total Buku --}}
    <div class="card border-0 shadow-lg text-center" style="width: 250px; border-radius: 20px;">
        <div class="card-body">
            <i class="bi bi-book fs-1 text-primary mb-2"></i>
            <h5 class="fw-semibold text-secondary mb-1">Total Buku</h5>
            <h2 class="fw-bold text-dark">{{ $totalBuku }}</h2>
        </div>
    </div>

    {{-- Total Anggota --}}
    <div class="card border-0 shadow-lg text-center" style="width: 250px; border-radius: 20px;">
        <div class="card-body">
            <i class="bi bi-people fs-1 text-success mb-2"></i>
            <h5 class="fw-semibold text-secondary mb-1">Jumlah Anggota</h5>
            <h2 class="fw-bold text-dark">{{ $totalUser }}</h2>
        </div>
    </div>
</div>

<hr class="my-5">

{{-- Buku Terbaru --}}
<div class="mt-4 text-center">
    <h4 class="fw-bold text-primary mb-3">📖 Buku Terbaru</h4>
    <table class="table table-hover w-75 mx-auto shadow-sm rounded-3">
        <thead class="table-primary">
            <tr>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th>Tahun</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bukuTerbaru->take(2) as $buku)
            <tr>
                <td>{{ $buku->judul }}</td>
                <td>{{ $buku->penulis }}</td>
                <td>{{ $buku->penerbit }}</td>
                <td>{{ $buku->tahun_terbit }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-muted">Belum ada buku terbaru.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Statistik --}}
<div class="mt-5 text-center">
    <h4 class="fw-bold text-primary mb-3">📈 Statistik Buku per Penerbit</h4>
    <table class="table table-bordered w-75 mx-auto shadow-sm rounded-3">
        <thead class="table-light">
            <tr>
                <th>Penerbit</th>
                <th>Jumlah Buku</th>
            </tr>
        </thead>
        <tbody>
            @foreach($statistik as $data)
            <tr>
                <td>{{ $data->penerbit }}</td>
                <td>{{ $data->total }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
