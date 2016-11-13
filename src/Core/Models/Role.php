<?php
namespace Zjien\Quantum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Zjien\Quantum\Contracts\RoleContract;
use Zjien\Quantum\Traits\RoleTrait;

class Role extends Model implements RoleContract
{
    use RoleTrait;

    /**
     * The Role table.
     *
     * @var
     */
    protected $table;

}