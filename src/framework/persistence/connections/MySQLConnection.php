<?php
namespace PHPeacock\Framework\Persistence\Connections;

use \PDO;
use \PDOException;
use PHPeacock\Framework\Exceptions\Persistence\Connections\ConnectionException;

/**
 * MySQL connection with PDO.
 */
class MySQLConnection extends ConnectionWithPDO
{
    /**
     * @param Database $database Related database.
     * 
     * @throws ConnectionException if the connection to the database fails.
     */
    public function __construct(protected Database $database)
    {
        try
        {
            $this->pdo = new PDO(
                dsn:
                    'mysql:host=' . $this->database->getHost() . ';' .
                    'dbname=' . $this->database->getName() . ';' .
                    'charset=utf8mb4',
                username: $this->database->getUser(),
                password: $this->database->getPassword(),
                options: array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_PERSISTENT => false,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::MYSQL_ATTR_FOUND_ROWS => true,
                ),
            );
        }
        catch (PDOException $exception)
        {
            throw new ConnectionException(
                message: 'An error occurs when the connection to the datadase fails.',
                previous: $exception
            );
        }
    }
}
