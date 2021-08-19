<?php

declare(strict_types=1);

use PHPeacock\Autoloader;
use PHPeacock\Framework\HTTP\HTTPRequest;
use PHPeacock\Framework\Persistence\Connections\Database;
use PHPeacock\Framework\Persistence\Connections\MySQLConnection;
use PHPeacock\Framework\Routing\Route;
use PHPeacock\Framework\Routing\RouteCollection;
use PHPeacock\Framework\Routing\Router;

require_once '../src/Autoloader.php';
(new Autoloader)->register();

$config = require_once '../config/config.php';

$database = new Database(
    host: $config['database']['host'],
    name: $config['database']['name'],
    user: $config['database']['user'],
    password: $config['database']['password'],
);

$dbmsConnection = new MySQLConnection(database: $database); // Or any other DBMSConnection child

$httpRequest = new HTTPRequest();

$routeCollection = new RouteCollection(
    // Some routes…
);

$router = new Router(routeCollection: $routeCollection, httpRequest: $httpRequest);
$controller = $router->getController();
$controller->render();
