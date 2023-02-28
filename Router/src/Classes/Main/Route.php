<?php

namespace Jefferson\Router\Classes\Main;

readonly class Route
{
    private string $method;

    private string $path;

    private null|string $controller;

    private array $param;

    private mixed $action;

    /**
     * @param string $method
     * @param string $path
     * @param string|null $controller
     * @param array $param
     * @param string|callable $action
     */
    public function __construct
    (
        string $method,
        string $path,
        string|null $controller,
        string|callable $action,
        array $param
    )
    {
        $this->method = $method;
        $this->path = $path;
        $this->controller = $controller;
        $this->param = $param;
        $this->action = $action;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return mixed
     */
    public function getAction(): mixed
    {
        return $this->action;
    }

    /**
     * @return string|null
     */
    public function getController(): string|null
    {
        return $this->controller;
    }

    /**
     * @return array
     */
    public function getParam(): array
    {
        return $this->param;
    }
}