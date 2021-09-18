<?php
namespace PHPeacock\Framework\DOM;

use PHPeacock\Framework\Exceptions\DOM\DOMAttributeException;

/**
 * Abstract DOM attribute.
 */
abstract class DOMAttribute
{
    /**
     * Attribute name.
     * @var string $name
     */
    protected string $name;

    /**
     * Attribute value.
     * @var string $value
     */
    protected string $value;

    /**
     * @param string $name  Attribute name.
     * @param string $value Attribute value.
     */
    public function __construct(string $name, string $value)
    {
        $this->setName(name: $name);
        $this->setValue(value: $value);
    }

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
     * @param string $name Attribute name.
     * 
     * @return void
     */
    public function setName(string $name): void
    {
        if (preg_match(pattern: '/^[a-zA-Z_][a-zA-Z0-9_\.:-]*$/', subject: $name))
        {
            $this->name = $name;
        }
        else
        {
            throw new DOMAttributeException(message: 'The “' . $name . '” attribute has a non allowed character.');
        }
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
     * @param string $value Attribute value.
     * 
     * @return void
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }
}
