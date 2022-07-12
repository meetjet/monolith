<?php

namespace App\Facades;

use App\Services\MenusManagerService;
use Illuminate\Support\Facades\Facade;

/**
 * @package App\Facades
 * @method array all()
 */
class Menus extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return MenusManagerService::class;
    }
}
