<?php
namespace PHPeacock\Framework\Routing;

use PHPeacock\Framework\Exceptions\ControllerNotFoundException;
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
     * Returns the right controller from the routes collection.
     * 
     * @throws ControllerNotFoundException if there is no route for the request URI.
     * 
     * @return Controller
     */
    public function getController(): Controller
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
                $controller = $route->getController();

                $parameters = [];
                foreach ($controller->getActionParameters() as $key => $value)
                {
                    $parameters[$key] = preg_replace(
                        pattern: $regexPattern,
                        replacement: $value,
                        subject: $requestURI,
                    );
                }

                $controller->setActionParameters(actionParameters: $parameters);

                return $controller;
            }
        }

        throw new ControllerNotFoundException();
    }
}
