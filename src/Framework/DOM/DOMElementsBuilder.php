<?php
namespace PHPeacock\Framework\DOM;

/**
 * Abstract DOM elements builder.
 */
abstract class DOMElementsBuilder
{
    /**
     * DOM elements under construction.
     * @var DOMElementCollection $elements
     */
    protected DOMElementCollection $elements;

    /**
     * Stack of opened DOM elements.
     * @var SplStack $lastElementsStack
     */
    protected \SplStack $lastElementsStack;

    /**
     * Opens an element.
     * 
     * @param string $name  Element name.
     * @param string $value Element value.
     * 
     * @throws DOMElementsBuilderException if an error occurs when opening the element.
     * 
     * @return self
     */
    abstract public function openElement(string $name, string $value = ''): self;

    /**
     * Closes the last opened element.
     * 
     * @param string $name Last opened element name.
     * 
     * @throws DOMElementsBuilderException if the last opened element has not the same name.
     * 
     * @return self
     */
    abstract public function closeElement(string $name): self;

    /**
     * Adds an attribute to the last opened element.
     * 
     * @param string $name  Attribute name.
     * @param string $value Attribute value.
     * 
     * @throws DOMElementsBuilderException if an error occurs when adding the attribute.
     * 
     * @return self
     */
    abstract public function addAttribute(string $name, string $value): self;

    /**
     * Adds a text node.
     * 
     * @param string $text Node text.
     * 
     * @return self
     */
    abstract public function addContent(string $text): self;

    /**
     * Returns the elements property.
     * 
     * @return DOMElementCollection
     */
    public function getElements(): DOMElementCollection
    {
        return $this->elements;
    }
}
