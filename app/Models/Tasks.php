<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak mengikuti konvensi penamaan
    protected $table = 'tasks';

    // Tentukan kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'title', 'description', 'deadline', 'status', 'labels'
    ];

    // Tentukan kolom tanggal agar otomatis di-cast ke Carbon (untuk bekerja dengan format tanggal)
    protected $casts = [
        'deadline' => 'datetime',
        'labels' => 'array',  // Pastikan menggunakan satu array untuk semua cast
    ];
}
