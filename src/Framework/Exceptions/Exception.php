<?php
namespace PHPeacock\Framework\Exceptions;

/**
 * Abstract exception with no optional message.
 */
abstract class Exception extends \Exception
{
    /**
     * @param string         $message  Exception message.
     * @param int            $code     Exception code.
     * @param Throwable|null $previous Previous exception or error.
     */
    public function __construct(string $message, int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(message: $message, code: $code, previous: $previous);
    }
}
