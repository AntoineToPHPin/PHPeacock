<?php
namespace PHPeacock\Framework\Persistence\Connections;

/**
 * Abstract database management system connection.
 */
abstract class DBMSConnection
{
    /**
     * Related database.
     * @var Database $database
     */
    protected Database $database;

    /**
     * @param Database $database Related database.
     */
    abstract public function __construct(Database $database);

    /**
     * Prepares a query.
     * 
     * @param string $query Query to prepare.
     * 
     * @return self
     */
    abstract public function prepare(string $query): self;

    /**
     * Executes a query, with parameters, if needed.
     * 
     * @param array|null $parameters Parameters to add at the query execution.
     * 
     * @return self
     */
    abstract public function execute(?array $parameters = null): self;

    /**
     * Fetches results.
     * 
     * @return array
     */
    abstract public function fetchAll(): array;

    
    /**
     * Fetches one result.
     * 
     * @return array
     */
    abstract public function fetchOne(): array;

    /**
     * Returns the last inserted ID.
     * 
     * @return int
     */
    abstract public function getInsertedId(): int;

    /**
     * Returns the number of rows affected.
     * 
     * @return int
     */
    abstract public function getAffectedRows(): int;
}
