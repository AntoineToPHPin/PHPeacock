# `Autoloader` class

## New classes implementation

Each new PHP class must be placed in the `src` folder. Its namespace must follow its path and begin with the application name.

Example with `Example.php`:

```
MyApp
├── bin
├── docs
├── public
└── src
    ├── domains
    |   └── mydomain
    |       └── Example.php
    └── framework
```

```php
<?php
namespace MyApp\Domains\Mydomain;

/**
 * Description
 */
class Example
{

}

```

## Bootstrap file implementation

The bootstrap file in the `public` folder (i.e. `boostrap.php`) must implement the `Autoloader` class, as follow.

```php
<?php

use PHPeacock\Autoloader;

require_once '../src/Autoloader.php';

(new Autoloader)->register();

```

## Class diagram

![Autoloader UML class diagram](uml/autoloader.svg)
