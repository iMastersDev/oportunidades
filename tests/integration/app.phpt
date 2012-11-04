--TEST--
Testa as configurações utilizadas pelo Respect/Config.
--FILE--
<?php
require __DIR__.'/../../public/bootstrap.php';

use Respect\Config\Container;

$ini       = APP_ROOT.'/conf/app.ini';
$container = new Container($ini);

var_dump($container->db instanceof Pdo);
var_dump($container->data instanceof Ophportunidades\DataAccess\PDODataAccess);
var_dump($container->app instanceof Ophportunidades\Ophportunidades);
var_dump($container->router instanceof Respect\Rest\Router);
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)