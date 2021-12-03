<?php
namespace PHPeacock\Framework\Exceptions;

use PHPeacock\Framework\Exceptions\Error\CompileErrorException;
use PHPeacock\Framework\Exceptions\Error\CompileWarningException;
use PHPeacock\Framework\Exceptions\Error\CoreErrorException;
use PHPeacock\Framework\Exceptions\Error\CoreWarningException;
use PHPeacock\Framework\Exceptions\Error\DeprecatedException;
use PHPeacock\Framework\Exceptions\Error\ErrorException;
use PHPeacock\Framework\Exceptions\Error\NoticeException;
use PHPeacock\Framework\Exceptions\Error\ParseException;
use PHPeacock\Framework\Exceptions\Error\RecoverableErrorException;
use PHPeacock\Framework\Exceptions\Error\StrictException;
use PHPeacock\Framework\Exceptions\Error\UserDeprecatedException;
use PHPeacock\Framework\Exceptions\Error\UserErrorException;
use PHPeacock\Framework\Exceptions\Error\UserNoticeException;
use PHPeacock\Framework\Exceptions\Error\UserWarningException;
use PHPeacock\Framework\Exceptions\Error\WarningException;
use PHPeacock\Framework\HTTP\HTTPResponse;

/**
 * Error handler.
 */
class ErrorHandler
{
    /**
     * HTTP response.
     * @var HTTPResponse $httpResponse
     */

    /**
     * @param HTTPResponse $httpResponse HTTP response.
     */
    public function __construct(protected HTTPResponse $httpResponse)
    { }

    /**
     * Registers the `handleError` method as the error handler.
     * 
     * @return void
     */
    public function register(): void
    {
        set_error_handler(callback: [$this, 'handleError']);
    }

    /**
     * Handles an error.
     * 
     * @param int    $type     Error type.
     * @param string $message  Error message.
     * @param string $filename Error filename.
     * @param int    $line     Error line.
     * 
     * @return void
     */
    public function handleError(int $type, string $message, string $filename, int $line): void
    {
        match ($type)
        {
            E_ERROR             => throw new ErrorException(message: $message, filename: $filename, line: $line),
            E_WARNING           => throw new WarningException(message: $message, filename: $filename, line: $line),
            E_PARSE             => throw new ParseException(message: $message, filename: $filename, line: $line),
            E_NOTICE            => throw new NoticeException(message: $message, filename: $filename, line: $line),
            E_CORE_ERROR        => throw new CoreErrorException(message: $message, filename: $filename, line: $line),
            E_CORE_WARNING      => throw new CoreWarningException(message: $message, filename: $filename, line: $line),
            E_COMPILE_ERROR     => throw new CompileErrorException(message: $message, filename: $filename, line: $line),
            E_COMPILE_WARNING   => throw new CompileWarningException(message: $message, filename: $filename, line: $line),
            E_USER_ERROR        => throw new UserErrorException(message: $message, filename: $filename, line: $line),
            E_USER_WARNING      => throw new UserWarningException(message: $message, filename: $filename, line: $line),
            E_USER_NOTICE       => throw new UserNoticeException(message: $message, filename: $filename, line: $line),
            E_STRICT            => throw new StrictException(message: $message, filename: $filename, line: $line),
            E_RECOVERABLE_ERROR => throw new RecoverableErrorException(message: $message, filename: $filename, line: $line),
            E_DEPRECATED        => throw new DeprecatedException(message: $message, filename: $filename, line: $line),
            E_USER_DEPRECATED   => throw new UserDeprecatedException(message: $message, filename: $filename, line: $line),
        };
    }
}
