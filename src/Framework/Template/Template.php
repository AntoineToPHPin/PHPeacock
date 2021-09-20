<?php
namespace PHPeacock\Framework\Template;

use PHPeacock\Framework\DOM\HTML\HTMLDocument;

/**
 * Abstract template.
 */
abstract class Template extends HTMLDocument
{
    public function display(): void
    {
        echo $this;
    }
}
