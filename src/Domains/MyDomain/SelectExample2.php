<?php
namespace MyApp\Domains\MyDomain;

use PHPeacock\Framework\Persistence\Connections\DBMSConnection;
use PHPeacock\Framework\Persistence\Entities\SelectEntity;
use PHPeacock\Framework\Persistence\Queries\SelectQuery;

class SelectExample2 extends SelectEntity
{
    /**
     * @param DBMSConnection $dbmsConnection Database management system connection.
     */
    public function __construct(protected DBMSConnection $dbmsConnection)
    { }

    /**
     * {@inheritDoc}
     */
    public function selectById(int $id): Example2
    {
        $query = (new SelectQuery)
            ->select(field: 'example2.id', alias: 'example2_id')
            ->select(field: 'example2.field1', alias: 'example2_field1')
            ->select(field: 'example.id', alias: 'example_id')
            ->select(field: 'example.field1', alias: 'example_field1')
            ->select(field: 'example.field2', alias: 'example_field2')
            ->from(table: 'example2')
            ->join(type: 'inner', table: 'example', condition: 'example2.id_example = example.id')
            ->where(condition: 'example2.id = :id')
            ->addParameter(name: 'id', value: $id)
        ;

        $example2 = $this->getDBMSConnection()
            ->prepare(query: $query)
            ->execute(parameters: $query->getParameters())
            ->fetchOne()
        ;

        return new Example2(
            dbmsConnection: $this->getDBMSConnection(),
            id: $example2['example2_id'],
            field1: $example2['example2_field1'],
            example: new Example(
                dbmsConnection: $this->getDBMSConnection(),
                id: $example2['example_id'],
                field1: $example2['example_field1'],
                field2: $example2['example_field2'],
            ),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function selectAll(): Example2Collection
    {
        $query = (new SelectQuery)
            ->select(field: 'example2.id', alias: 'example2_id')
            ->select(field: 'example2.field1', alias: 'example2_field1')
            ->select(field: 'example.id', alias: 'example_id')
            ->select(field: 'example.field1', alias: 'example_field1')
            ->select(field: 'example.field2', alias: 'example_field2')
            ->from(table: 'example2')
            ->join(type: 'inner', table: 'example', condition: 'example2.id_example = example.id')
            ->orderBy(field: 'example2.id', order: 'ASC')
        ;

        $example2s = $this->getDBMSConnection()
            ->prepare(query: $query)
            ->execute()
            ->fetchAll()
        ;

        $example2Collection = new Example2Collection();
        foreach ($example2s as $example2)
        {
            $example2Collection->attach(new Example2(
                dbmsConnection: $this->getDBMSConnection(),
                id: $example2['example2_id'],
                field1: $example2['example2_field1'],
                example: new Example(
                    dbmsConnection: $this->getDBMSConnection(),
                    id: $example2['example_id'],
                    field1: $example2['example_field1'],
                    field2: $example2['example_field2'],
                ),
            ));
        }

        return $example2Collection;
    }

    /**
     * {@inheritDoc}
     */
    public function selectWithLimit(int $length, ?int $offset = null): Example2Collection
    {
        $query = (new SelectQuery)
            ->select(field: 'example2.id', alias: 'example2_id')
            ->select(field: 'example2.field1', alias: 'example2_field1')
            ->select(field: 'example.id', alias: 'example_id')
            ->select(field: 'example.field1', alias: 'example_field1')
            ->select(field: 'example.field2', alias: 'example_field2')
            ->from(table: 'example2')
            ->join(type: 'inner', table: 'example', condition: 'example2.id_example = example.id')
            ->orderBy(field: 'example2.id', order: 'ASC')
            ->limit(length: $length, offset: $offset)
        ;

        $example2s = $this->getDBMSConnection()
            ->prepare(query: $query)
            ->execute()
            ->fetchAll()
        ;

        $example2Collection = new Example2Collection();
        foreach ($example2s as $example2)
        {
            $example2Collection->attach(new Example2(
                dbmsConnection: $this->getDBMSConnection(),
                id: $example2['example2_id'],
                field1: $example2['example2_field1'],
                example: new Example(
                    dbmsConnection: $this->getDBMSConnection(),
                    id: $example2['example_id'],
                    field1: $example2['example_field1'],
                    field2: $example2['example_field2'],
                ),
            ));
        }

        return $example2Collection;
    }
}
