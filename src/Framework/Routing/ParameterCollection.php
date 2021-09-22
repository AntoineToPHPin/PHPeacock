<?php
namespace PHPeacock\Framework\Routing;

use PHPeacock\Framework\Structures\Collection;

/**
 * Collection of parameters.
 */
class ParameterCollection extends Collection
{
    /**
     * @param Parameter $parameters,... Parameters to add.
     */
    public function __construct(Parameter ...$parameters)
    {
        parent::__construct(...$parameters);
    }

    /**
     * Adds the parameter to the collection.
     * 
     * @param Parameter $parameter Parameter to add.
     * 
     * @return self
     */
    public function attach(Parameter $parameter): self
    {
        $this->elements->attach(object: $parameter);
        return $this;
    }

    /**
     * Removes the parameter from the collection.
     * 
     * @param Parameter $parameter Parameter to remove.
     * 
     * @return self
     */
    public function detach(Parameter $parameter): self
    {
        $this->elements->detach(object: $parameter);
        return $this;
    }
}
