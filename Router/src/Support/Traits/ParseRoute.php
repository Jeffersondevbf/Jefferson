<?php

namespace Jefferson\Router\Support\Traits;

use Jefferson\Router\Classes\Errors\RouterParserException;

/**
 * @author Jefferson Silva Santos
 */
trait ParseRoute
{

    private string $full = '#^(/)$|^(/[A-z\d]+)+$|^(/[A-z\s]+)+(/{[A-z\d]+})+$|^(/{[A-z\d]+})+$#';

    private string $method = '#^get|post|put|delete$#';

    private string $handler = '#^(\w+)@(\w+)$#';

    private string $path = '#(/[A-z\d]+)+#';

    private string $parameter = '#(/{[A-z\d]+})+#';

    private string $value = '#[A-z\d]+#';

    /**
     * @param string $type wait as a parameter in the extract
     * ('route | method | handler | path | value) if handler is callable it will return a callable
     * @param callable|string $pattern
     * the pattern will be matched by the regular expression defined in the ParseRoute trait
     * @return bool|null
     * @throws RouterParserException
     */
    private function pattern(string $type, callable|string $pattern): ?bool
    {
        $pattern = is_string($pattern) ? self::clearEmptySpaces($pattern) : $pattern;
        $match = match (strtolower($type)){
            'route'     => preg_match($this->full, $pattern),
            'method'    => preg_match($this->method.'i', $pattern),
            'handler'   => is_callable($pattern) ? 1 : preg_match($this->handler, $pattern),
            'path'      => preg_match($this->path, $pattern),
            'parameter' => preg_match($this->parameter, $pattern),
            'value'     => preg_match($this->value, $pattern),
            default     => throw new RouterParserException(
                "Error: ($type) not accepted , expect it to be parameter route method handler value or path")
        };
        return match ($match){
            1 => $match,
            0 => throw new RouterParserException("Error: ($pattern) this pattern failed")
        };
    }

    /**
     * @param string $route the pattern will be matched by the regular expression defined in the ParseRoute trait
     * @param string $extract wait as parameter (path|parameter|route) , full is the default value
     * @return array|string|string[]|null
     * @throws RouterParserException
     */
    private function extract(string $route, string $extract = 'route'): array|string|null
    {
        if (!self::pattern('route',$route))
            throw new RouterParserException("Error: ($route) this pattern failed");
        preg_match_all($this->value,preg_replace($this->path,'', $route),$match);
        return match ($extract){
            'parameter' => $match[0],
            'path'      => preg_replace($this->parameter,'', $route),
            'route'     => ['path' => preg_replace($this->parameter,'', $route), 'parameter' => $match[0]],
             default    => throw new RouterParserException(
                 "Error: ($extract)not accepted, expect it to be parameter route method handler value or path")
        };
    }


    /**
     * @param string|callable $handler
     * @return array|callable
     * @throws RouterParserException
     */
    private function separateHandler(string|callable $handler): array|callable
    {
        $handler = is_string($handler) ? self::clearEmptySpaces($handler) : $handler;
        if (is_callable($handler)) return $handler;
        if (!self::pattern('handler',$handler))
            throw new RouterParserException('Error: the pattern for the handler failed');
        return explode('@', $handler);
    }

    /**\\
     * @param string $string
     * @return string without spaces
     */
    private function clearEmptySpaces(string $string): string
    {
        return str_replace(" ","",$string);
    }


}