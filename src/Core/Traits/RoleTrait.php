<?php
namespace Zjien\Quantum\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Zjien\Quantum\Quantum;

trait RoleTrait
{
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
        return $this->belongsToMany(Config::get('auth.model'), Config::get('quantum.database.tables.user_role_relation'), 'role_id', 'user_id');
    }

    /**
     * Many to Many relations with the user model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Config::get('quantum.model.permission'), Config::get('quantum.database.tables.role_permission_relation'), 'role_id', 'permission_id');
    }

    /**
     * Attach Permission for Role.
     *
     * @param array|Model|Collection $permissions
     * @return void
     */
    public function attachPermission($permissions)
    {
        $this->permissions()->attach(Quantum::normalize($permissions));
    }

    /**
     * Update Permission for Role.
     *
     * @param array|Model|Collection $permissions
     * @return array
     */
    public function updatePermission($permissions)
    {
        return $this->permissions()->sync(Quantum::normalize($permissions));
    }

    /**
     * Detach Permission for Role.
     *
     * @param array|Model|Collection $permissions
     * @return int
     */
    public function detachPermission($permissions)
    {
        return $this->permissions()->detach(Quantum::normalize($permissions));
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
        return $this->users()->detach();
    }

}