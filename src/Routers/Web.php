<?php 

namespace MyApp\Routers;

use MyApp\Controller\usuarios;
use MyApp\System\Interfaces\IWeb;
use MyApp\System\Modules\Route\Route;


class Web implements IWeb{
    public static function loadRoutes () {
        Route::post('localhost/usuario',[usuarios::class, 'store']);
        Route::post('localhost/transferencia',[usuarios::class, 'update']);
    }
}