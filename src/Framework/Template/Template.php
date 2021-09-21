<?php
namespace PHPeacock\Framework\Template;

use PHPeacock\Framework\DOM\HTML\HTMLDocument;

/**
 * Abstract template.
 */
abstract class Template extends HTMLDocument
{
    /**
     * Displays the web page.
     * 
     * @return void
     */
    public function display(): void
    {
        echo $this;
    }
}
