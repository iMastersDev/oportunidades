--TEST--
Testa as configurações utilizadas pelo Respect/Config.
--FILE--
<?php
require 'public/bootstrap.php';

use Respect\Config\Container;

$ini       = APP_ROOT.'/conf/app.ini';
$container = new Container($ini);

var_dump($container->db instanceof Pdo);
--EXPECT--
bool(true)