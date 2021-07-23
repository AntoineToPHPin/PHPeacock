# Entities persistence

Persistence is the storage of data in the form of objects, here called entities.

## Implementation

The implementation may be as follow.

### In `public/bootstrap.php`

```php
// declare…
// use…
// Autoloader…

$config = require_once '../config/config.php';

$database = new Database(
    host: $config['database']['host'],
    name: $config['database']['name'],
    user: $config['database']['user'],
    password: $config['database']['password'],
);

$mySQLConnection = new MySQLConnection(database: $database);

// Some code…

```

### In `src/domains/mydomain/Example.php`

```php
<?php
namespace MyApp\Domains\Mydomain;

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
     * @param DBMSConnection|null $dbmsConnection Database management system connection.
     * @param int|null            $id             Example ID.
     * @param string              $field1         Example field1.
     * @param string              $field2         Example field2.
     */
    public function __construct(
        ?DBMSConnection $dbmsConnection = null,
        ?int $id = null,
        protected string $field1,
        protected string $field2,
    )
    {
        $this->id = $id;
        $this->dbmsConnection = $dbmsConnection;
    }

    /**
     * {@inheritDoc}
     */
    public function insert(): void
    {
        $query = (new InsertQuery)
            ->insert(table: 'example')
            ->values(field: 'field1', value: ':field1')
            ->values(field: 'field2', value: ':field2')
            ->addParameter(name: 'field1', value: $this->getField1())
            ->addParameter(name: 'field2', value: $this->getField2())
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

    // Getters and setters…
}

```

### In `src/domains/mydomain/ExampleCollection.php`

```php
<?php
namespace MyApp\Domains\Mydomain;

use PHPeacock\Framework\Persistence\Entities\EntityCollection;

/**
 * Collection of examples.
 */
class ExampleCollection extends EntityCollection
{
    /**
     * @param Example $examples,... Examples to add.
     */
    public function __construct(Example ...$examples)
    {
        parent::__construct(...$examples);
    }

    /**
     * Adds the example to the collection.
     * 
     * @param Example $example Example to add.
     * 
     * @return self
     */
    public function attach(Example $example): self
    {
        $this->elements->attach(object: $example);
        return $this;
    }

    /**
     * Removes the example from the collection.
     * 
     * @param Example $example Example to remove.
     * 
     * @return self
     */
    public function detach(Example $example): self
    {
        $this->elements->detach(object: $example);
        return $this;
    }
}

```

### In `src/domains/mydomain/ExampleCollection.php`

```php
<?php
namespace MyApp\Domains\Mydomain;

use PHPeacock\Framework\Persistence\Entities\EntityCollection;

/**
 * Collection of examples.
 */
class ExampleCollection extends EntityCollection
{
    /**
     * @param Example $examples,... Examples to add.
     */
    public function __construct(Example ...$examples)
    {
        parent::__construct(...$examples);
    }

    /**
     * Adds the example to the collection.
     * 
     * @param Example $example Example to add.
     * 
     * @return self
     */
    public function attach(Example $example): self
    {
        $this->elements->attach(object: $example);
        return $this;
    }

    /**
     * Removes the example from the collection.
     * 
     * @param Example $example Example to remove.
     * 
     * @return self
     */
    public function detach(Example $example): self
    {
        $this->elements->detach(object: $example);
        return $this;
    }
}

```

### In `src/domains/mydomain/SelectExample.php`

```php
<?php
namespace MyApp\Domains\Mydomain;

use PHPeacock\Framework\Persistence\Connections\DBMSConnection;
use PHPeacock\Framework\Persistence\Entities\SelectEntity;
use PHPeacock\Framework\Persistence\Queries\SelectQuery;

class SelectExample extends SelectEntity
{
    /**
     * @param DBMSConnection $dbmsConnection Database management system connection.
     */
    public function __construct(DBMSConnection $dbmsConnection)
    {
        $this->dbmsConnection = $dbmsConnection;
    }

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

        $example = $this->getDBMSConnection()
            ->prepare(query: (string) $query)
            ->execute(parameters: $query->getParameters())
            ->fetchOne()
        ;

        return new Example(
            dbmsConnection: $this->getDBMSConnection(),
            id: $example['id'],
            field1: $example['field1'],
            field2: $example['field2']
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

        $examples = $this->getDBMSConnection()
            ->prepare(query: (string) $query)
            ->execute()
            ->fetchAll()
        ;

        $exampleCollection = new ExampleCollection();
        foreach ($examples as $example)
        {
            $exampleCollection->attach(new Example(
                dbmsConnection: $this->getDBMSConnection(),
                id: $example['id'],
                field1: $example['field1'],
                field2: $example['field2']
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
            ->orderBy(field: 'id', order: 'ASC')
            ->limit(length: $length, offset: $offset)
        ;

        $examples = $this->getDBMSConnection()
            ->prepare(query: (string) $query)
            ->execute()
            ->fetchAll()
        ;

        $exampleCollection = new ExampleCollection();
        foreach ($examples as $example)
        {
            $exampleCollection->attach(new Example(
                dbmsConnection: $this->getDBMSConnection(),
                id: $example['id'],
                field1: $example['field1'],
                field2: $example['field2']
            ));
        }

        return $exampleCollection;
    }
}

```

## Class diagrams

### Database connections

![Database connections UML class diagram](uml/connections.svg)

### SQL queries

![SQL queries UML class diagram](uml/queries.svg)

### Entities

![Entities UML class diagram](uml/entities.svg)
