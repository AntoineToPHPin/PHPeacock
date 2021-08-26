<?php
namespace PHPeacock\Framework\Routing;

use PHPeacock\Framework\Exceptions\Routing\ActionNotFoundException;
use PHPeacock\Framework\HTTP\HTTPRequest;

/**
 * Returns the right controller according to the request URI.
 */
class Router
{
    /**
     * Collection of routes.
     * @var RouteCollection $routeCollection
     */

    /**
     * HTTP request.
     * @var HTTPRequest $httpRequest
     */

    /**
     * @param RouteCollection $routeCollection Collection of routes.
     * @param HTTPRequest     $httpRequest     HTTP request.
     */
    public function __construct(
        protected RouteCollection $routeCollection,
        protected HTTPRequest $httpRequest,
    )
    { }

    /**
     * Returns the right action from the route collection.
     * 
     * The router compares the input request URI with each route’s request URI regex.
     * 
     * If parameters are provided, the router adds the variables to the action HTTPRequest
     * instance.
     * 
     * * Simple example:
     * 
     * For a route request URI “example” and a “id” parameter equal to “1”,
     * the router adds the GET variable “id” equal to “1”.
     * 
     * * Example with regex capturing group:
     * 
     * For a route request URI “example/([0-9]{1,3})”, a input request URI “example/3” and
     * a “id” parameter equal to “$1”, the router adds the GET variable “id” equal to “3”.
     * 
     * @throws ActionNotFoundException if there is no route for the request URI.
     * 
     * @return Action
     */
    public function getActionFromRoutes(): Action
    {
        $inputRequestURI = $this->httpRequest->getGetVariableByName(name: 'requestURI');

        foreach ($this->routeCollection as $route)
        {
            $regexPattern = '~^' . $route->getRequestURI() . '/?$~i';

            $doesThisRouteMatch = (bool) preg_match(
                pattern: $regexPattern,
                subject: $inputRequestURI,
            );

            if ($doesThisRouteMatch)
            {
                if ($route->getParameters() !== null)
                {
                    $this->addParametersToHTTPRequest(route: $route);
                }

                $action = $route->getAction();

                return $action;
            }
        }

        throw new ActionNotFoundException(message: 'The request URI has no match.');
    }

    /**
     * Adds the route parameters to its action HTTPRequest instance (regex capturing group can be used).
     * 
     * @see getActionFromRoutes
     * 
     * @param Route $route Route between a request URI and an action.
     * 
     * @return void
     */
    protected function addParametersToHTTPRequest(Route $route): void
    {
        $inputRequestURI = $this->httpRequest->getGetVariableByName(name: 'requestURI');
        $regexPattern = '~^' . $route->getRequestURI() . '/?$~i';

        foreach ($route->getParameters() as $parameter)
        {
            $route->getAction()->getHTTPRequest()->addGetVariable(
                name: $parameter->getName(),
                value: preg_replace(
                    pattern: $regexPattern,
                    replacement: $parameter->getValue(),
                    subject: $inputRequestURI,
                )
            );
        }
    }
}
