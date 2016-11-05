<?php
namespace Zjien\Quantum\Contracts;

interface UserContract
{
    /**
     * Many to Many relations with the role model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles();

    /**
     * Attach Role for User.
     *
     * @param array|object $roles
     * @return mixed
     */
    public function attachRole($roles);

    /**
     * Update Role for User.
     *
     * @param array|object $roles
     * @return mixed
     */
    public function updateRole($roles);

    /**
     * Detach Role for User.
     *
     * @param array|object $roles
     * @return mixed
     */
    public function detachRole($roles);

    /**
     * Detach all Roles for User
     *
     * @return mixed
     */
    public function detachAllRoles();

    /**
     * Determine if the User has a given permission.
     *
     * @param array|object $permissions
     * @param bool $all
     * @return bool
     */
    public function can($permissions, $all);

    /**
     * Determine if the User has a given role.
     *
     * @param array|object $roles
     * @param bool $all
     * @return bool
     */
    public function is($roles, $all);

    /**
     * @param array|object $permissions
     * @param array|object $roles
     * @param bool $all
     * @return bool
     */
    public function ability($permissions, $roles, $all);
}