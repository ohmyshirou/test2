<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasFactory;

    protected $primaryKey = 'user_id';
    public $incrementing = true;
    protected $fillable = ['username', 'password', 'email', 'role_id'];
    protected $hidden = ['password'];

    public function getAuthIdentifierName()
    {
        return 'user_id'; // Specify your custom primary key
    }

    public function getAuthIdentifier()
    {
        return $this->user_id;
    }
    

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }
    
    // Relasi ke Proposal
    public function proposals(): HasMany
    {
        return $this->hasMany(Proposal::class, 'submitted_by');
    }

    // Relasi ke Chat sebagai pengirim
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // Relasi ke Chat sebagai penerima
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    // Relasi ke Notification
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    // relasi untuk mendapatkan pesan terakhir
    public function lastMessage($otherUserId)
    {
        if (!$this->user_id) {
            return null; // Jika user_id null, langsung kembalikan null
        }

        return Message::where(function ($query) use ($otherUserId) {
            $query->where('sender_id', $this->user_id)->where('receiver_id', $otherUserId);
        })
            ->orWhere(function ($query) use ($otherUserId) {
                $query->where('sender_id', $otherUserId)->where('receiver_id', $this->user_id);
            })
            ->latest('created_at')
            ->first();
    }

    public function dekan()
    {
        return $this->hasOne(Dekan::class, 'user_id');
    }
}
