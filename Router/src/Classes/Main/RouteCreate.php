<?php

namespace Jefferson\Router\Classes\Main;

use Jefferson\Router\Classes\Errors\RouterParserException;
use Jefferson\Router\Classes\Interfaces\RouteCreateInterface;
use Jefferson\Router\Classes\Interfaces\RoutePatternInterface;

final class RouteCreate implements RouteCreateInterface
{

    private RoutePatternInterface $pattern;

    private Container $container;
    public function __construct(RoutePatternInterface $pattern, Container $container)
    {
        $this->pattern = new $pattern();
        $this->container = $container;
    }

    /**
     * @throws RouterParserException
     */
    private function create(string $httpMethod, string $pattern, mixed $handler): void
    {
        $handler = is_string($handler)? str_replace(" ","",$handler) : $handler;
        $pattern = str_replace(" ","",$pattern);

        $convertPattern = $this->convertPattern($pattern);
        $convertHandler = $this->convertHandler($handler);
        $convertMethod  = $this->convertMethod($httpMethod);

        $fullCheck = empty($convertPattern && $convertHandler && $convertMethod);

        if (!$fullCheck){
            $method = $convertMethod;
            $path = $convertPattern['path'];
            $parameters = $convertPattern['parameters'];
            $controller = $convertHandler['controller'];
            $action = $convertHandler['action'];
            $route =  new Route($method,$path,$controller,$action,$parameters);
            $this->container->setContainer($route);
        }

        if (empty($convertPattern)){
            throw new RouterParserException('the pattern does not match','2');
        }

        if (empty($convertHandler)){
            throw new RouterParserException('handler pattern does not match','3');
        }
        if (empty($convertMethod)){
            throw new RouterParserException('method pattern does not match','4');
        }

    }

    /**
     * @throws RouterParserException
     */
    public function get(string $pattern, mixed $handler)
    {
        self::create('GET',$pattern,$handler);
    }

    /**
     * @throws RouterParserException
     */
    public function post(string $pattern, mixed $handler)
    {
        self::create('POST',$pattern,$handler);
    }

    private function convertMethod($methodSubject): string
    {

        $method = '';
        if ($this->checkPattern($this->pattern->methodPattern(),$methodSubject)){
            $method = strtolower($methodSubject);

        }
        return $method;
    }


    /**
     * @param $pattern
     * @return array
     */
    private function convertPattern($pattern): array
    {
        $route = [];
        $patternRoute = $this->pattern->routePattern();
        $patternParameters = $this->pattern->parametersPattern();
        $patternPathNoParameters = $this->pattern->pathPattern();
        $checkPattern = $this->checkPattern($patternRoute, $pattern);

        if ($checkPattern){
            $parameters = preg_replace($patternPathNoParameters,'',$pattern);
            $path = preg_replace($patternParameters,'',$pattern);
            preg_match_all($this->pattern->parameters(),$parameters,$matches);
            $route = ['path'=> $path, "parameters" => $matches[0]];
        }
      return $route;
    }

    /**
     * @param $handler
     * @return array|callable[]
     */
    private function convertHandler($handler): array
    {
        $action = [];

        if (!is_callable($handler)){
            $checkHandler = self::checkPattern($this->pattern->handlePattern(),$handler);
            if ($checkHandler){
                $handlerExplode =  explode("@", $handler);
                $action = ['controller'=> $handlerExplode[0],'action'=> $handlerExplode[1]];
            }
        }
        if (is_callable($handler)){
            $action = ['action'=> $handler];
        }

        return $action;
    }

    private function checkPattern($pattern, $source): bool
    {
       return preg_match($pattern,$source);
    }
}