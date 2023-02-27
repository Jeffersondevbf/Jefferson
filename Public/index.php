

<?php
require '../vendor/autoload.php';

//use Jefferson\Router\Classes\Errors\RouterParserException;
//use Jefferson\Router\Classes\Main\Router;
use Jefferson\Router\Support\Container\Container;

$container = new Container();
$container->create('jefferson');
$container->openContainer('jefferson');
$res = $container->addContent('jefferson', ["oi","ola","ate"]);
$res = $container->addContent('jefferson', ["ola","oi" , "oito","ok"]);

var_dump($res);
var_dump($container->catchOpenContainers());