<?php
namespace PHPeacock\Framework\DOM\XML;

use PHPeacock\Framework\DOM\DOMAttributeCollection;

/**
 * XML attributes.
 */
class XMLAttributeCollection extends DOMAttributeCollection
{
    /**
     * @param XMLAttribute $xmlAttributes,... XML attributes to add.
     */
    public function __construct(XMLAttribute ...$xmlAttributes)
    {
        parent::__construct(...$xmlAttributes);
    }

    /**
     * Adds the XML attribute to the collection.
     * 
     * @param XMLAttribute $xmlAttribute XML attribute to add.
     * 
     * @return self
     */
    public function attach(XMLAttribute $xmlAttribute): self
    {
        $this->elements->attach(object: $xmlAttribute);
        return $this;
    }

    /**
     * Removes the XML attribute from the collection.
     * 
     * @param XMLAttribute $xmlAttribute XML attribute to remove.
     * 
     * @return self
     */
    public function detach(XMLAttribute $xmlAttribute): self
    {
        $this->elements->detach(object: $xmlAttribute);
        return $this;
    }
}
