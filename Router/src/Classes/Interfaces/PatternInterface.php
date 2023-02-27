<?php

namespace Jefferson\Router\Classes\Interfaces;

interface PatternInterface
{

    /**
     * @return string
     * it returns the syntax of the route pattern in this format:
     * regular expression => #(/[A-z\d]+)#
     * pattern => /route/sub...
     */
    public function pathPattern(): string;

    /**
     * @return string
     * it returns the syntax of the parameter pattern in this format:
     * regular expression => #(/{[A-z\d]+})+#
     * pattern => /{param1}/{param2}...
     */
    public function parametersPattern(): string;

    /**
     * @return string
     * it returns the syntax of the method pattern in this format:
     * regular expression => #^get|post|put|delete$#i
     * pattern => get post put delete
     */
    public function methodPattern(): string;
    /**
     * @return string
     * it returns the syntax of the full route pattern in this format:
     * regular expression => #^(/)$|^(/([\w\d]+))+/(\{[\w\d]+})+|(/(\{[\w\d]+})+)|(/([\w\d]+))+$#
     * pattern => /route/sub/{param1}/{param2}... , /{param} , /route/{param}...
     */
    public function fullRoutePattern(): string;

    /**
     * @return string
     * it returns the syntax of the handler pattern in this format:
     * regular expression => #^(\s+)?([\w]+)(\s+)?@(\s+)?([\w]+)(\s+)?$#
     * pattern => Controller @ Action
     */
    public function handlePattern(): string;

    /**
     * @return string
     * it returns the syntax of the parameter pattern in this format:
     * regular expression => #[A-z\d]+#
     * pattern => param1 , param2...
     */
    public function paramValuePattern(): string;


}