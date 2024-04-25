<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDepartment extends Model
{
    use HasFactory;
    protected $table = 'leave_request_approves';

    // The attributes that are mass-assignable
    protected $fillable = [
        'user_id',
        'department_id',
    ];
}
