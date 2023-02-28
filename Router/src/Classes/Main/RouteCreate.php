<?php

namespace Jefferson\Router\Classes\Main;

use Jefferson\Router\Classes\Errors\RouterParserException;
use Jefferson\Router\Classes\Interfaces\RouteCreateInterface;
use Jefferson\Router\Support\Container\Container;
use Jefferson\Router\Support\Traits\ParseRoute;

/**
 * @author Jefferson Silva
 */
final class RouteCreate implements RouteCreateInterface
{

    use ParseRoute;

    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    private function create(string $method, string $pattern, mixed $handler): void
    {
        try {
            self::pattern('method',$method);
            self::pattern('route',$pattern);
            self::pattern('handler', $handler);
            $path = self::extract($pattern,'path');
            $handler = self::separateHandler($handler);
            $controller = is_callable($handler) ? null : $handler[0];
            $action = is_callable($handler) ? $handler : $handler[1];
            $parameter = self::extract($pattern, 'parameter');
            new Route($method, $path, $controller, $action, $parameter);

        } catch (RouterParserException $e) {
            echo $e->getMessage();
        }
    }

    public function get(string $pattern, mixed $handler)
    {
        self::create('GET',$pattern,$handler);
    }


    public function post(string $pattern, mixed $handler)
    {
        self::create('POST',$pattern,$handler);
    }


    public function put(string $pattern, mixed $handler)
    {
        self::create('PUT',$pattern,$handler);
    }


    public function delete(string $pattern, mixed $handler)
    {
        self::create('DELETE',$pattern,$handler);
    }
}