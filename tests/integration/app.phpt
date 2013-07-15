--TEST--
Testa as configurações utilizadas pelo Respect/Config.
--FILE--
<?php
$container = require __DIR__.'/../../public/bootstrap.php';

var_dump($container->db instanceof Pdo);
var_dump($container->data instanceof Ophportunidades\DataAccess\PDODataAccess);
var_dump($container->app instanceof Ophportunidades\Ophportunidades);
var_dump($container->router instanceof Respect\Rest\Router);
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)