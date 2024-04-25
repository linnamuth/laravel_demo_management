<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Workflow extends Model
{
    use HasFactory;
    protected $fillable = ['department_id', 'request_type', 'approve_role'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'workflow_roles', 'workflow_id', 'role_id');
    }


    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    

}
