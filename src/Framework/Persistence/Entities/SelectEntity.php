<?php
namespace PHPeacock\Framework\Persistence\Entities;

use PHPeacock\Framework\Persistence\Connections\DBMSConnection;

/**
 * Abstract object which selects entities.
 */
abstract class SelectEntity
{
    /**
     * Related database management system connection.
     * @var DBMSConnection $dbmsConnection
     */
    protected DBMSConnection $dbmsConnection;

    /**
     * Selects an entity from the database by its ID.
     * 
     * @param int $id Entity ID.
     * 
     * @throws SelectEntityException if an error occurs when selecting an entity.
     * 
     * @return Entity
     */
    abstract public function selectById(int $id): Entity;

    /**
     * Selects all entities from the database.
     * 
     * @throws SelectEntityException if an error occurs when selecting all entities.
     * 
     * @return EntityCollection
     */
    abstract public function selectAll(): EntityCollection;

    /**
     * Selects limited entities from the database.
     * 
     * @param int      $length Limit length.
     * @param int|null $offset Limit offset.
     * 
     * @throws SelectEntityException if an error occurs when selecting entities with limit.
     * 
     * @return EntityCollection
     */
    abstract public function selectWithLimit(int $length, ?int $offset = null): EntityCollection;

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
