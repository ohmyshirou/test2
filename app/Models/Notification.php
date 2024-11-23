<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $primaryKey = 'notification_id';
    protected $fillable = ['user_id', 'message', 'is_read', 'status_tracking_id'];

    // Relasi ke User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke StatusTracking
    public function statusTracking(): BelongsTo
    {
        return $this->belongsTo(StatusTracking::class, 'status_tracking_id');
    }
}

