<?php

namespace App\Models;

use Ajimoti\RolesAndPermissions\Collections\RoleCollection;
use Ajimoti\RolesAndPermissions\Facades\Check;
use Ajimoti\RolesAndPermissions\HasRoles;
use App\Enums\Role;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => "datetime",
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
        'role',
        'role_description',
        'roles_list',
        'permissions_list',
    ];

    /**
     * The roles assigned to the user.
     *
     * @var RoleCollection
     */
    protected RoleCollection $assignedRoles;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->assignedRoles = app(RoleCollection::class);
    }

    /**
     * @return Role|null
     */
    public function getRoleAttribute(): ?Role
    {
        return $this->roles()->first();
    }

    /**
     * @return string|null
     */
    public function getRoleDescriptionAttribute(): ?string
    {
        if ($this->role) {
            return $this->role->description;
        }

        return null;
    }

    /**
     * Get the full list of roles.
     */
    public function getRolesListAttribute(): array
    {
        return $this->roles()->toArray();
    }

    /**
     * Get the full list of permissions.
     */
    public function getPermissionsListAttribute(): array
    {
        return $this->permissions()->toArray();
    }

    /**
     * @inheritDoc
     */
    public function roles(): RoleCollection
    {
        // Database query optimization.
        if ($this->assignedRoles->isEmpty()) {
            $this->assignedRoles = $this->repository()->roles();
        }

        return $this->assignedRoles;
    }

    /**
     * @inheritDoc
     */
    public function hasRole(...$roles): bool
    {
        $roles = collect($roles)->flatten()->toArray();

        // Database query optimization.
        return Check::all($roles)->existsIn($this->roles()->toArray());
    }
}
