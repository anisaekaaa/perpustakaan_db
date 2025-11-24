<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Digital</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            scroll-behavior: smooth;
        }

        /* Navbar Transparan → Berubah saat Scroll */
        .navbar-custom {
            position: fixed;
            width: 100%;
            z-index: 999;
            transition: all 0.3s;
            padding: 18px 0;
        }
        .navbar-scrolled {
            background: #ffffff !important;
            box-shadow: 0 2px 14px rgba(0,0,0,0.08);
            padding: 12px 0;
        }

        /* Hero Section */
       .hero {
    background: linear-gradient(rgba(0, 0, 0, 0.35), rgba(0, 0, 0, 0.35)),
                url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&w=1600&q=80') center/cover no-repeat;
    height: 90vh;
    display: flex;
    align-items: center;
    text-align: center;
    color: #ffffff; /* 🔥 warna judul jadi putih */
}

        .btn-sky {
            background: #4DB6E3;
            color: white;
            border-radius: 6px;
        }

        .btn-sky-outline {
            border: 2px solid #4DB6E3;
            color: #4DB6E3;
            border-radius: 6px;
        }

        .card-buku {
            border-radius: 15px;
            transition: 0.3s;
        }
        .card-buku:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        .chip {
            background: #4DB6E322;
            padding: 8px 16px;
            border-radius: 30px;
            margin: 4px;
            display: inline-block;
            cursor: pointer;
            transition: .3s;
        }
        .chip:hover {
            background: #4DB6E3;
            color: white;
        }

        footer {
            background: #4DB6E3;
            color: white;
            padding: 20px 0;
            text-align: center;
        }
    </style>
</head>

<body>

<!-- ✅ Navbar -->
<nav class="navbar navbar-expand-lg navbar-light navbar-custom">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#" style="color:#4DB6E3;">PerpustakaanKu</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse text-end" id="nav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item mx-2"><a class="nav-link" href="#koleksi" style="color:#4DB6E3">Koleksi</a></li>
                <li class="nav-item mx-2"><a class="nav-link" href="#kategori" style="color:#4DB6E3">Kategori</a></li>
                <li class="nav-item mx-2"><a class="nav-link" href="#rekomendasi" style="color:#4DB6E3">Rekomendasi</a></li>
                <li class="nav-item mx-2"><a href="{{ route('login') }}" class="btn btn-sky-outline">Login</a></li>
                <li class="nav-item mx-2"><a href="{{ route('register') }}" class="btn btn-sky">Register</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- ✅ Hero -->
<section class="hero">
    <div class="container">
        <h1 class="fw-bold display-4">Selamat Datang di Perpustakaan Digital</h1>
        <p class="lead mt-3 mb-4">Jelajahi koleksi buku pilihan dengan mudah kapan saja</p>
        <a href="#koleksi" class="btn btn-sky px-4 py-2 me-2">Lihat Koleksi</a>
        <a href="{{ route('login') }}" class="btn btn-sky-outline px-4 py-2">Masuk</a>
    </div>
</section>

<!-- ✅ Koleksi Preview -->
<section id="koleksi" class="container py-5">
    <h2 class="fw-bold text-center mb-4">Koleksi Terbaru</h2>
    <div class="row">
        @foreach($koleksi as $b)
        <div class="col-md-3 mb-4">
            <div class="card card-buku shadow-sm">
                <img src="{{ asset('image/'.$b->sampul) }}" class="card-img-top" style="height:260px; object-fit:cover;">
                <div class="card-body text-center">
                    <h5 class="fw-semibold">{{ $b->judul }}</h5>
                    <small class="text-muted">{{ $b->penulis }}</small>
                    <a href="{{ route('bukus.show', $b->id) }}" class="btn btn-sm btn-primary">
                    Lihat</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

<!-- ✅ Kategori -->
<section id="kategori" class="py-5" style="background:#EEF8FF;">
    <div class="container text-center">
        <h2 class="fw-bold mb-3">Kategori Buku</h2>

        @if($kategoris->isEmpty())
            <p class="text-muted">BELUM ADA KATEGORI DITAMBAHKAN</p>
        @else
            @foreach($kategoris as $k)
            <a 
                href="{{ route('buku.byKategori', $k->id) }}" 
                class="chip"
        >
                    {{ $k->nama }}
                </a>
            @endforeach
        @endif
    </div>
</section>


<!-- ✅ Rekomendasi -->
<section id="rekomendasi" class="container py-5">
    <h2 class="fw-bold text-center mb-4">Rekomendasi Untukmu</h2>
    <div class="row justify-content-center">
        @foreach($rekomendasi as $r)
        <div class="col-md-4 mb-4">
            <div class="card card-buku shadow">
                <img src="{{ asset('image/'.$r->sampul) }}" class="card-img-top" style="height:300px; object-fit:cover;">
                <div class="card-body text-center">
                    <span class="badge bg-warning text-dark mb-2">⭐ Rekomendasi</span>
                    <h5 class="fw-semibold">{{ $r->judul }}</h5>
                    <small class="text-muted">{{ $r->penulis }}</small>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

<!-- ✅ Footer -->
<footer>
    <p>© {{ date('Y') }} PerpustakaanKu — Semua Hak Dilindungi</p>
</footer>

<script>
    // Navbar Scroll Effect
    const nav = document.querySelector('.navbar-custom');
    window.addEventListener('scroll', () => {
        nav.classList.toggle('navbar-scrolled', window.scrollY > 20);
    });
</script>

</body>
</html>
