<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;

    protected $primaryKey = 'proposal_id';

    protected $fillable = ['title', 'description', 'date_submitted', 'status', 'submitted_by', 'approval_status', 'approved_by', 'revision_count', 'event_date', 'faculty_id', 'file_path'];

    protected $casts = [
        'date_submitted' => 'datetime',
        'event_date' => 'datetime',
    ];

    // Relasi ke User (Pengaju Proposal)
    public function user()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    // Relasi ke Fakultas
    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }

    // Relasi ke User (Penyetuju Proposal)
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Relasi ke StatusTrackings (Semua Status)
    public function statusTrackings()
    {
        return $this->hasMany(StatusTracking::class, 'proposal_id');
    }

    // Relasi ke StatusTracking Terbaru
    public function latestStatusTracking()
    {
        return $this->hasOne(StatusTracking::class, 'proposal_id')->orderByDesc('updated_at');
    }

    // Akses URL File
    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }

    // Scope Pencarian
    public function scopeSearch($query, $term)
    {
        if ($term) {
            $query->where(function ($query) use ($term) {
                $query->where('title', 'like', '%' . $term . '%')->orWhere('description', 'like', '%' . $term . '%');
            });
        }
        return $query;
    }

    // Scope Sortir
    public function scopeSortBy($query, $sortColumn, $sortDirection)
    {
        $validColumns = ['title', 'date_submitted', 'status'];
        if (in_array($sortColumn, $validColumns)) {
            return $query->orderBy($sortColumn, $sortDirection);
        }
        return $query;
    }
}
