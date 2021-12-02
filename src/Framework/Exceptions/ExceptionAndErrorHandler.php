<?php
namespace PHPeacock\Framework\Exceptions;

use PHPeacock\Framework\HTTP\HTTPResponse;

/**
 * Exception and error handler.
 */
class ExceptionAndErrorHandler
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
     * Registers the `handleExceptionOrError` method as the exception handler.
     * 
     * @return void
     */
    public function register(): void
    {
        set_exception_handler(callback: [$this, 'handleExceptionOrError']);
    }

    /**
     * Handles an exception or an error.
     * 
     * @param Throwable $throwable Exception or error.
     * 
     * @return void
     */
    public function handleExceptionOrError(\Throwable $throwable): void
    {
        error_log(message: (string) $throwable);
        $this->httpResponse->redirect500();
    }
}
