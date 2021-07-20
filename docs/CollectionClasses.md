# `Collection` class

With PHP, collections are essentials to guarantee that a list contains instances with the same “contract”.

## Precaution

The abstract `Collection` do not have any `attach` or `detach` methods on purpose, to prevent the breaking of the Liskov substitution principle.

## Implementation

Each `Collection` child must override the parent constructor to control the parameters type, and may have an `attach` and `detach` method, as below:

```php
<?php
namespace MyApp\Domains\MyDomain;

use PHPeacock\Framework\Structures\Collection;
use MyApp\Domains\MyDomain\Example;

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

## Class diagram

![Collections UML class diagram](uml/collections.svg)
