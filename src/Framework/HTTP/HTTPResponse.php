<?php
namespace PHPeacock\Framework\HTTP;

/**
 * HTTP response.
 */
class HTTPResponse
{
    /**
     * Website URL.
     * @var string $url
     */

    /**
     * @param string $url Website URL.
     */
    public function __construct(protected string $url)
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
     * Redirects to a different URL.
     * 
     * @param string $requestURI     Request URI.
     * @param int    $httpStatusCode HTTP status code.
     * 
     * @return void
     */
    public function redirect(string $requestURI, int $httpStatusCode = 303): void
    {
        header('Location: ' . $this->url . $requestURI, response_code: $httpStatusCode);
        exit;
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
     * Returns the url property.
     * 
     * @return string
     */
    public function getURL(): string
    {
        return $this->url;
    }

    /**
     * Sets the url property.
     * 
     * @param string $url Website URL.
     * 
     * @return void
     */
    public function setURL(string $url): void
    {
        $this->url = $url;
    }
}
