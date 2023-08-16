<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ProductImporterFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'product-importer'; // The name of the service container binding
    }
}
