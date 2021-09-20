<?php
namespace PHPeacock\Framework\DOM\HTML;

use PHPeacock\Framework\DOM\DOMElementCollection;

/**
 * Collection of HTML elements.
 */
class HTMLElementCollection extends DOMElementCollection
{
    /**
     * @param HTMLElement $htmlElements,... HTML elements to add.
     */
    public function __construct(HTMLElement ...$htmlElements)
    {
        parent::__construct(...$htmlElements);
    }

    /**
     * Adds the HTML element to the collection.
     * 
     * @param HTMLElement $htmlElement HTML element to add.
     * 
     * @return self
     */
    public function attach(HTMLElement $htmlElement): self
    {
        $this->elements->attach(object: $htmlElement);
        return $this;
    }

    /**
     * Removes the HTML element from the collection.
     * 
     * @param HTMLElement $htmlElement HTML element to remove.
     * 
     * @return self
     */
    public function detach(HTMLElement $htmlElement): self
    {
        $this->elements->detach(object: $htmlElement);
        return $this;
    }
}
