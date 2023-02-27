<?php

namespace Jefferson\Router\Support\Pattern;

use Jefferson\Router\Classes\Interfaces\PatternInterface;

readonly class DefaultPattern implements PatternInterface
{
    private array $patterns;

    private array $route;

    /**
     * @param string $escapeTag
     */
    public function __construct(string $escapeTag = '#')
    {

        $start = $escapeTag;
        $end   = $escapeTag;

        $this->patterns = [
            "route" => [
                "full-route"  => $start.'^(/)$|^(/[A-z\d]+)+$|^(/[A-z\s]+)+(/{[A-z\d]+})+$|^(/{[A-z\d]+})+$'.$end,
                "route"       => $start.'(/[A-z\d]+)+'.$end,
                "parameter"   => $start.'(/{[A-z\d]+})+'.$end,
                "param-value" => $start.'[A-z\d]+'.$end,
                "method"      => $start.'^get|post|put|delete$'.$end.'i',
                "handler"     => $start.'^(\s+)?([\w]+)(\s+)?@(\s+)?([\w]+)(\s+)?$'.$end
            ],
            "routes" => ""
        ];
        $this->route = $this->patterns['route'];
    }

    /**
     * @return string
     * it returns the syntax of the route pattern in this format:
     * regular expression => #(/[A-z\d]+)#
     * pattern => /route/sub...
     */
    public function pathPattern(): string
    {
        return $this->route['route'];
    }

    /**
     * @return string
     * it returns the syntax of the parameter pattern in this format:
     * regular expression => #(/{[A-z\d]+})+#
     * pattern => /{param1}/{param2}...
     */
    public function parametersPattern(): string
    {
        return $this->route['parameter'];
    }

    /**
     * @return string
     * it returns the syntax of the method pattern in this format:
     * regular expression => #^get|post|put|delete$#i
     * pattern => get post put delete
     */
    public function methodPattern(): string
    {
        return $this->route['method'];
    }

    /**
     * @return string
     * it returns the syntax of the full route pattern in this format:
     * regular expression => #^(/)$|^(/([\w\d]+))+/(\{[\w\d]+})+|(/(\{[\w\d]+})+)|(/([\w\d]+))+$#
     * pattern => /route/sub/{param1}/{param2}... , /{param} , /route/{param}...
     */
    public function fullRoutePattern(): string
    {
        return $this->route['full-route'];
    }

    /**
     * @return string
     * it returns the syntax of the handler pattern in this format:
     * regular expression => #^(\s+)?([\w]+)(\s+)?@(\s+)?([\w]+)(\s+)?$#
     * pattern => Controller @ Action
     */
    public function handlePattern(): string
    {
        return $this->route['handler'];
    }

    /**
     * @return string
     * it returns the syntax of the parameter pattern in this format:
     * regular expression => #[A-z\d]+#
     * pattern => param1 , param2...
     */
    public function paramValuePattern(): string
    {
        return $this->route['param-value'];
    }
}