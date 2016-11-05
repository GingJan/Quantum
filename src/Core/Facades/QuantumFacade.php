<?php
namespace Zjien\Quantum\Facades;

use Illuminate\Support\Facades\Facade;

class QuantumFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'quantum';
    }
}