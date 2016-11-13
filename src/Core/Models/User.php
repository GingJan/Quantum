<?php
namespace Zjien\Quantum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Zjien\Quantum\Contracts\UserContract;
use Zjien\Quantum\Traits\UserTrait;

class User extends Model implements UserContract
{
    use UserTrait;
    /**
     * The User table.
     *
     * @var
     */
    protected $table;

}
