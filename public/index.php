<?php
require 'bootstrap.php';

use Respect\Config\Container;
use Respect\Validation\Validator;
use Respect\Rest\Router;

$container = new Container(APP_ROOT.'/conf/app.ini');
$router    = $container->router;

$router->get('/'         , 'Ophportunidades\Route\AllPositions', array($container->data));
$router->get('/positions', 'Ophportunidades\Route\AllPositions', array($container->data));

$router->get( '/position/*', 'Ophportunidades\Route\OnePosition', array($container->data, $container->app));
$router->post('/position'  , 'Ophportunidades\Route\OnePosition', array($container->data, $container->app));
$router->post('/positions' , 'Ophportunidades\Route\OnePosition', array($container->data, $container->app));