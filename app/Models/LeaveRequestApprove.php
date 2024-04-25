<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class LeaveRequestApprove extends Model
{
    use HasFactory;
    protected $table = 'leave_request_approves';

    // The attributes that are mass-assignable
    protected $fillable = [
        'leave_request_id',
        'role_id',
        'status',
        'approved_by',
        'approved_at'
    ];

    public function leaveRequest()
    {
        return $this->belongsTo(LeaveRequest::class, 'leave_request_id');
    }

    public function approvals()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
