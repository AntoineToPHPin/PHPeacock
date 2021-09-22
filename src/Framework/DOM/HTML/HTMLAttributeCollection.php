<?php
namespace PHPeacock\Framework\DOM\HTML;

use PHPeacock\Framework\DOM\DOMAttributeCollection;

/**
 * HTML attributes.
 */
class HTMLAttributeCollection extends DOMAttributeCollection
{
    /**
     * @param HTMLAttribute $htmlAttributes,... HTML attributes to add.
     */
    public function __construct(HTMLAttribute ...$htmlAttributes)
    {
        parent::__construct(...$htmlAttributes);
    }

    /**
     * Adds the HTML attribute to the collection.
     * 
     * @param HTMLAttribute $htmlAttribute HTML attribute to add.
     * 
     * @return self
     */
    public function attach(HTMLAttribute $htmlAttribute): self
    {
        $this->elements->attach(object: $htmlAttribute);
        return $this;
    }

    /**
     * Removes the HTML attribute from the collection.
     * 
     * @param HTMLAttribute $htmlAttribute HTML attribute to remove.
     * 
     * @return self
     */
    public function detach(HTMLAttribute $htmlAttribute): self
    {
        $this->elements->detach(object: $htmlAttribute);
        return $this;
    }
}
