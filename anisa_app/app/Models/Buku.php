<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'deskripsi',
        'sampul',
        'file_pdf', 
    ];

      public function kategoris()
    {
        return $this->belongsToMany(Kategori::class, 'buku_kategori');
    }
}
