<?php
namespace Zjien\Quantum\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Zjien\Quantum\Contracts\RoleContract;

class Role extends Quantum implements RoleContract
{
    /**
     * The Role table.
     *
     * @var
     */
    protected $table;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = Config::get('config.database.role');
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        static::deleting(function($role) {
            $role->detachAllPermissions();
            $role->detachAllUsers();

            return true;
        });
    }

    /**
     * Many to Many relations with the user model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(Config::get('auth.model'), Config::get('config.database.tables.user_role_relation'));
    }

    /**
     * Many to Many relations with the user model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Config::get('config.model.permission'), Config::get('config.database.tables.role_permission_relation'));
    }

    /**
     * Attach Permission for Role.
     *
     * @param array|Model|Collection $permissions
     * @return void
     */
    public function attachPermission($permissions)
    {
        $this->permissions()->attach(static::normalize($permissions));
    }

    /**
     * Update Permission for Role.
     *
     * @param array|Model|Collection $permissions
     * @return array
     */
    public function updatePermission($permissions)
    {
        return $this->permissions()->sync(static::normalize($permissions));
    }

    /**
     * Detach Permission for Role.
     *
     * @param array|Model|Collection $permissions
     * @return int
     */
    public function detachPermission($permissions)
    {
        return $this->permissions()->detach(static::normalize($permissions));
    }

    /**
     * Detach All Permissions of the Role
     *
     * @return int
     */
    public function detachAllPermissions()
    {
        return $this->permissions()->detach();
    }

    /**
     * Detach All Users of the Role
     *
     * @return int
     */
    public function detachAllUsers()
    {
        return $this->user()->detach();
    }

}