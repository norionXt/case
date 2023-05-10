<?php 

namespace MyApp\Routers;

use MyApp\Controller\users;
use MyApp\System\Interfaces\IWeb;
use MyApp\System\Modules\Route\Route;


class Web implements IWeb{
    public static function loadRoutes () {
        Route::post('/usuario',[users::class, 'store']);
        Route::put('/transferencia',[users::class, 'transfer']);
    }
}