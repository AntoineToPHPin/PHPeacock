<?php
namespace PHPeacock\Framework\Template;

use PHPeacock\Framework\DOM\HTML\HTMLDocument;
use PHPeacock\Framework\DOM\HTML\HTMLElementCollection;
use PHPeacock\Framework\HTTP\HTTPResponse;

/**
 * Abstract template.
 */
abstract class Template extends HTMLDocument
{
    /**
     * HTTP response.
     * @var HTTPResponse $httpResponse
     */

    /**
     * @param HTMLElementCollection $elements     Document elements.
     * @param HTTPResponse          $httpResponse HTTP response.
     */
    public function __construct(HTMLElementCollection $elements, protected HTTPResponse $httpResponse)
    {
        parent::__construct(elements: $elements);
    }

    /**
     * Displays the web page.
     * 
     * @return void
     */
    public function display(): void
    {
        $this->httpResponse->send(html: $this);
    }
}
