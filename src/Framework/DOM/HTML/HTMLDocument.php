<?php
namespace PHPeacock\Framework\DOM\HTML;

use PHPeacock\Framework\DOM\DOMDocument;
use PHPeacock\Framework\Exceptions\DOM\DOMDocumentException;
use PHPeacock\Framework\Exceptions\DOM\DOMNodeException;

/**
 * Abstract HTML document.
 */
abstract class HTMLDocument extends DOMDocument
{
    /**
     * @param HTMLElementCollection $elements Document elements.
     */
    public function __construct(HTMLElementCollection $elements)
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

        $domDocument->loadHTML(
            source: '<!DOCTYPE html>' . $domDocument->saveXML(node: $domDocument->documentElement),
            options: LIBXML_HTML_NOIMPLIED|LIBXML_NOERROR
        );

        return $domDocument->saveHTML();
    }
}
