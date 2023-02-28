<?php

namespace Jefferson\Router\Classes\Interfaces;

interface RouteCreateInterface
{

    public function get(string $pattern, mixed $handler);

    public function post(string $pattern, mixed $handler);

    public function put(string $pattern, mixed $handler);

    public function delete(string $pattern, mixed $handler);


}