<?php
namespace PHPeacock\Framework\Persistence\Connections;

/**
 * Abstract database management system connection with PDO.
 */
abstract class ConnectionWithPDO extends DBMSConnection
{
    /**
     * PDO connection.
     * @var \PDO $pdo
     */
    protected \PDO $pdo;

    /**
     * PDO statement.
     * @var \PDOStatement $pdoStatement
     */
    protected \PDOStatement $pdoStatement;

    /**
     * Returns the PDO connection.
     * 
     * @return \PDO
     */
    public function getPdo(): \PDO
    {
        return $this->pdo;
    }
}
