<?php

namespace Jefferson\Router\Classes\Main;

class Container
{
    private mixed $container;

    public function __construct($container = [])
    {
        $this->container = $container;
    }

    /**
     * @param mixed $container
     */
    public function setContainer(mixed $container): void
    {
        $this->container[] = $container;
    }

    /**
     * @return mixed
     */
    public function getContainer(): mixed
    {
        return $this->container;
    }

    public function toClean()
    {
        $this->container = [];
    }


}