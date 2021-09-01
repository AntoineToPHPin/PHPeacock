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
     * Prepares a query.
     * 
     * @param string $query Query to prepare.
     * 
     * @throws PrepareQueryException if an error occurs when preparing a query.
     * 
     * @return self
     */
    abstract public function prepare(string $query): self;

    /**
     * Executes a query, with parameters, if needed.
     * 
     * @param array|null $parameters Parameters to add to the query execution.
     * 
     * @throws PrepareQueryException  if the query was not prepared before executing it.
     * @throws BindParameterException if an error occurs when binding a parameter.
     * @throws ExecuteQueryException  if an error occurs when executing a query.
     * 
     * @return self
     */
    abstract public function execute(?array $parameters = null): self;

    /**
     * Fetches results.
     * 
     * @throws NoResultsException if no results are returned.
     * 
     * @return array
     */
    abstract public function fetchAll(): array;

    /**
     * Fetches one result.
     * 
     * @throws NoResultsException if no results are returned.
     * 
     * @return array
     */
    abstract public function fetchOne(): array;

    /**
     * Returns the last inserted ID.
     * 
     * @throws InsertedIdException if an error occurs when fetching the inserted ID.
     * 
     * @return int
     */
    abstract public function getInsertedId(): int;

    /**
     * Returns the number of affected rows.
     * 
     * @throws AffectedRowsException if an error occurs when fetching the number of affected rows.
     * 
     * @return int
     */
    abstract public function getAffectedRows(): int;

    /**
     * Begins a transaction by turning off the autocommit mode.
     * 
     * @throws TransactionException if an error occurs when beginning a transaction.
     * 
     * @return void
     */
    abstract public function beginTransaction(): void;

    /**
     * Commits the transaction and turns on the autocommit mode.
     * 
     * @throws CommitException if an error occurs when commiting changes.
     * 
     * @return void
     */
    abstract public function commit(): void;

    /**
     * Rolls back the transaction and turns on the autocommit mode.
     * 
     * @throws RollbackException if an error occurs when rolling back changes.
     * 
     * @return void
     */
    abstract public function rollback(): void;
}
