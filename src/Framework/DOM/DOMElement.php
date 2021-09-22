<?php
namespace PHPeacock\Framework\DOM;

use PHPeacock\Framework\Exceptions\DOM\DOMAttributeException;
use PHPeacock\Framework\Exceptions\DOM\DOMElementException;

/**
 * Abstract DOM element.
 */
abstract class DOMElement implements DOMNode
{
    /**
     * Element name.
     * @var string $name
     */
    protected string $name;

    /**
     * Element value.
     * @var string $value
     */
    protected string $value;

    /**
     * Element child nodes.
     * @var DOMNodeCollection $childNodes
     */
    protected DOMNodeCollection $childNodes;

    /**
     * Element attributes.
     * @var DOMAttributeCollection $attributes
     */
    protected DOMAttributeCollection $attributes;

    /**
     * {@inheritDoc}
     */
    public function createNode(): \DOMElement
    {
        $domDocument = new \DOMDocument();
        try
        {
            $domElement = $domDocument->createElement(localName: $this->name, value: $this->value);
        }
        catch (\DOMException $exception)
        {
            throw new DOMElementException(
                message: 'An error occurs when creating the “' . $this->name . '” element.',
                previous: $exception
            );
        }
        $domDocument->appendChild(node: $domElement);

        foreach ($this->attributes as $attribute)
        {
            try
            {
                $domAttribute = $domDocument->createAttribute(localName: $attribute->getName());
            }
            catch (\DOMException $exception)
            {
                throw new DOMAttributeException(
                    message: 'An error occurs when creating the “' . $attribute->getName() . '” attribute.',
                    previous: $exception
                );
            }
            $domAttribute->value = $attribute->getValue();
            $domElement->appendChild(node: $domAttribute);
        }

        foreach ($this->childNodes as $childNodes)
        {
            $domElement->appendChild(node: $domDocument->importNode(
                node: $childNodes->createNode(),
                deep: true
            ));
        }

        return $domElement;
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
     * @throws DOMElementException if the element name has a non allowed character.
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
            throw new DOMElementException(message: 'The “' . $name . '” element has a non allowed character.');
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

    /**
     * Returns the childNodes property.
     * 
     * @return DOMNodeCollection
     */
    public function getChildNodes(): DOMNodeCollection
    {
        return $this->childNodes;
    }

    /**
     * Returns the attributes property.
     * 
     * @return DOMAttributeCollection
     */
    public function getAttributes(): DOMAttributeCollection
    {
        return $this->attributes;
    }
}
