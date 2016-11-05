<?php
namespace Zjien\Quantum\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Zjien\Quantum\Contracts\PermissionContract;

class Permission extends Quantum implements PermissionContract
{
    const STATUS_CLOSING = 0;
    const STATUS_OPENING = 1;
    /**
     * The Permission table.
     *
     * @var
     */
    protected $table;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('config.database.tables.permission');
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function($permission) {
            $permission->roles()->detach();
        });
    }
    /**
     * Many to Many relations with the role model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(config('config.model.role'), config('config.database.tables.user_role_relation'));
    }
}