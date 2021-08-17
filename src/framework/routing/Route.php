<?php
namespace PHPeacock\Framework\Routing;

/**
 * Route between a request URI and a controller.
 */
class Route
{
    /**
     * Request URI.
     * @var string $requestURI
     */

    /**
     * Controller.
     * @var Controller $controller
     */

    /**
     * URI variables.
     * @var array $uriVariables
     */

    /**
     * @param string     $requestURI Request URI.
     * @param Controller $controller Controller.
     * @param array      $uriVariables URI variables.
     */
    public function __construct(
        protected string $requestURI,
        protected Controller $controller,
        protected array $uriVariables = [],
    )
    { }

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
     * Returns the controller property.
     * 
     * @return Controller
     */
    public function getController(): Controller
    {
        return $this->controller;
    }

    /**
     * Sets the controller property.
     * 
     * @param Controller $controller Controller.
     * 
     * @return void
     */
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
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
