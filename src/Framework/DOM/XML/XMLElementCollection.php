<?php
namespace PHPeacock\Framework\DOM\XML;

use PHPeacock\Framework\DOM\DOMElementCollection;

/**
 * Collection of XML elements.
 */
class XMLElementCollection extends DOMElementCollection
{
    /**
     * @param XMLElement $xmlElements,... XML elements to add.
     */
    public function __construct(XMLElement ...$xmlElements)
    {
        parent::__construct(...$xmlElements);
    }

    /**
     * Adds the XML element to the collection.
     * 
     * @param XMLElement $xmlElement XML element to add.
     * 
     * @return self
     */
    public function attach(XMLElement $xmlElement): self
    {
        $this->elements->attach(object: $xmlElement);
        return $this;
    }

    /**
     * Removes the XML element from the collection.
     * 
     * @param XMLElement $xmlElement XML element to remove.
     * 
     * @return self
     */
    public function detach(XMLElement $xmlElement): self
    {
        $this->elements->detach(object: $xmlElement);
        return $this;
    }
}
