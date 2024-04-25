<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class WorkflowRole extends Model
{
    use HasFactory;
    protected $table = 'workflow_roles';

    // Relationships with Workflow and Role
    public function workflow()
    {
        return $this->belongsTo(Workflow::class, 'workflow_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
