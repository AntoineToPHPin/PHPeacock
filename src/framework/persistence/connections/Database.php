<?php
namespace PHPeacock\Framework\Persistence\Connections;

/**
 * Database.
 */
class Database
{
    /**
     * Database host.
     * @var string $host
     */

    /**
     * Database name.
     * @var string $name
     */
    
    /**
     * Database user.
     * @var string $user
     */
    
    /**
     * Database password.
     * @var string $password
     */

    /**
     * @param string $host     Database host.
     * @param string $name     Database name.
     * @param string $user     Database user.
     * @param string $password Database password.
     */
    public function __construct(
        protected string $host,
        protected string $name,
        protected string $user,
        protected string $password,
    )
    { }

    /**
     * Returns the database name.
     * 
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns the database host.
     * 
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * Returns the database user.
     * 
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * Returns the database password.
     * 
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
