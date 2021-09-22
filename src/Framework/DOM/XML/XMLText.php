<?php
namespace PHPeacock\Framework\DOM\XML;

use PHPeacock\Framework\DOM\DOMText;

/**
 * XML text node.
 */
class XMLText extends DOMText implements XMLNode
{
    /**
     * @param string $text XML node text.
     */
    public function __construct(protected string $text)
    { }
}
