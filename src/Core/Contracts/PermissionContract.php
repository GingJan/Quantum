<?php
namespace Zjien\Quantum\Contracts;

interface PermissionContract
{
    /**
     * Many to Many relations with the role model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles();
}