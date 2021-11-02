<?php
namespace PHPeacock\Framework\DOM\HTML;

use PHPeacock\Framework\DOM\DOMElementsBuilder;
use PHPeacock\Framework\Exceptions\DOM\DOMAttributeException;
use PHPeacock\Framework\Exceptions\DOM\DOMElementException;
use PHPeacock\Framework\Exceptions\DOM\DOMElementsBuilderException;

/**
 * HTML elements builder.
 */
class HTMLElementsBuilder extends DOMElementsBuilder
{
    public function __construct()
    {
        $this->elements = new HTMLElementCollection();
        $this->lastElementsStack = new \SplStack();
    }

    /**
     * {@inheritDoc}
     */
    public function openElement(string $name, string $value = ''): self
    {
        try
        {
            $element = new HTMLElement(name: $name, value: $value);
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
            $this->elements->attach(htmlElement: $element);
        }
        else
        {
            $this->lastElementsStack->top()->getChildNodes()->attach(htmlNode: $element);
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
    public function addAttribute(string $name, string $value = ''): self
    {
        try
        {
            $this->lastElementsStack
                ->top()
                ->getAttributes()
                ->attach(htmlAttribute: new HTMLAttribute(name: $name, value: $value));
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
        $element = new HTMLText(text: $text);
        $this->lastElementsStack->top()->getChildNodes()->attach(htmlNode: $element);

        return $this;
    }
}
