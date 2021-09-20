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

    public function addContent(string $text): self
    {
        $element = new XMLText(text: $text);
        $this->lastElementsStack->top()->getChildNodes()->attach(xmlNode: $element);

        return $this;
    }
}
