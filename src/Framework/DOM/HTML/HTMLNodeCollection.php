<?php
namespace PHPeacock\Framework\DOM\HTML;

use PHPeacock\Framework\DOM\DOMNodeCollection;

/**
 * Collection of HTML nodes.
 */
class HTMLNodeCollection extends DOMNodeCollection
{
    /**
     * @param HTMLNode $htmlNodes,... HTML nodes to add.
     */
    public function __construct(HTMLNode ...$htmlNodes)
    {
        parent::__construct(...$htmlNodes);
    }

    /**
     * Adds the HTML node to the collection.
     * 
     * @param HTMLNode $htmlNode HTML node to add.
     * 
     * @return self
     */
    public function attach(HTMLNode $htmlNode): self
    {
        $this->elements->attach(object: $htmlNode);
        return $this;
    }

    /**
     * Removes the HTML node from the collection.
     * 
     * @param HTMLNode $htmlNode HTML node to remove.
     * 
     * @return self
     */
    public function detach(HTMLNode $htmlNode): self
    {
        $this->elements->detach(object: $htmlNode);
        return $this;
    }
}
