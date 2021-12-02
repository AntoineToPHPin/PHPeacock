<?php
namespace PHPeacock\Framework\Exceptions\Error;

/**
 * Abstract error exception.
 */
abstract class Error extends \ErrorException
{
    /**
     * @param string $message  Error message.
     * @param string $filename Error filename.
     * @param int    $line     Error line.
     * @param int    $type     Error type.
     */
    public function __construct(string $message, string $filename, int $line, int $type)
    {
        parent::__construct(message: $message, severity: $type, filename: $filename, line: $line);
    }
}
