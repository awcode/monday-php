<?php

namespace Awcode\MondayPHP;

use Illuminate\Support\Facades\Facade;

class MondayPHPFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'monday-php';
    }

}
