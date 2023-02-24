<?php

namespace Jefferson\Router\Classes\Interfaces;

interface RoutePatternInterface
{

    public function parameters(): string;

    public function pathPattern(): string;

    public function parametersPattern(): string;

    public function methodPattern(): string;

    public function routePattern(): string;

    public function handlePattern(): string;
}