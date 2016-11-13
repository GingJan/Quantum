<?php
namespace Zjien\Quantum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Zjien\Quantum\Contracts\PermissionContract;
use Zjien\Quantum\Traits\PermissionTrait;

class Permission extends Model implements PermissionContract
{
    use PermissionTrait;

    //resource status
    const STATUS_CLOSING = 1;
    const STATUS_OPENING = 0;

    /**
     * The Permission table.
     *
     * @var
     */
    protected $table;

    protected $fillable = ['name', 'verb', 'uri', 'display_name', 'description', 'status'];

}