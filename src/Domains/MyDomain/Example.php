<?php
namespace MyApp\Domains\MyDomain;

use PHPeacock\Framework\Exceptions\Persistence\Entities\DeleteEntityException;
use PHPeacock\Framework\Exceptions\Persistence\Entities\InsertEntityException;
use PHPeacock\Framework\Exceptions\Persistence\Entities\UpdateEntityException;
use PHPeacock\Framework\Exceptions\Persistence\PersistenceException;
use PHPeacock\Framework\Persistence\Connections\DBMSConnection;
use PHPeacock\Framework\Persistence\Entities\Entity;
use PHPeacock\Framework\Persistence\Queries\DeleteQuery;
use PHPeacock\Framework\Persistence\Queries\InsertQuery;
use PHPeacock\Framework\Persistence\Queries\UpdateQuery;

/**
 * Example
 */
class Example extends Entity
{
    /**
     * @param DBMSConnection $dbmsConnection Database management system connection.
     * @param int|null       $id             Example ID.
     * @param string         $field1         Example field1.
     * @param string         $field2         Example field2.
     */
    public function __construct(
        protected DBMSConnection $dbmsConnection,
        protected ?int $id = null,
        protected string $field1,
        protected string $field2,
    )
    { }

    /**
     * {@inheritDoc}
     */
    public function insert(): int
    {
        $query = (new InsertQuery)
            ->insert(table: 'example')
            ->values(field: 'field1', value: ':field1')
            ->values(field: 'field2', value: ':field2')
            ->addParameter(name: 'field1', value: $this->getField1())
            ->addParameter(name: 'field2', value: $this->getField2())
        ;

        try
        {
            $insertedId = $this->dbmsConnection
                ->prepare(query: $query)
                ->execute($query->getParameters())
                ->getInsertedId()
            ;

            $this->id = $insertedId;

            return $this->dbmsConnection->getAffectedRows();
        }
        catch (PersistenceException $exception)
        {
            throw new InsertEntityException(
                message: 'An error occurs when inserting an “Example”.',
                previous: $exception
            );
        }
    }

    /**
     * {@inheritDoc}
     */
    public function update(): int
    {
        $query = (new UpdateQuery)
            ->update(table: 'example')
            ->set(field: 'field1', value: ':field1')
            ->set(field: 'field2', value: ':field2')
            ->where(condition: 'id = :id')
            ->addParameter(name: 'field1', value: $this->getField1())
            ->addParameter(name: 'field2', value: $this->getField2())
            ->addParameter(name: 'id', value: $this->getId())
        ;

        try
        {
            $this->getDBMSConnection()
                ->prepare(query: $query)
                ->execute(parameters: $query->getParameters())
            ;

            return $this->dbmsConnection->getAffectedRows();
        }
        catch (PersistenceException $exception)
        {
            throw new UpdateEntityException(
                message: 'An error occurs when updating an “Example”.',
                previous: $exception
            );
        }
    }

    /**
     * {@inheritDoc}
     */
    public function delete(): int
    {
        $query = (new DeleteQuery)
            ->delete(table: 'example')
            ->where(condition: 'id = :id')
            ->addParameter(name: 'id', value: $this->getId())
        ;

        try
        {
            $this->getDBMSConnection()
                ->prepare(query: $query)
                ->execute(parameters: $query->getParameters())
            ;

            return $this->dbmsConnection->getAffectedRows();
        }
        catch (PersistenceException $exception)
        {
            throw new DeleteEntityException(
                message: 'An error occurs when deleting an “Example”.',
                previous: $exception
            );
        }
    }

    /**
     * Returns the field1 property.
     * 
     * @return string
     */
    public function getField1(): string
    {
        return $this->field1;
    }

    /**
     * Sets the field1 property.
     * 
     * @param string $field1 Example field1.
     * 
     * @return void
     */
    public function setField1(string $field1): void
    {
        $this->field1 = $field1;
    }

    /**
     * Returns the field2 property.
     * 
     * @return string
     */
    public function getField2(): string
    {
        return $this->field2;
    }

    /**
     * Sets the field2 property.
     * 
     * @param int $field2 Example field2.
     * 
     * @return void
     */
    public function setField2(string $field2): void
    {
        $this->field2 = $field2;
    }
}
