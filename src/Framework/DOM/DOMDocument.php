<?php
namespace PHPeacock\Framework\DOM;

/**
 * Abstract DOM document.
 */
abstract class DOMDocument implements \Stringable
{
    /**
     * Document elements.
     * @var DOMElementCollection $elements
     */
    protected DOMElementCollection $elements;

    /**
     * Returns the elements property.
     * 
     * @return DOMElementCollection
     */
    public function getElements(): DOMElementCollection
    {
        return $this->elements;
    }

    /**
     * @throws DOMDocumentException if an error occurs when creating the child nodes.
     * 
     * @return string
     */
    abstract public function __toString(): string;
}
