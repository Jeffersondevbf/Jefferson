

<?php
require '../vendor/autoload.php';

use Jefferson\Router\Classes\Errors\RouterParserException;
use Jefferson\Router\Classes\Main\Router;
use Jefferson\Router\Support\Pattern\DefaultRoutePattern;

$router = new Router();
$create = $router->startCreating();

try {
    $create->get('/', 'Home@view');
} catch (RouterParserException $e) {
    echo $e->getMessage();
}

//var_dump(preg_match('#^(/)$|^((/[A-z\d\s]+)?(/{[A-z\d\s]+})?)*$#',''));