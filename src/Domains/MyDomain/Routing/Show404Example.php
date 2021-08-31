<?php
namespace MyApp\Domains\MyDomain\Routing;

use PHPeacock\Framework\HTTP\HTTPRequest;
use PHPeacock\Framework\Persistence\Connections\DBMSConnection;

/**
 * “Show404Example” action.
 */
class Show404Example extends ExampleAction
{
    public function __construct(
        DBMSConnection $dbmsConnection,
        HTTPRequest $httpRequest,
        protected string $test = '',
    )
    {
        parent::__construct($dbmsConnection, $httpRequest, $test);
    }

    /**
     * {@inheritDoc}
     */
    public function execute(): void
    {
        echo 'Erreur 404: ' . $this->test;
    }
}
