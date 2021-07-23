# URL routing

The URL routing triggers the right action according to the client request URI.

## Implementation

The implementation may be as follow.

### In `public/bootstrap.php`

```php
// declare…
// use…
// Autoloader…
// Database…
// DBMS connection…

$httpRequest = new HTTPRequest();

$routeCollection = new RouteCollection(
    new Route(
        requestURI: 'examples',
        controller: new ExampleController(
            dbmsConnection: $dbmsConnection,
            action: 'ShowAllExamples',
        ),
    ),
    new Route(
        requestURI: 'example',
        controller: new ExampleController(
            dbmsConnection: $dbmsConnection,
            action: 'ShowExample',
            actionParameters: ['id' => '1'],
        ),
    ),
    new Route(
        requestURI: 'example/([0-9]{1,3})',
        controller: new ExampleController(
            dbmsConnection: $dbmsConnection,
            action: 'ShowExample',
            actionParameters: ['id' => '$1'],
        ),
    ),
);

$router = new Router(routeCollection: $routeCollection, httpRequest: $httpRequest);
$controller = $router->getController();
$controller->render();

// Some code…

```

### In `src/domains/mydomain/routing/ExampleController.php`

```php
<?php
namespace MyApp\Domains\Mydomain\Routing;

use PHPeacock\Framework\Exceptions\UnexpectedClassException;
use PHPeacock\Framework\Routing\Controller;

/**
 * Example controller.
 */
class ExampleController extends Controller
{
    /**
     * {@inheritDoc}
     */
    public function render(): void
    {
        $actionName = __NAMESPACE__ . '\\' . $this->getAction();
        $actionParent = __NAMESPACE__ . '\\' . 'ExampleAction';

        if (is_subclass_of(object_or_class: $actionName, class: $actionParent))
        {
            $action = new $actionName($this->getDBMSConnection(), ...$this->getActionParameters());
            
            $action->execute();
        }
        else
        {
            throw new UnexpectedClassException();
        }
    }
}

```

### In `src/domains/mydomain/routing/ShowAllExamples.php`

```php
<?php
namespace MyApp\Domains\Mydomain\Routing;

use MyApp\Domains\Mydomain\SelectExample;
use PHPeacock\Framework\Persistence\Connections\DBMSConnection;

/**
 * “Show all examples” action.
 */
class ShowAllExamples extends ExampleAction
{
    /**
     * Related database management system connection.
     * @var DBMSConnection $dbmsConnection
     */

    /**
     * @param DBMSConnection $dbmsConnection Related database management system connection.
     */
    public function __construct(protected DBMSConnection $dbmsConnection)
    { }

    /**
     * {@inheritDoc}
     */
    public function execute(): void
    {
        $selectExample = new SelectExample($this->getDBMSConnection());

        $allExamples = $selectExample->selectAll();

        // Some code…
    }
}
```

### In `src/domains/mydomain/routing/ShowExample.php`

```php
<?php
namespace MyApp\Domains\Mydomain\Routing;

use MyApp\Domains\Mydomain\SelectExample;
use PHPeacock\Framework\Persistence\Connections\DBMSConnection;

/**
 * “Show example” action.
 */
class ShowExample extends ExampleAction
{
    /**
     * Related database management system connection.
     * @var DBMSConnection $dbmsConnection
     */

    /**
     * Example id.
     * @var string $id
     */

    /**
     * @param DBMSConnection $dbmsConnection Related database management system connection.
     * @param string         $id             Example id.
     */
    public function __construct(
        protected DBMSConnection $dbmsConnection,
        protected string $id,
    )
    { }

    /**
     * {@inheritDoc}
     */
    public function execute(): void
    {
        $selectExample = new SelectExample($this->getDBMSConnection());

        $example = $selectExample->selectById(id: (int) $this->id);

        // Some code…
    }
}

```

## Class diagram

![URL routing UML class diagram](uml/routing.svg)
