<?php

declare(strict_types=1);
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

use PHPeacock\Autoloader;
use PHPeacock\Framework\HTTP\HTTPRequest;
use PHPeacock\Framework\HTTP\HTTPResponse;
use PHPeacock\Framework\Persistence\Connections\Database;
use PHPeacock\Framework\Persistence\Connections\MySQLConnection;
use PHPeacock\Framework\Routing\Parameter;
use PHPeacock\Framework\Routing\ParameterCollection;
use PHPeacock\Framework\Routing\RouteCollection;
use PHPeacock\Framework\Routing\Router;

require_once '../src/Autoloader.php';
(new Autoloader)->register();

$config = require_once '../config/config.php';

if ($config['debugMode'])
{
    ini_set(option: 'display_errors', value: 'On');
    ini_set(option: 'display_startup_errors', value: 'On');
    ini_set(option: 'error_reporting', value: '-1');
    ini_set(option: 'log_errors', value: 'On');
}
else
{
    ini_set(option: 'display_errors', value: 'Off');
    ini_set(option: 'display_startup_errors', value: 'Off');
    ini_set(option: 'error_reporting', value: '-1');
    ini_set(option: 'log_errors', value: 'On');
}

$database = new Database(
    host: $config['database']['host'],
    name: $config['database']['name'],
    user: $config['database']['user'],
    password: $config['database']['password'],
);

$dbmsConnection = new MySQLConnection(database: $database); // Or any other DBMSConnection child

$httpRequest = new HTTPRequest();
$httpResponse = new HTTPResponse(url: $config['url']);

$routeCollection = new RouteCollection(
    // Some routes…
);

$router = new Router(routeCollection: $routeCollection, httpRequest: $httpRequest);
$action = $router->getActionFromRoutes();
$template = $action->execute();
$template?->display();
