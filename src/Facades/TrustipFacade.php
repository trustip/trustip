<?php

namespace Trustip\Trustip\Facades;

use Illuminate\Support\Facades\Facade;

class TrustipFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'trustip';
    }
}
