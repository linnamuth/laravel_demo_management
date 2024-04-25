<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'department_id',
        'type',
        'start_date',
        'end_date',
        'reason',
        'duration',
        'status',
        'is_approved',
        'is_rejected',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function approvals()
    {
        return $this->hasMany(LeaveRequestApprove::class, 'leave_request_id');  // Define relationship
    }
}
