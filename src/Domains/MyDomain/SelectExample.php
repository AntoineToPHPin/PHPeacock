<?php
namespace MyApp\Domains\MyDomain;

use PHPeacock\Framework\Exceptions\Persistence\Entities\SelectEntityException;
use PHPeacock\Framework\Exceptions\Persistence\PersistenceException;
use PHPeacock\Framework\Persistence\Connections\DBMSConnection;
use PHPeacock\Framework\Persistence\Entities\SelectEntity;
use PHPeacock\Framework\Persistence\Queries\SelectQuery;

class SelectExample extends SelectEntity
{
    /**
     * @param DBMSConnection $dbmsConnection Database management system connection.
     */
    public function __construct(protected DBMSConnection $dbmsConnection)
    { }

    /**
     * {@inheritDoc}
     */
    public function selectById(int $id): Example
    {
        $query = (new SelectQuery)
            ->select(field: 'id')
            ->select(field: 'field1')
            ->select(field: 'field2')
            ->from(table: 'example')
            ->where(condition: 'id = :id')
            ->addParameter(name: 'id', value: $id)
        ;

        try
        {
            $example = $this->getDBMSConnection()
                ->prepare(query: $query)
                ->execute(parameters: $query->getParameters())
                ->fetchOne()
            ;
        }
        catch (PersistenceException $exception)
        {
            throw new SelectEntityException(
                message: 'An error occurs when selecting an “Example”.',
                previous: $exception
            );
        }

        return new Example(
            dbmsConnection: $this->getDBMSConnection(),
            id: $example['id'],
            field1: $example['field1'],
            field2: $example['field2'],
        );
    }

    /**
     * {@inheritDoc}
     */
    public function selectAll(): ExampleCollection
    {
        $query = (new SelectQuery)
            ->select(field: 'id')
            ->select(field: 'field1')
            ->select(field: 'field2')
            ->from(table: 'example')
            ->orderBy(field: 'id', order: 'ASC')
        ;

        try
        {
            $examples = $this->getDBMSConnection()
                ->prepare(query: $query)
                ->execute()
                ->fetchAll()
            ;
        }
        catch (PersistenceException $exception)
        {
            throw new SelectEntityException(
                message: 'An error occurs when selecting all “Examples”.',
                previous: $exception
            );
        }

        $exampleCollection = new ExampleCollection();
        foreach ($examples as $example)
        {
            $exampleCollection->attach(new Example(
                dbmsConnection: $this->getDBMSConnection(),
                id: $example['id'],
                field1: $example['field1'],
                field2: $example['field2'],
            ));
        }

        return $exampleCollection;
    }

    /**
     * {@inheritDoc}
     */
    public function selectWithLimit(int $length, ?int $offset = null): ExampleCollection
    {
        $query = (new SelectQuery)
            ->select(field: 'id')
            ->select(field: 'field1')
            ->select(field: 'field2')
            ->from(table: 'example')
            ->orderBy(field: 'id')
            ->limit(length: $length, offset: $offset)
        ;

        try
        {
            $examples = $this->getDBMSConnection()
                ->prepare(query: $query)
                ->execute()
                ->fetchAll()
            ;
        }
        catch (PersistenceException $exception)
        {
            throw new SelectEntityException(
                message: 'An error occurs when selecting “Examples” with limit.',
                previous: $exception
            );
        }

        $exampleCollection = new ExampleCollection();
        foreach ($examples as $example)
        {
            $exampleCollection->attach(new Example(
                dbmsConnection: $this->getDBMSConnection(),
                id: $example['id'],
                field1: $example['field1'],
                field2: $example['field2'],
            ));
        }

        return $exampleCollection;
    }
}
