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
     * If URI variables are provided, the router adds the variables to the HTTPRequest
     * instance (regex capturing group can be used).
     * 
     * @throws ActionNotFoundException if there is no route for the request URI.
     * 
     * @return Action
     */
    public function getAction(): Action
    {
        $requestURI = $this->httpRequest->getGetVariableByName(name: 'requestURI');

        foreach ($this->routeCollection as $route)
        {
            $regexPattern = '~^' . $route->getRequestURI() . '/?$~i';

            if (preg_match(
                pattern: $regexPattern,
                subject: $requestURI,
            ))
            {
                $action = $route->getAction();

                foreach ($route->getURIVariables() as $key => $value)
                {
                    $action->getHTTPRequest()->addGetVariable(
                        name: $key,
                        value: preg_replace(
                            pattern: $regexPattern,
                            replacement: $value,
                            subject: $requestURI,
                        )
                    );
                }

                return $action;
            }
        }

        throw new ActionNotFoundException(message: 'The request URI has no match.');
    }
}
