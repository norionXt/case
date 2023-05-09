<?php 

namespace MyApp\System\Middlewares;

use MyApp\System\Interfaces\IMiddleware;
use MyApp\System\Interfaces\IRequest;
use MyApp\System\Interfaces\IResponse;

class Auth implements IMiddleware {

    public function process(IRequest $request, ):IResponse {
        return next([]);
    } 
}