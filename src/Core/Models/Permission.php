<?php
namespace Zjien\Quantum\Models;

use Illuminate\Support\Facades\Config;
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

    protected $fillable = ['name', 'verb', 'uri', 'display_name', 'description', 'status'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = Config::get('config.database.tables.permission');
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
        return $this->belongsToMany(Config::get('config.model.role'), Config::get('config.database.tables.user_role_relation'));
    }
}