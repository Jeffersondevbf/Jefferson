<?php

namespace Jefferson\Router\Classes\Main;

use Jefferson\Router\Support\Container\Container;

class Router extends RouteStorage
{

    private Container $container;
    private RouteCreate $routeCreate;

    public function __construct()
    {
        $this->container = new Container();
        $router = $this->container->create('router');
        $this->routeCreate = new RouteCreate($this->container);
    }

    /**
     * @return RouteCreate
     */
    public function startCreating(): RouteCreate
    {
        return $this->routeCreate;
    }

    public function showRoutes(): void
    {

    }

    public function save()
    {
        return $this->container;
    }
}