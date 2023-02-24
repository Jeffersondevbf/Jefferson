<?php

namespace Jefferson\Router\Support\Pattern;

use Jefferson\Router\Classes\Interfaces\RoutePatternInterface;

class DefaultRoutePattern implements RoutePatternInterface
{

    public function pathPattern(): string
    {
        return '#(/[A-z\d\s]+)*#';
    }
    public function parametersPattern(): string
    {
        return '#(/{[A-z\d\s]+})*#';
    }

    public function methodPattern(): string
    {
        return  "#^(GET)|(POST)|(PUT)|(DELETE)$#";
    }

    public function routePattern(): string
    {
       return '#^(/)$|^((/[A-z\d\s]+)?(/{[A-z\d\s]+})?)*$#';
    }

    public function handlePattern(): string
    {
        return "#^(\s+)?([\w]+)(\s+)?@(\s+)?([\w]+)(\s+)?$#";
    }

    public function parameters(): string
    {
        return '#[A-z\d]+#';
    }
}