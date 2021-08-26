<?php
namespace PHPeacock\Framework\Routing;

/**
 * URI parameter.
 */
class Parameter
{
    /**
     * Parameter’s name.
     * @var string $name
     */

    /**
     * Parameter’s value.
     * @var string $value
     */

    /**
     * @param string $name  Parameter’s name.
     * @param string $value Parameter’s value.
     */
    public function __construct(
        protected string $name,
        protected string $value,
    )
    { }

    /**
     * Returns the name property.
     * 
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets the name property.
     * 
     * @param string $name Parameter’s name.
     * 
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Returns the value property.
     * 
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Sets the value property.
     * 
     * @param string $value Parameter’s value.
     * 
     * @return void
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }

}
