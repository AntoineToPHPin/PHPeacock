<?php
namespace PHPeacock\Framework\Routing;

/**
 * Abstract route between a request URI and an action.
 */
abstract class Route
{
    /**
     * Request URI.
     * @var string $requestURI
     */
    protected string $requestURI;

    /**
     * Action.
     * @var Action $action
     */
    protected ?Action $action;

    /**
     * URI parameters.
     * @var ParameterCollection|null $parameters
     */
    protected ?ParameterCollection $parameters;

    /**
     * Child routes.
     * @var RouteCollection|null $childRoutes
     */
    protected ?RouteCollection $childRoutes;

    /**
     * Returns the requestURI property.
     * 
     * @return string
     */
    public function getRequestURI(): string
    {
        return $this->requestURI;
    }

    /**
     * Sets the requestURI property.
     * 
     * @param string $requestURI Request URI.
     * 
     * @return void
     */
    public function setRequestURI(string $requestURI): void
    {
        $this->requestURI = $requestURI;
    }

    /**
     * Returns the action property.
     * 
     * @return Action
     */
    public function getAction(): ?Action
    {
        return $this->action;
    }

    /**
     * Sets the action property.
     * 
     * @param Action $action Action.
     * 
     * @return void
     */
    public function setAction(Action $action): void
    {
        $this->action = $action;
    }

    /**
     * Returns the parameters property.
     * 
     * @return ParameterCollection|null
     */
    public function getParameters(): ?ParameterCollection
    {
        return $this->parameters;
    }

    /**
     * Sets the parameters property.
     * 
     * @param ParameterCollection|null $parameters URI parameters.
     * 
     * @return void
     */
    public function setParameters(?ParameterCollection $parameters): void
    {
        $this->parameters = $parameters;
    }

    /**
     * Returns the childRoutes property.
     * 
     * @return RouteCollection|null
     */
    public function getChildRoutes(): ?RouteCollection
    {
        return $this->childRoutes;
    }

    /**
     * Sets the childRoutes property.
     * 
     * @param RouteCollection|null $childRoutes Child routes.
     * 
     * @return void
     */
    public function setChildRoutes(?RouteCollection $childRoutes): void
    {
        $this->childRoutes = $childRoutes;
    }
}
