<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Role as ModelsRole;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'department_id',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function isAdmin()
    {
        return $this->roles()->where('name', 'Admin')->exists();
    }


    // public function isTeamLeader(): bool
    // {

    //     return $this->roles()->where('name', 'team leader')->exists();
    // }
    // public function isHRManager(): bool
    // {
    //     return $this->roles()->where('name', 'hr manager')->exists();
    // }
    // public function isCFO(): bool
    // {
    //     return $this->roles()->where('name', 'cfo')->exists();
    // }
    // public function isCEO(): bool
    // {
    //     return $this->roles()->where('name', 'ceo')->exists();
    // }



    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function hasAnyRole(array $roleNames): bool
    {
        return $this->roles()->whereIn('name', $roleNames)->exists();
    }
    // public function role()
    // {
    //     return $this->belongsTo(Role::class);
    // }
    public function departments()
    {
        return $this->belongsToMany(Department::class, 'user_departments');
    }
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id'); // 'role_id' is the foreign key
    }
   
}
