<?php
namespace PHPeacock\Framework\Persistence\Entities;

use PHPeacock\Framework\Persistence\Connections\DBMSConnection;

/**
 * Abstract object which can be store in database.
 */
abstract class Entity implements InsertEntity, UpdateEntity, DeleteEntity
{

    /**
     * Related database management system connection.
     * @var DBMSConnection|null $dbmsConnection
     */
    protected ?DBMSConnection $dbmsConnection;

    /**
     * Unique id for database storage.
     * @var int|null $id
     */
    protected ?int $id;

    /**
     * Returns the id.
     * 
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Sets the id property.
     * 
     * @param int $id Entity id.
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns the DBMS connection.
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
     * @return void
     */
    public function setDBMSConnection(DBMSConnection $dbmsConnection): void
    {
        $this->dbmsConnection = $dbmsConnection;
    }
}
