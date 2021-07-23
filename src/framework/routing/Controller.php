<?php
namespace PHPeacock\Framework\Routing;

use PHPeacock\Framework\Persistence\Connections\DBMSConnection;

/**
 * Abstract controller which creates and triggers an action.
 */
abstract class Controller
{
    /**
     * Related database management system connection.
     * @var DBMSConnection $dbmsConnection
     */

    /**
     * Action class name.
     * @var string $action
     */

    /**
     * Action parameters.
     * @var string $actionParameters
     */

    /**
     * @param DBMSConnection $dbmsConnection   Related database management system connection.
     * @param string         $action           Action class name.
     * @param array          $actionParameters Action parameters.
     */
    public function __construct(
        protected DBMSConnection $dbmsConnection,
        protected string $action,
        protected array $actionParameters = [],
    )
    { }

    /**
     * Creates an action object and triggers it.
     * 
     * @return void
     */
    abstract public function render(): void;

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
     * Returns the action property.
     * 
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * Returns the actionParameters property.
     * 
     * @return array
     */
    public function getActionParameters(): array
    {
        return $this->actionParameters;
    }

    /**
     * Sets the actionParameters property.
     * 
     * @param DBMSConnection $actionParameters Action parameters.
     * 
     * @return void
     */
    public function setActionParameters(array $actionParameters): void
    {
        $this->actionParameters = $actionParameters;
    }
}
