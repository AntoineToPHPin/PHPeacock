<?php
namespace PHPeacock\Framework\Routing;

use PHPeacock\Framework\Persistence\Connections\DBMSConnection;

/**
 * Abstract action.
 */
abstract class Action
{
    /**
     * Related database management system connection.
     * @var DBMSConnection $dbmsConnection
     */
    protected DBMSConnection $dbmsConnection;

    /**
     * Executes the action to render a web page.
     * 
     * @return void
     */
    abstract public function execute(): void;

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
}
