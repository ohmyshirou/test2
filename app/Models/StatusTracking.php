<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StatusTracking extends Model
{
    use HasFactory;

    protected $primaryKey = 'tracking_id';
    protected $fillable = ['proposal_id', 'status', 'updated_by', 'comment', 'role_id', 'update_at'];

    // Relasi ke Proposal
    public function proposal()
    {
        return $this->belongsTo(Proposal::class, 'proposal_id');
    }
}
