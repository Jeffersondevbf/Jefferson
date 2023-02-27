

<?php
require '../vendor/autoload.php';

use Jefferson\Router\Classes\Errors\RouterParserException;
use Jefferson\Router\Classes\Main\Router;

$router = new Router();
$create = $router->startCreating();

try {
    $create->get('/32', 'Home@view');
} catch (RouterParserException $e) {
    echo $e->getMessage();
}

$router->save();
$router->showRoutes();
