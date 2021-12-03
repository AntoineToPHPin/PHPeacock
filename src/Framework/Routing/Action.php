<?php
namespace PHPeacock\Framework\Routing;

use PHPeacock\Framework\HTTP\HTTPRequest;
use PHPeacock\Framework\HTTP\HTTPResponse;
use PHPeacock\Framework\Persistence\Connections\DBMSConnection;
use PHPeacock\Framework\Template\Template;

/**
 * Abstract action.
 */
abstract class Action
{
    /**
     * Related database management system connection.
     * @var DBMSConnection $dbmsConnection
     */

    /**
     * HTTP request.
     * @var HTTPRequest $httpRequest
     */

    /**
     * HTTP response.
     * @var HTTPResponse $httpResponse
     */

    /**
     * @param DBMSConnection $dbmsConnection Related DBMS connection.
     * @param HTTPRequest    $httpRequest    HTTP request.
     * @param HTTPResponse   $httpResponse   HTTP response.
     */
    public function __construct(
        protected DBMSConnection $dbmsConnection,
        protected HTTPRequest $httpRequest,
        protected HTTPResponse $httpResponse,
    )
    { }

    /**
     * Executes the action to render a web page.
     * 
     * @throws ExecuteActionException if an error occurs when the action was executed.
     * 
     * @return Template|null
     */
    abstract public function execute(): ?Template;

    /**
     * Returns the dbmsConnection property.
     * 
     * @return DBMSConnection
     */
    public function getDBMSConnection(): DBMSConnection
    {
        return $this->dbmsConnection;
    }

    /**
     * Sets the dbmsConnection property.
     * 
     * @param DBMSConnection $dbmsConnection Related DBMS connection.
     * 
     * @return void
     */
    public function setDBMSConnection(DBMSConnection $dbmsConnection): void
    {
        $this->dbmsConnection = $dbmsConnection;
    }

    /**
     * Returns the httpRequest property.
     * 
     * @return HTTPRequest
     */
    public function getHTTPRequest(): HTTPRequest
    {
        return $this->httpRequest;
    }

    /**
     * Sets the httpRequest property.
     * 
     * @param HTTPRequest $httpRequest HTTP request.
     * 
     * @return void
     */
    public function setHTTPRequest(HTTPRequest $httpRequest): void
    {
        $this->httpRequest = $httpRequest;
    }

    /**
     * Returns the httpResponse property.
     * 
     * @return HTTPResponse
     */
    public function getHTTPResponse(): HTTPResponse
    {
        return $this->httpResponse;
    }

    /**
     * Sets the httpResponse property.
     * 
     * @param HTTPResponse $httpResponse HTTP response.
     * 
     * @return void
     */
    public function setHTTPResponse(HTTPResponse $httpResponse): void
    {
        $this->httpResponse = $httpResponse;
    }
}
