<?php


namespace MyApp\System\Interfaces;


interface IMiddleware {
    public function process(IRequest $request): IResponse;
}