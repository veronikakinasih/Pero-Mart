<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $fillable = [
        'id_kategori','nama_produk','gambar_produk','deskripsi_produk','harga_produk'
    ];
}
