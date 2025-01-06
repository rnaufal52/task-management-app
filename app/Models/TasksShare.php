<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TasksShare extends Model
{
    // Tentukan nama tabel jika tidak mengikuti konvensi Laravel
    protected $table = 'task_shares';

    // Tentukan kolom yang dapat diisi massal
    protected $fillable = [
        'task_id',
        'shared_with',
        'permission',
    ];

    // Tentukan kolom yang harus di-cast (misalnya labels menjadi array)
    protected $casts = [
        'permission' => 'string', // Pastikan 'permission' disimpan sebagai string
    ];

    /**
     * Definisikan relasi dengan model Task
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Definisikan relasi dengan model User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'shared_with');
    }
}
