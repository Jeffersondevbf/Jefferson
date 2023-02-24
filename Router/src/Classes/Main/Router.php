<?php

namespace Jefferson\Router\Classes\Main;

use Jefferson\Router\Classes\Errors\RouterParserException;
use Jefferson\Router\Classes\Interfaces\RoutePatternInterface;
use Jefferson\Router\Support\Pattern\DefaultRoutePattern;

class Router
{

    private Container $container;

    public function __construct()
    {
        $this->container = new Container();
        $this->container->setContainer(["name"=>"one test"]);
    }

    /**
     * @param mixed|null $pattern
     * @return RouterParserException|RouteCreate
     * @throws RouterParserException
     */
    public function startCreating(mixed $pattern = null): RouterParserException|RouteCreate
    {

        if (is_string($pattern)){
            if (class_exists($pattern)){
                if (!empty(class_implements($pattern))){
                    $key     = key_exists(RoutePatternInterface::class,class_implements($pattern));
                    $pattern = $key ? new $pattern() : null;
                }
            }
        }

        $pattern = is_null($pattern) ? new DefaultRoutePattern() : $pattern;
        if (!$pattern instanceof RoutePatternInterface){
            throw new RouterParserException("routePattern must implement routePatternInterface",1);
        }
        return new RouteCreate($pattern, $this->container);
    }


    private function getContainer(): Container
    {
        return $this->container;
    }

    /**
     * @return Container
     */
    public function run(): Container
    {
        return $this->getContainer();
    }


    public function save(): void
    {
        $this->container->toClean();
    }
}