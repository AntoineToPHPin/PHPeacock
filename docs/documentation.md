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
        2. [In `src/Domains/MyDomain/Entities/Example.php`](#in-srcdomainsmydomainentitiesexamplephp)
        3. [In `src/Domains/MyDomain/Entities/SelectExample.php`](#in-srcdomainsmydomainentitiesselectexamplephp)
    2. [Class diagrams](#class-diagrams)
        1. [Database connections](#database-connections)
        2. [SQL queries](#sql-queries)
        3. [Entities](#entities)
5. [URL routing](#url-routing)
    1. [Implementation](#implementation-2)
        1. [In `public/bootstrap.php`](#in-publicbootstrapphp-1)
        2. [In `src/Domains/MyDomain/Actions/ShowAllExamples.php`](#in-srcdomainsmydomainactionsshowallexamplesphp)
        3. [In `src/Domains/MyDomain/Templates/AllExamplesTemplate.php`](#in-srcdomainsmydomaintemplatesallexamplestemplatephp)
    2. [Class diagram](#class-diagram-2)
        1. [Routing](#routing)
        2. [Template](#template)

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
    |   ├── Domains/
    |   |   ├── MyDomain/
    |   |   |   └── Entities/
    |   |   |       └── Example.php
    |   |   └── OtherDomain/
    |   └── Framework/
    […]

If `Example.php` is in MyApp/src/Domains/MyDomain/Entities, its namespace must be “MyApp\Domains\MyDomain\Entities”, as below.

```php
<?php
namespace MyApp\Domains\MyDomain\Entities;

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
namespace MyApp\Domains\MyDomain\Entities;

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

#### In `src/Domains/MyDomain/Entities/Example.php`

```php
<?php
namespace MyApp\Domains\MyDomain\Entities;

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

#### In `src/Domains/MyDomain/Entities/SelectExample.php`

```php
<?php
namespace MyApp\Domains\MyDomain\Entities;

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

* For a route request URI “example/([0-9]{1,3})”, a input request URI “example/3” and a “id” parameter equal to “$1”, the router adds the GET variable “id” equal to “3”.
* For a route request URI “example” and a “id” parameter equal to “1”, the router adds the GET variable “id” equal to “1”.

### Implementation

The implementation may be as follow.

#### In `public/bootstrap.php`

```php
// declare…
// use…
// autoloader…
// database…

$httpRequest = new HTTPRequest();
$httpResponse = new HTTPResponse(url: $config['url']);

$exampleRoutes = new ExampleRoute(
    requestURI: 'example(/.*)?',
    action: new Show404Example(
        dbmsConnection: $dbmsConnection,
        httpRequest: $httpRequest,
        httpResponse: $httpResponse,
    ),
    childRoutes: new RouteCollection(
        new ExampleRoute(
            requestURI: 'example',
            action: new ShowAllExamples(
                dbmsConnection: $dbmsConnection,
                httpRequest: $httpRequest,
                httpResponse: $httpResponse,
            ),
        ),
        new ExampleRoute(
            requestURI: 'example/add-example',
            action: new AddExample(
                dbmsConnection: $dbmsConnection,
                httpRequest: $httpRequest,
                httpResponse: $httpResponse,
            ),
        ),
        new ExampleRoute(
            requestURI: 'example/([0-9]{1,3})',
            action: new ShowExample(
                dbmsConnection: $dbmsConnection,
                httpRequest: $httpRequest,
                httpResponse: $httpResponse,
            ),
            parameters: new ParameterCollection(
                new Parameter(name: 'id', value: '$1'),
            ),
        ),
        new ExampleRoute(
            requestURI: 'example/remove/([0-9]{1,3})',
            action: new RemoveExample(
                dbmsConnection: $dbmsConnection,
                httpRequest: $httpRequest,
                httpResponse: $httpResponse,
            ),
            parameters: new ParameterCollection(
                new Parameter(name: 'id', value: '$1'),
            ),
        ),
        new ExampleRoute(
            requestURI: 'example/change',
            action: new ChangeExample(
                dbmsConnection: $dbmsConnection,
                httpRequest: $httpRequest,
                httpResponse: $httpResponse,
            ),
        ),
    ),
);

$routeCollection = new RouteCollection(
    new HomeRoute(
        requestURI: '.*',
        action: new Show404(
            dbmsConnection: $dbmsConnection,
            httpRequest: $httpRequest,
            httpResponse: $httpResponse,
        ),
        childRoutes: new RouteCollection(
            new HomeRoute(
                requestURI: '/?',
                action: new ShowHome(
                    dbmsConnection: $dbmsConnection,
                    httpRequest: $httpRequest,
                    httpResponse: $httpResponse,
                ),
            ),
            $exampleRoutes,
        ),
    ),
);

$router = new Router(routeCollection: $routeCollection, httpRequest: $httpRequest);
$action = $router->getActionFromRoutes();
$template = $action->execute();
$template?->display();

```

Request URI examples:

* “example/1” matches with `.*`, `example(/.*)?` then `example/([0-9]{1,3})`, the triggered action is `ShowExample`.
* “example/test” matches with `.*` then only `example(/.*)?`, the triggered action is `Show404Example`.
* “test” matches only with `.*`, the triggered action is `Show404`.

#### In `src/Domains/MyDomain/Actions/ShowAllExamples.php`

```php
<?php
namespace MyApp\Domains\MyDomain\Actions;

// use…

class ShowAllExamples extends ExampleAction
{
    public function execute(): AllExamplesTemplate
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

        return new AllExamplesTemplate(examples: $allExamples, httpResponse: $this->httpResponse);
    }
}

```

#### In `src/Domains/MyDomain/Templates/AllExamplesTemplate.php`

```php
<?php
namespace MyApp\Domains\MyDomain\Templates;

// use…

class AllExamplesTemplate extends Template
{
    public function __construct(ExampleCollection $examples, HTTPResponse $httpResponse)
    {
        $builder = (new HTMLElementsBuilder)
            ->openElement('html')
                ->addAttribute(name: 'lang', value: 'en')
                ->openElement(name: 'head')
                    ->openElement(name: 'meta')
                        ->addAttribute(name: 'charset', value: 'UTF-8')
                    ->closeElement(name: 'meta')
                    ->openElement(name: 'meta')
                        ->addAttribute(name: 'http-equiv', value: 'X-UA-Compatible')
                        ->addAttribute(name: 'content', value: 'IE=edge')
                    ->closeElement(name: 'meta')
                    ->openElement(name: 'meta')
                        ->addAttribute(name: 'name', value: 'viewport')
                        ->addAttribute(name: 'content', value: 'width=device-width, initial-scale=1.0')
                    ->closeElement(name: 'meta')
                    ->openElement(name: 'title', value: 'Examples list')->closeElement(name: 'title')
                    ->openElement(name: 'link')
                        ->addAttribute(name: 'rel', value: 'stylesheet')
                        ->addAttribute(name: 'href', value: '/css/examples.css')
                    ->closeElement(name: 'link')
                ->closeElement(name: 'head')

                ->openElement(name: 'body')
                    ->openElement(name: 'h1', value: 'Examples :')->closeElement(name: 'h1')
        ;

        foreach ($examples as $example)
        {
            $builder
                    ->openElement(name: 'p')
                        ->addContent(text: 'field1: ' . $example->getField1() . ', field2: ' . $example->getField2() . ' ')
                        ->openElement(name: 'a')
                            ->addAttribute(name: 'href', value: '/example/' . $example->getId())
                            ->addContent(text: 'Details')
                        ->closeElement(name: 'a')
                        ->addContent(text: ' ')
                        ->openElement(name: 'a')
                            ->addAttribute(name: 'href', value: '/example/remove/' . $example->getId())
                            ->addContent(text: 'Remove')
                        ->closeElement(name: 'a')
                    ->closeElement(name: 'p')
            ;
        }

        $builder
                ->closeElement(name: 'body')
            ->closeElement(name: 'html')
        ;

        parent::__construct(elements: $builder->getElements(), httpResponse: $httpResponse);
    }
}

```

### Class diagram

#### Routing

![URL routing UML class diagram](uml/routing.svg)

#### Template

![Template UML class diagram](uml/template.svg)

[⬆️ Table of contents](#table-of-contents)
