<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ParametersFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'parameters';
    }
}
