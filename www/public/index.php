<?php

use Core\Router\Router;

define('APP_PATH', dirname(__DIR__));

require_once APP_PATH . '/vendor/autoload.php';

$router = new Router();
$router->resolve();
