<?php

namespace Jefferson\Router\Support\Container;

class Container extends ContainerStorage
{
    public function create($name, $closed = true): int
    {
        return self::createNewContainer($name, $closed);
    }
}