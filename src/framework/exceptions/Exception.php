<?php
namespace PHPeacock\Framework\Exceptions;

/**
 * Exception with no optional message.
 */
class Exception extends \Exception
{
    public function __construct(string $message, int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(message: $message, code: $code, previous: $previous);
    }
}
