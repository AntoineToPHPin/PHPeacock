<?php
namespace PHPeacock\Framework\DOM\HTML;

use PHPeacock\Framework\DOM\DOMText;

/**
 * HTML text node.
 */
class HTMLText extends DOMText implements HTMLNode
{
    /**
     * @param string $text HTML node text.
     */
    public function __construct(protected string $text)
    { }
}
