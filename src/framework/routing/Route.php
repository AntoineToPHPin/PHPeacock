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

    /**
     * Action.
     * @var Action $action
     */

    /**
     * URI variables.
     * @var array $uriVariables
     */

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
    public function getAction(): Action
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
     * Returns the uriVariables property.
     * 
     * @return array
     */
    public function getURIVariables(): array
    {
        return $this->uriVariables;
    }

    /**
     * Sets the uriVariables property.
     * 
     * @param array $uriVariables URI variables.
     * 
     * @return void
     */
    public function setURIVariables(array $uriVariables): void
    {
        $this->uriVariables = $uriVariables;
    }
}
