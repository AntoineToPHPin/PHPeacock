<?php
namespace PHPeacock\Framework\DOM\XML;

use PHPeacock\Framework\DOM\DOMElement;

/**
 * XML element.
 */
class XMLElement extends DOMElement implements XMLNode
{
    /**
     * @param string                 $name       Element name.
     * @param string                 $value      Element value.
     * @param XMLNodeCollection      $childNodes Element child nodes.
     * @param XMLAttributeCollection $attributes Element attributes.
     * 
     * @throws DOMElementException if the element name has a non allowed character.
     */
    public function __construct(
        string $name,
        string $value = '',
        XMLNodeCollection $childNodes = null,
        XMLAttributeCollection $attributes = null,
    )
    {
        $this->setName(name: $name);
        $this->setValue(value: $value);
        $this->childNodes = isset($childNodes) ? $childNodes : new XMLNodeCollection();
        $this->attributes = isset($attributes) ? $attributes : new XMLAttributeCollection();
    }
}
