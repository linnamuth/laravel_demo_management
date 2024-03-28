<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;
    protected $fillable = ['type', 'start_date', 'end_date', 'reason', 'status', 'duration', 'days'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
