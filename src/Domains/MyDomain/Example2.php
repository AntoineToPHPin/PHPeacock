<?php
namespace MyApp\Domains\MyDomain;

use PHPeacock\Framework\Persistence\Connections\DBMSConnection;
use PHPeacock\Framework\Persistence\Entities\Entity;
use PHPeacock\Framework\Persistence\Queries\DeleteQuery;
use PHPeacock\Framework\Persistence\Queries\InsertQuery;
use PHPeacock\Framework\Persistence\Queries\UpdateQuery;

/**
 * Example2
 */
class Example2 extends Entity
{
    /**
     * @param DBMSConnection|null $dbmsConnection Database management system connection.
     * @param int|null            $id             Example2 ID.
     * @param string              $field1         Example2 field1.
     * @param Example             $example        Example2 example.
     */
    public function __construct(
        protected ?DBMSConnection $dbmsConnection = null,
        protected ?int $id = null,
        protected string $field1,
        protected Example $example,
    )
    { }

    /**
     * {@inheritDoc}
     */
    public function insert(): void
    {
        $query = (new InsertQuery)
            ->insert(table: 'example2')
            ->values(field: 'field1', value: ':field1')
            ->values(field: 'id_example', value: ':exampleId')
            ->addParameter(name: 'field1', value: $this->getField1())
            ->addParameter(name: 'exampleId', value: $this->getExample()->getId())
        ;

        $insertedId = $this->dbmsConnection
            ->prepare(query: (string) $query)
            ->execute($query->getParameters())
            ->getInsertedId()
        ;

        $this->id = $insertedId;
    }

    /**
     * {@inheritDoc}
     */
    public function update(): void
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

        $this->getDBMSConnection()
            ->prepare(query: (string) $query)
            ->execute(parameters: $query->getParameters())
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function delete(): void
    {
        $query = (new DeleteQuery)
            ->delete(table: 'example')
            ->where(condition: 'id = :id')
            ->addParameter(name: 'id', value: $this->getId())
        ;

        $this->getDBMSConnection()
            ->prepare(query: (string) $query)
            ->execute(parameters: $query->getParameters())
        ;
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
     * Returns the example property.
     * 
     * @return Example
     */
    public function getExample(): Example
    {
        return $this->example;
    }

    /**
     * Sets the example property.
     * 
     * @param int $example Example2 example.
     * 
     * @return void
     */
    public function setExample(Example $example): void
    {
        $this->example = $example;
    }
}
