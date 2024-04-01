<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;
    protected $fillable = ['type', 'start_date', 'end_date', 'reason', 'status', 'duration', 'days','user_id','team_leader_approval','hr_manager_approval','cfo_approval','hr_reject','team_leader_reject','cfo_reject'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
