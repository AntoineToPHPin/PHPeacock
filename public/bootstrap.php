<?php

declare(strict_types=1);
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

use PHPeacock\Autoloader;
use PHPeacock\Framework\Exceptions\ErrorHandler;
use PHPeacock\Framework\Exceptions\ExceptionAndErrorHandler;
use PHPeacock\Framework\Exceptions\Persistence\Connections\NoResultsException;
use PHPeacock\Framework\Exceptions\Routing\ActionNotFoundException;
use PHPeacock\Framework\Exceptions\Routing\ExecuteActionException;
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

$httpRequest = new HTTPRequest();
$httpResponse = new HTTPResponse(
    baseURL: $config['url']['baseURL'],
    path404: $config['url']['404'],
    path500: $config['url']['500'],
);

(new ExceptionAndErrorHandler(httpResponse: $httpResponse))->register();
(new ErrorHandler(httpResponse: $httpResponse))->register();

$database = new Database(
    host: $config['database']['host'],
    name: $config['database']['name'],
    user: $config['database']['user'],
    password: $config['database']['password'],
);

$dbmsConnection = new MySQLConnection(database: $database); // Or any other DBMSConnection child

$routeCollection = new RouteCollection(
    // Some routes…
);

$router = new Router(routeCollection: $routeCollection, httpRequest: $httpRequest);
try
{
    $action = $router->getActionFromRoutes();
}
catch (ActionNotFoundException $exception)
{
    $httpResponse->redirect404();
}

try
{
    $template = $action->execute();
}
catch (ExecuteActionException $exception)
{
    $previousException = $exception->getPrevious();
    while ($previousException !== null)
    {
        if ($previousException instanceof NoResultsException)
        {
            $httpResponse->redirect404();
        }
        $previousException = $previousException->getPrevious();
    }

    throw $exception;
}

$template?->display();
