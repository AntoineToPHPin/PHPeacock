<?php
namespace PHPeacock\Framework\Exceptions\Error;

/**
 * Error exception for E_COMPILE_ERROR type.
 */
class CompileErrorException extends Error
{
    /**
     * @param string $message  Error message.
     * @param string $filename Error filename.
     * @param int    $line     Error line.
     */
    public function __construct(string $message, string $filename, int $line)
    {
        parent::__construct(message: $message, type: E_COMPILE_ERROR, filename: $filename, line: $line);
    }
}
