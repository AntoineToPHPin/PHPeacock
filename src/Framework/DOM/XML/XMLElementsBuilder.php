<?php
namespace PHPeacock\Framework\DOM\XML;

use PHPeacock\Framework\DOM\DOMElementsBuilder;
use PHPeacock\Framework\Exceptions\DOM\DOMAttributeException;
use PHPeacock\Framework\Exceptions\DOM\DOMElementException;
use PHPeacock\Framework\Exceptions\DOM\DOMElementsBuilderException;

/**
 * XML elements builder.
 */
class XMLElementsBuilder extends DOMElementsBuilder
{
    /**
     * XML elements under construction.
     * @var XMLElementCollection $elements
     */
    protected XMLElementCollection $elements;

    /**
     * Stack of opened XML elements.
     * @var SplStack $lastElementsStack
     */
    protected \SplStack $lastElementsStack;

    public function __construct()
    {
        $this->elements = new XMLElementCollection();
        $this->lastElementsStack = new \SplStack();
    }

    /**
     * {@inheritDoc}
     */
    public function openElement(string $name, string $value = ''): self
    {
        try
        {
            $element = new XMLElement(name: $name, value: $value);
        }
        catch (DOMElementException $exception)
        {
            throw new DOMElementsBuilderException(
                message: 'An error occurs when opening the “' . $name . '” element.',
                previous: $exception
            );
        }

        if ($this->lastElementsStack->isEmpty())
        {
            $this->elements->attach(xmlElement: $element);
        }
        else
        {
            $this->lastElementsStack->top()->getChildNodes()->attach(xmlNode: $element);
        }
        $this->lastElementsStack->push(value: $element);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function closeElement(string $name): self
    {
        $lastElementName = $this->lastElementsStack->top()->getName();
        if ($lastElementName === $name)
        {
            $this->lastElementsStack->pop();
        }
        else
        {
            throw new DOMElementsBuilderException(
                message: 'The last opened element is not a “' . $name . '” element.',
            );
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function addAttribute(string $name, string $value): self
    {
        try
        {
            $this->lastElementsStack
                ->top()
                ->getAttributes()
                ->attach(xmlAttribute: new XMLAttribute(name: $name, value: $value));
        }
        catch (DOMAttributeException $exception)
        {
            throw new DOMElementsBuilderException(
                message: 'An error occurs when adding the “' . $name . '” attribute.',
                previous: $exception
            );
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function addContent(string $text): self
    {
        $element = new XMLText(text: $text);
        $this->lastElementsStack->top()->getChildNodes()->attach(xmlNode: $element);

        return $this;
    }

    /**
     * Adds a collection of XML elements to the last opened element.
     * 
     * @param XMLElementCollection $elements Collection of XML elements.
     * 
     * @return self
     */
    public function addElements(XMLElementCollection $elements): self
    {
        foreach ($elements as $element)
        {
            if ($this->lastElementsStack->isEmpty())
            {
                $this->elements->attach(xmlElement: $element);
            }
            else
            {
                $this->lastElementsStack->top()->getChildNodes()->attach(xmlNode: $element);
            }
        }

        return $this;
    }

    /**
     * Returns the elements property.
     * 
     * @return XMLElementCollection
     */
    public function getElements(): XMLElementCollection
    {
        return $this->elements;
    }
}
