<?php

namespace Jefferson\Router\Classes\Interfaces;

use Jefferson\Router\Classes\Errors\RouterParserException;
interface RouteCreateInterface
{
    /**
     * @throws RouterParserException
     */
    public function get(string $pattern, mixed $handler);

    /**
     * @throws RouterParserException
     */
    public function post(string $pattern, mixed $handler);


}