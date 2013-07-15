<?php

define('DS', DIRECTORY_SEPARATOR);
define('APP_ROOT', realpath(__DIR__ . DS . '..'));
$composer_autoload = APP_ROOT . DS . 'vendor' . DS . 'autoload.php';
if (false === file_exists($composer_autoload)) {
    throw new RuntimeException('Please install composer dependencies.');
}

include $composer_autoload;
chdir(APP_ROOT);
return call_user_func(
    // Efetua o bootstrap da aplicação apartir de um container de dependências.
    function(Respect\Config\Container $config) {
        ini_set('display_errors', $config->display_errors);
        error_reporting($config->error_reporting);
        date_default_timezone_set($config->timezone);

        return $config;
    },
    // Retorna o container de dependências.
    call_user_func(function() {
        try {
            define('APP_ENV', filter_var(getenv('OPHPORTUNIDADES_ENV') ?: 'dev', FILTER_SANITIZE_STRING));
            define('APP_DB_DSN', filter_var(getenv('OPHPORTUNIDADES_DB_DSN') ?: 'sqlite::memory:', FILTER_SANITIZE_STRING));
            define('APP_DB_USER', filter_var(getenv('OPHPORTUNIDADES_DB_USER') ?: ':', FILTER_SANITIZE_STRING));
            define('APP_DB_PASS', filter_var(getenv('OPHPORTUNIDADES_DB_PASS') ?: ':', FILTER_SANITIZE_STRING));

            $filename = APP_ROOT.DS.'conf'.DS.'app.'.APP_ENV.'.ini';
            return new Respect\Config\Container($filename);
        } catch (Exception $e) {
            header('HTTP/1.1 500 Premature server error');
            throw new RuntimeException('Premature server error', __LINE__, $e);
        }
    })
)->application;