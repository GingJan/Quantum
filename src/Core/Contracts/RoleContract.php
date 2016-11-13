<?php
namespace Zjien\Quantum\Contracts;

interface RoleContract
{
    /**
     * Many to Many relations with the user model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users();

    /**
     * Many to Many relations with the permission model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions();

    /**
     * Attach Permission for Role
     *
     * @param object|array $permissions
     * @return void
     */
    public function attachPermission($permissions);

    /**
     * Update Permission for Role
     *
     * @param object|array $permissions
     * @return mixed
     */
    public function updatePermission($permissions);

    /**
     * Detach Permission for Role
     *
     * @param object|array $permissions
     * @return void
     */
    public function detachPermission($permissions);

    /**
     * Detach All Permissions for Role
     *
     * @return void
     */
    public function detachAllPermissions();

    /**
     * Detach All Users for Role
     *
     * @return void
     */
    public function detachAllUsers();

}