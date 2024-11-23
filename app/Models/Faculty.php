<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $primaryKey = 'faculty_id';
    protected $fillable = ['name'];

    public function roles()
    {
        return $this->hasMany(Role::class, 'faculty_id');
    }
}
