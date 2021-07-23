<?php
namespace PHPeacock\Framework\Persistence\Connections;

use \PDO;

/**
 * MySQL connection with PDO.
 */
class MySQLConnection extends ConnectionWithPDO
{
    /**
     * @param Database $database Related database.
     */
    public function __construct(protected Database $database)
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
            ),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function prepare(string $query): self
    {
        $this->pdoStatement = $this->pdo->prepare(query: $query);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(?array $parameters = null): self
    {
        if (isset($parameters))
        {
            foreach ($parameters as $parameter => $value)
            {
                $type = PDO::PARAM_STR;
                if (is_int($value))
                {
                    $type = PDO::PARAM_INT;
                }
                $this->pdoStatement->bindValue(param: $parameter, value: $value, type: $type);
            }
        }
        $this->pdoStatement->execute();

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function fetchAll(): array
    {
        return $this->pdoStatement->fetchAll();
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
        return $this->pdo->lastInsertId();
    }

    /**
     * {@inheritDoc}
     */
    public function getAffectedRows(): int
    {
        return $this->pdoStatement->rowCount();
    }
}
