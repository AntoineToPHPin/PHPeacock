<?php
namespace PHPeacock\Framework\Persistence\Connections;

use \PDO;
use \PDOStatement;
use \PDOException;
use PHPeacock\Framework\Exceptions\Persistence\Connections\AffectedRowsException;
use PHPeacock\Framework\Exceptions\Persistence\Connections\BindParameterException;
use PHPeacock\Framework\Exceptions\Persistence\Connections\CommitException;
use PHPeacock\Framework\Exceptions\Persistence\Connections\ExecuteQueryException;
use PHPeacock\Framework\Exceptions\Persistence\Connections\InsertedIdException;
use PHPeacock\Framework\Exceptions\Persistence\Connections\NoResultsException;
use PHPeacock\Framework\Exceptions\Persistence\Connections\PrepareQueryException;
use PHPeacock\Framework\Exceptions\Persistence\Connections\RollbackException;
use PHPeacock\Framework\Exceptions\Persistence\Connections\TransactionException;

/**
 * Abstract database management system connection with PDO.
 */
abstract class ConnectionWithPDO extends DBMSConnection
{
    /**
     * PDO connection.
     * @var PDO $pdo
     */
    protected PDO $pdo;

    /**
     * PDO statement.
     * @var PDOStatement $pdoStatement
     */
    protected PDOStatement $pdoStatement;

    /**
     * Returns the PDO connection.
     * 
     * @return PDO
     */
    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    /**
     * {@inheritDoc}
     */
    public function prepare(string $query): self
    {
        try
        {
            $this->pdoStatement = $this->pdo->prepare(query: $query);
        }
        catch (PDOException $exception)
        {
            throw new PrepareQueryException(
                message: 'An error occurs when preparing a query.',
                previous: $exception
            );
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(?array $parameters = null): self
    {
        if (!isset($this->pdoStatement))
        {
            throw new PrepareQueryException(message: 'The query was not prepared.');
        }

        if (isset($parameters))
        {
            foreach ($parameters as $parameter => $value)
            {
                $type = PDO::PARAM_STR;
                if (is_int($value))
                {
                    $type = PDO::PARAM_INT;
                }

                try
                {
                    $this->pdoStatement->bindValue(param: $parameter, value: $value , type: $type);
                }
                catch (PDOException $exception)
                {
                    throw new BindParameterException(
                        message: 'An error occurs when binding a parameter.',
                        previous: $exception
                    );
                }
            }
        }

        try
        {
            $this->pdoStatement->execute();
        }
        catch (PDOException $exception)
        {
            throw new ExecuteQueryException(
                message: 'An error occurs when executing a query.',
                previous: $exception
            );
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function fetchAll(): array
    {
        $all = $this->pdoStatement->fetchAll();
        if (empty($all))
        {
            throw new NoResultsException(message: 'No results are returned.');
        }
        return $all;
    }

    /**
     * {@inheritDoc}
     */
    public function fetchOne(): array
    {
        return $this->fetchAll()[0];
    }

    /**
     * {@inheritDoc}
     */
    public function getInsertedId(): int
    {
        try
        {
            $lastInsertId = $this->pdo->lastInsertId();
            if ($lastInsertId === 0)
            {
                throw new InsertedIdException(message: 'The returned ID is zero.');
            }
            return $lastInsertId;
        }
        catch (PDOException $exception)
        {
            throw new InsertedIdException(
                message: 'An error occurs when fetching the inserted ID.',
                previous: $exception
            );
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getAffectedRows(): int
    {
        try
        {
            return $this->pdoStatement->rowCount();
        }
        catch (PDOException $exception)
        {
            throw new AffectedRowsException(
                message: 'An error occurs when fetching the number of rows affected.',
                previous: $exception
            );
        }
    }

    /**
     * {@inheritDoc}
     */
    public function beginTransaction(): void
    {
        try
        {
            $this->pdo->beginTransaction();
        }
        catch (PDOException $exception)
        {
            throw new TransactionException(
                message: 'An error occurs when beginning a transaction.',
                previous: $exception
            );
        }
    }

    /**
     * {@inheritDoc}
     */
    public function commit(): void
    {
        try
        {
            $this->pdo->commit();
        }
        catch (PDOException $exception)
        {
            throw new CommitException(
                message: 'An error occurs when commiting changes.',
                previous: $exception
            );
        }
    }

    /**
     * {@inheritDoc}
     */
    public function rollback(): void
    {
        try
        {
            $this->pdo->rollback();
        }
        catch (PDOException $exception)
        {
            throw new RollbackException(
                message: 'An error occurs when rolling back changes.',
                previous: $exception
            );
        }
    }
}
