<?php
namespace PHPeacock\Framework\Persistence\Queries;

/**
 * Parameter to bind.
 */
trait BindParameter
{
    /**
     * Parameters to bind.
     * @var array $parameters
     */
    protected array $parameters;

    /**
     * Adds a parameter.
     * 
     * @param string $name  Parameter name.
     * @param mixed  $value Parameter value.
     * 
     * @return self
     */
    public function addParameter(string $name, mixed $value): self
    {
        $this->parameters[$name] = $value;

        return $this;
    }

    /**
     * Returns the list of parameters.
     * 
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }
}
