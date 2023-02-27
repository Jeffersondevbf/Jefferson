<?php

namespace Jefferson\Router\Classes\Main;

use Jefferson\Router\Classes\Interfaces\PatternInterface;
use Jefferson\Router\Support\Pattern\DefaultPattern;

class Router
{

    private Container $container;

    private RouteCreate $routeCreate;

    private DefaultPattern $defaultPattern;

    public function __construct()
    {
        $this->container = new Container();
        $this->defaultPattern = new DefaultPattern();
        $this->routeCreate = new RouteCreate($this->defaultPattern, $this->container);
    }

    /**
     * @param PatternInterface|null $pattern
     * @return RouteCreate
     */
    public function startCreating(PatternInterface $pattern = null): RouteCreate
    {
        $pattern = is_null($pattern) ? new DefaultPattern() : $pattern;
        $this->routeCreate->setPattern($pattern);
        return $this->routeCreate;
    }

    public function showRoutes(): void
    {

    }

    public function save(): void
    {
        $this->container->toClean();
    }
}