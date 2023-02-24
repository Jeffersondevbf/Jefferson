

<?php
require '../Router/vendor/autoload.php';

use Jefferson\Router\Classes\Errors\RouterParserException;
use Jefferson\Router\Classes\Main\Router;
use Jefferson\Router\Support\Pattern\DefaultRoutePattern;

$router = new Router();
try {
    $create = $router->startCreating(new DefaultRoutePattern());
} catch (RouterParserException $e) {
    echo $e->getMessage();
    die();
}


try {
    $create->get('/product/{id}', 'Product@home');
} catch (RouterParserException $e) {
    echo $e->getMessage(); echo " code:".$e->getCode();
    die();

}
$router->save();
$router->run();