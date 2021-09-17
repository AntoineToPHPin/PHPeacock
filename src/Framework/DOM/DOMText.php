<?php
namespace PHPeacock\Framework\DOM;

use PHPeacock\Framework\Exceptions\DOM\DOMTextException;

/**
 * Abstract DOM Text node.
 */
abstract class DOMText implements DOMNode
{
    /**
     * Node text.
     * @var string $text
     */
    protected string $text;

    /**
     * {@inheritDoc}
     */
    public function createNode(): \DOMText
    {
        $domDocument = new \DOMDocument();

        try
        {
            $domTextNode = $domDocument->createTextNode(data: $this->text);
        }
        catch (\DOMException $exception)
        {
            throw new DOMTextException(
                message: 'An error occurs when creating this text node.',
                previous: $exception
            );
        }

        return $domTextNode;
    }

    /**
     * Returns the text property.
     * 
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * Sets the text property.
     * 
     * @param string $text Node text.
     * 
     * @return void
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }
}
