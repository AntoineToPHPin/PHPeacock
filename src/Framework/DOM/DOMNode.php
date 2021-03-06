<?php
namespace PHPeacock\Framework\DOM;

/**
 * DOM node with the `createNode` method.
 */
interface DOMNode
{
    /**
     * Creates the node.
     * 
     * @throws DOMNodeException if an error occurs when creating the node.
     * 
     * @return \DOMNode
     */
    public function createNode(): \DOMNode;
}
