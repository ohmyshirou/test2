<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dekan extends Model
{
    use HasFactory;

    protected $table = 'dekan'; // Nama tabel
    protected $primaryKey = 'dekan_id'; // Primary key tabel
    public $timestamps = true; // Aktifkan timestamp jika ada `created_at` dan `updated_at`

    protected $fillable = [
        'user_id',
        'faculty_id',
    ];

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke model Fakultas
    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }
}
