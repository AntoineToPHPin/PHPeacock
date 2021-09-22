<?php
namespace PHPeacock\Framework\DOM\HTML;

use PHPeacock\Framework\DOM\DOMElement;

/**
 * HTML element.
 */
class HTMLElement extends DOMElement implements HTMLNode
{
    /**
     * @param string                  $name       Element name.
     * @param string                  $value      Element value.
     * @param HTMLNodeCollection      $childNodes Element child nodes.
     * @param HTMLAttributeCollection $attributes Element attributes.
     * 
     * @throws DOMElementException if the element name has a non allowed character.
     */
    public function __construct(
        string $name,
        string $value = '',
        HTMLNodeCollection $childNodes = null,
        HTMLAttributeCollection $attributes = null,
    )
    {
        $this->setName(name: $name);
        $this->setValue(value: $value);
        $this->childNodes = isset($childNodes) ? $childNodes : new HTMLNodeCollection();
        $this->attributes = isset($attributes) ? $attributes : new HTMLAttributeCollection();
    }
}
