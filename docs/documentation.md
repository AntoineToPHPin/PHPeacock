# PHPeacock documentation

## Table of contents

1. [Directory structure](#directory-structure)
    1. [`bin` directory](#bin-directory)
    2. [`config` directory](#config-directory)
    3. [`docs` directory](#docs-directory)
    4. [`public` directory](#public-directory)
    5. [`resources` directory](#resources-directory)
    6. [`src` directory](#src-directory)
    7. [`tests` directory](#tests-directory)
2. [Autoloader](#autoloader)
    1. [Activation](#activation)
    2. [New classes autoloading](#new-classes-autoloading)
    3. [Class diagram](#class-diagram)
3. [Collections](#collections)
    1. [Precautions](#precautions)
    2. [Implementation](#implementation)
    3. [Class diagram](#class-diagram-1)
4. [Persistence](#persistence)
    1. [Implementation](#implementation-1)
        1. [In `public/bootstrap.php`](#in-publicbootstrapphp)
        2. [In `src/Domains/MyDomain/Example.php`](#in-srcdomainsmydomainexamplephp)
        3. [In `src/Domains/MyDomain/SelectExample.php`](#in-srcdomainsmydomainselectexamplephp)
    2. [Class diagrams](#class-diagrams)
        1. [Database connections](#database-connections)
        2. [SQL queries](#sql-queries)
        3. [Entities](#entities)
5. [URL routing](#url-routing)
    1. [Implementation](#implementation-2)
        1. [In `public/bootstrap.php`](#in-publicbootstrapphp-1)
        2. [In `src/Domains/MyDomain/Routing/ShowAllExamples.php`](#in-srcdomainsmydomainroutingshowallexamplesphp)
        3. [In `src/Domains/MyDomain/Routing/ShowExample.php`](#in-srcdomainsmydomainroutingshowexamplephp)
    2. [Class diagram](#class-diagram-2)

## Directory structure

The structure of the application is:

    MyApp
    ├── bin/
    ├── config/
    ├── docs/
    ├── public/
    |   ├── css/
    |   ├── images/
    |   └── js/
    ├── resources/
    ├── src/
    |   ├── domains/
    |   └── framework/
    └── tests/

### `bin` directory

The `bin` directory contains command-line executables.

### `config` directory

The `config` directory contains application’s configuration files.

### `docs` directory

The `docs` directory contains documentation files.

### `public` directory

The `public` directory contains web server files, including `bootstrap.php` file and assets (images, JavaScript files and CSS files).

### `resources` directory

The `resources` directory contains other resource files.

### `src` directory

The `src` directory contains PHP source code.

### `tests` directory

The `tests` directory contains automated tests code.

[⬆️ Table of contents](#table-of-contents)

## Autoloader

The PHPeacock autoloader enables classes, interfaces or traits to be automatically loaded.

### Activation

The `boostrap.php` file in the `public` folder must implement the `Autoloader` class:

```php
<?php

declare(strict_types=1);

use PHPeacock\Autoloader;

require_once '../src/Autoloader.php';
(new Autoloader)->register();

```

### New classes autoloading

Each new PHP class must be placed in the `src` folder. Its namespace must follow its path and begin with the application name.

_Example with `Example.php`_:

    MyApp
    |
    […]
    ├── src/
    |   ├── domains/
    |   |   ├── mydomain/
    |   |   |   └── Example.php
    |   |   └── otherdomain/
    |   └── framework/
    […]

If `Example.php` is in MyApp/src/Domains/MyDomain, its namespace must be “MyApp\Domains\MyDomain”, as below.

```php
<?php
namespace MyApp\Domains\MyDomain;

/**
 * Description
 */
class Example
{

}

```

### Class diagram

![Autoloader UML class diagram](uml/autoloader.svg)

[⬆️ Table of contents](#table-of-contents)

## Collections

With PHP, collections are essentials to guarantee that a list contains instances with the same “contract”.

### Precautions

The abstract `Collection` class do not have any `attach` or `detach` methods on purpose, to prevent the breaking of the Liskov substitution principle.

### Implementation

Each `Collection` child must override the parent constructor to control the parameter type, and may have an `attach` and `detach` method:

```php
<?php
namespace MyApp\Domains\MyDomain;

use PHPeacock\Framework\Structures\Collection;

class ExampleCollection extends Collection
{
    public function __construct(Example ...$examples)
    {
        parent::__construct(...$examples);
    }

    public function attach(Example $example): self
    {
        $this->elements->attach(object: $example);
        return $this;
    }

    public function detach(Example $example): self
    {
        $this->elements->detach(object: $example);
        return $this;
    }
}

```

### Class diagram

![Collections UML class diagram](uml/collections.svg)

[⬆️ Table of contents](#table-of-contents)

## Persistence

Persistence is the storage of data in the form of objects, here called entities.

### Implementation

The implementation may be as follow.

#### In `public/bootstrap.php`

```php
// declare…
// use…
// autoloader…

$config = require_once '../config/config.php';

$database = new Database(
    host: $config['database']['host'],
    name: $config['database']['name'],
    user: $config['database']['user'],
    password: $config['database']['password'],
);

$dbmsConnection = new MySQLConnection(database: $database); // Or any other DBMSConnection child

// Some code…

```

#### In `src/Domains/MyDomain/Example.php`

```php
<?php
namespace MyApp\Domains\MyDomain;

// use…

class Example extends Entity
{
    public function __construct(
        protected DBMSConnection $dbmsConnection,
        protected ?int $id = null,
        protected string $field1,
        protected string $field2,
    )
    { }

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

    // Getters and setters…
}

```

#### In `src/Domains/MyDomain/SelectExample.php`

```php
<?php
namespace MyApp\Domains\MyDomain;

// use…

class SelectExample extends SelectEntity
{
    public function __construct(protected DBMSConnection $dbmsConnection)
    { }

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

```

### Class diagrams

#### Database connections

![Database connections UML class diagram](uml/connections.svg)

#### SQL queries

![SQL queries UML class diagram](uml/queries.svg)

#### Entities

![Entities UML class diagram](uml/entities.svg)

[⬆️ Table of contents](#table-of-contents)

## URL routing

The router triggers the right action, it compares the input request URI with each route’s request URI regex.

If parameters are provided, the router adds the variables to the action HTTPRequest instance:

* For a route request URI “example” and a “id” parameter equal to “1”, the router adds the GET variable “id” equal to “1”.
* For a route request URI “example/([0-9]{1,3})”, a input request URI “example/3” and a “id” parameter equal to “$1”, the router adds the GET variable “id” equal to “3”.

### Implementation

The implementation may be as follow.

#### In `public/bootstrap.php`

```php
// declare…
// use…
// autoloader…
// database…

$httpRequest = new HTTPRequest();

$exampleRoutes = new RouteCollection(
    new ExampleRoute(
        requestURI: 'example(/.*){0,1}',
        action: new Show404Example(
            dbmsConnection: $dbmsConnection,
            httpRequest: $httpRequest,
        ),
        childRoutes: new RouteCollection(
            new ExampleRoute(
                requestURI: 'example',
                action: new ShowAllExamples(
                    dbmsConnection: $dbmsConnection,
                    httpRequest: $httpRequest,
                ),
            ),
            new ExampleRoute(
                requestURI: 'example/([0-9]{1,3})',
                action: new ShowExample(
                    dbmsConnection: $dbmsConnection,
                    httpRequest: $httpRequest,
                ),
                parameters: new ParameterCollection(
                    new Parameter(name: 'id', value: '$1'),
                ),
            ),
        )
    ),
);

$example2Routes = new RouteCollection(
    new Example2Route(
        requestURI: 'example2(/.*){0,1}',
        action: new Show404Example2(
            dbmsConnection: $dbmsConnection,
            httpRequest: $httpRequest,
        ),
        childRoutes: new RouteCollection(
            new Example2Route(
                requestURI: 'example2',
                action: new ShowAllExample2s(
                    dbmsConnection: $dbmsConnection,
                    httpRequest: $httpRequest,
                ),
            ),
            new Example2Route(
                requestURI: 'example2/([0-9]{1,3})',
                action: new ShowExample2(
                    dbmsConnection: $dbmsConnection,
                    httpRequest: $httpRequest,
                ),
                parameters: new ParameterCollection(
                    new Parameter(name: 'id', value: '$1'),
                ),
            ),
        )
    ),
);

$mainRoutes = new RouteCollection(
    ...$exampleRoutes,
    ...$example2Routes,
);

$router = new Router(routeCollection: $mainRoutes, httpRequest: $httpRequest);
$action = $router->getActionFromRoutes();
$action->execute();

// Some code…

```

#### In `src/Domains/MyDomain/Routing/ShowAllExamples.php`

```php
<?php
namespace MyApp\Domains\MyDomain\Routing;

use MyApp\Domains\MyDomain\SelectExample;
use PHPeacock\Framework\Exceptions\Persistence\Entities\SelectEntityException;
use PHPeacock\Framework\Exceptions\Routing\ExecuteActionException;

class ShowAllExamples extends ExampleAction
{
    public function execute(): void
    {
        $selectExample = new SelectExample(dbmsConnection: $this->dbmsConnection);

        try
        {
            $allExamples = $selectExample->selectAll();
        }
        catch (SelectEntityException $exception)
        {
            throw new ExecuteActionException(
                message: 'An error occurs when executing an “Show all examples” action.',
                previous: $exception
            );
        }

        // Some code…
    }
}

```

#### In `src/Domains/MyDomain/Routing/ShowExample.php`

```php
<?php
namespace MyApp\Domains\MyDomain\Routing;

use MyApp\Domains\MyDomain\SelectExample;
use PHPeacock\Framework\Exceptions\Persistence\Entities\SelectEntityException;
use PHPeacock\Framework\Exceptions\Routing\ExecuteActionException;

class ShowExample extends ExampleAction
{
    public function execute(): void
    {
        $selectExample = new SelectExample(dbmsConnection: $this->dbmsConnection);

        try
        {
            $example = $selectExample->selectById(id: (int) $this->httpRequest->getGetVariableByName(name: 'id'));
        }
        catch (SelectEntityException $exception)
        {
            throw new ExecuteActionException(
                message: 'An error occurs when executing an “Show example” action.',
                previous: $exception
            );
        }

        // Some code…
    }
}

```

### Class diagram

![URL routing UML class diagram](uml/routing.svg)

[⬆️ Table of contents](#table-of-contents)
