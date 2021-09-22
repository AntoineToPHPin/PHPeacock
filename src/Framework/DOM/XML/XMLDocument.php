<?php
namespace PHPeacock\Framework\DOM\XML;

use PHPeacock\Framework\DOM\DOMDocument;
use PHPeacock\Framework\Exceptions\DOM\DOMDocumentException;
use PHPeacock\Framework\Exceptions\DOM\DOMNodeException;

/**
 * XML document.
 */
class XMLDocument extends DOMDocument
{
    /**
     * @param XMLElementCollection $elements Document elements.
     */
    public function __construct(XMLElementCollection $elements)
    {
        $this->elements = $elements;
    }

    /**
     * {@inheritDoc}
     */
    public function __toString(): string
    {
        $domDocument = new \DOMDocument();
        $domDocument->preserveWhiteSpace = false;
        $domDocument->formatOutput = true;

        foreach ($this->elements as $element)
        {
            try
            {
                $domDocument->appendChild(
                    node: $domDocument->importNode(
                        node: $element->createNode(),
                        deep: true,
                    )
                );
            }
            catch (DOMNodeException $exception)
            {
                throw new DOMDocumentException(
                    message: 'An error occurs when creating the child nodes.',
                    previous: $exception
                );
            }
        }
    
        return $domDocument->saveXML();
    }
}
