<?php
namespace PHPeacock\Framework\DOM\XML;

use PHPeacock\Framework\DOM\DOMNodeCollection;

/**
 * Collection of XML nodes.
 */
class XMLNodeCollection extends DOMNodeCollection
{
    /**
     * @param XMLNode $xmlNodes,... XML nodes to add.
     */
    public function __construct(XMLNode ...$xmlNodes)
    {
        parent::__construct(...$xmlNodes);
    }

    /**
     * Adds the XML node to the collection.
     * 
     * @param XMLNode $xmlNode XML node to add.
     * 
     * @return self
     */
    public function attach(XMLNode $xmlNode): self
    {
        $this->elements->attach(object: $xmlNode);
        return $this;
    }

    /**
     * Removes the XML node from the collection.
     * 
     * @param XMLNode $xmlNode XML node to remove.
     * 
     * @return self
     */
    public function detach(XMLNode $xmlNode): self
    {
        $this->elements->detach(object: $xmlNode);
        return $this;
    }
}
