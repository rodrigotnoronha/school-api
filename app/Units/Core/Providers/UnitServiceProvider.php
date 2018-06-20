<?php

namespace Emtudo\Units\Core\Providers;

use Emtudo\Support\Units\ServiceProvider;

class UnitServiceProvider extends ServiceProvider
{
    protected $alias = 'core';

    protected $providers = [
        RouteServiceProvider::class,
    ];
}
