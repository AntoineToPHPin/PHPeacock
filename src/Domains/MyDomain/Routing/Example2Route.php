<?php
namespace MyApp\Domains\MyDomain\Routing;

use PHPeacock\Framework\Routing\ParameterCollection;
use PHPeacock\Framework\Routing\Route;
use PHPeacock\Framework\Routing\RouteCollection;

/**
 * Example2 route.
 */
class Example2Route extends Route
{
    /**
     * @param string                   $requestURI  Request URI.
     * @param ExampleAction            $action      Action.
     * @param ParameterCollection|null $parameters  URI parameters.
     * @param RouteCollection|null     $childRoutes Child routes.
     */
    public function __construct(
        protected string $requestURI,
        Example2Action $action,
        protected ?ParameterCollection $parameters = null,
        protected ?RouteCollection $childRoutes = null,
    )
    {
        $this->action = $action;
    }
}
