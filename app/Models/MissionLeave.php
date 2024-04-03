<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MissionLeave extends Model
{
    use HasFactory;
    protected $fillable = [
        'purpose',
        'user_id',
        'leader_approval',
        'ceo_approval',
        'hr_manager_approval',
        'cfo_approval'
        // Add other fillable fields here as needed
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
