<?php
namespace PHPeacock\Framework\Routing;

use PHPeacock\Framework\Structures\Collection;

/**
 * Collection of routes.
 */
class RouteCollection extends Collection
{
    /**
     * @param Route $routes,... Routes to add.
     */
    public function __construct(Route ...$routes)
    {
        parent::__construct(...$routes);
    }

    /**
     * Adds the route to the collection.
     * 
     * @param Route $routes Route to add.
     * 
     * @return self
     */
    public function attach(Route $route): self
    {
        $this->elements->attach(object: $route);
        return $this;
    }

    /**
     * Removes the route from the collection.
     * 
     * @param Route $route Route to remove.
     * 
     * @return self
     */
    public function detach(Route $route): self
    {
        $this->elements->detach(object: $route);
        return $this;
    }
}
