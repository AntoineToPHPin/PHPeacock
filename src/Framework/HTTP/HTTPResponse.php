<?php
namespace PHPeacock\Framework\HTTP;

/**
 * HTTP response.
 */
class HTTPResponse
{
    /**
     * Website base URL.
     * @var string $baseURL
     */

    /**
     * Website 404 path.
     * @var string $path404
     */

    /**
     * Website 500 path.
     * @var string $path500
     */

    /**
     * @param string $baseURL Website base URL.
     * @param string $path404 Website 404 path.
     * @param string $path500 Website 500 path.
     */
    public function __construct(
        protected string $baseURL,
        protected string $path404,
        protected string $path500,
    )
    { }

    /**
     * Sets the HTTP status code.
     * 
     * @param int $code HTTP status code.
     * 
     * @return void
     */
    public function setHTTPStatusCode(int $code): void
    {
        http_response_code(response_code: $code);
    }

    /**
     * Redirects to a different path.
     * 
     * @param string $requestURI     Request URI.
     * @param int    $httpStatusCode HTTP status code.
     * 
     * @return void
     */
    public function redirect(string $requestURI, int $httpStatusCode = 303): void
    {
        header('Location: ' . $this->getBaseURL() . $requestURI, response_code: $httpStatusCode);
        exit;
    }

    /**
     * Redirects to the 404 path.
     * 
     * @return void
     */
    public function redirect404(): void
    {
        $this->redirect(requestURI: $this->getPath404());
    }

    /**
     * Redirects to the 500 path.
     * 
     * @return void
     */
    public function redirect500(): void
    {
        $this->redirect(requestURI: $this->getPath500());
    }

    /**
     * Sends an HTTP response to the browser.
     * 
     * @param string $html           HTML source.
     * @param int    $httpStatusCode HTTP status code.
     * 
     * @return void
     */
    public function send(string $html, int $httpStatusCode = 200): void
    {
        $this->setHTTPStatusCode(code: $httpStatusCode);
        exit($html);
    }

    /**
     * Returns the baseURL property.
     * 
     * @return string
     */
    public function getBaseURL(): string
    {
        return $this->baseURL;
    }

    /**
     * Returns the path404 property.
     * 
     * @return string
     */
    public function getPath404(): string
    {
        return $this->path404;
    }

    /**
     * Returns the path500 property.
     * 
     * @return string
     */
    public function getPath500(): string
    {
        return $this->path500;
    }
}
