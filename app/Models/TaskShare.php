<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskShare extends Model
{
    use HasFactory;

    // Menentukan nama tabel yang digunakan
    protected $table = 'task_shares';

    // Menentukan kolom yang dapat diisi massal
    protected $fillable = [
        'task_id',
        'shared_with',
        'permission',
    ];

    // Menentukan jenis kolom yang perlu di-cast
    protected $casts = [
        'permission' => 'string', // Cast permission menjadi string jika diperlukan
    ];

    /**
     * Mendefinisikan relasi ke tabel tasks.
     */
    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    /**
     * Mendefinisikan relasi ke tabel users.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'shared_with');
    }
}
