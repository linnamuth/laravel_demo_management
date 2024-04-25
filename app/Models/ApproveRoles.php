<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class ApproveRoles extends Model
{
    use HasFactory;
    protected $fillable = [
        'department_id',
        'role_id',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }


    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
