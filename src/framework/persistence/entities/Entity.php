<?php
namespace PHPeacock\Framework\Persistence\Entities;

use PHPeacock\Framework\Persistence\Connections\DBMSConnection;

/**
 * Abstract object which can be store in database.
 */
abstract class Entity implements InsertEntity, UpdateEntity, DeleteEntity
{
    protected ?DBMSConnection $dbmsConnection;

    protected ?int $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getDBMSConnection(): DBMSConnection
    {
        return $this->dbmsConnection;
    }

    public function setDBMSConnection(DBMSConnection $dbmsConnection): void
    {
        $this->dbmsConnection = $dbmsConnection;
    }
}
