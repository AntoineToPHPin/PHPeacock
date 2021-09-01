<?php
namespace PHPeacock\Framework\HTTP;

/**
 * HTTP request.
 */
class HTTPRequest
{
    /**
     * HTTP request method.
     * @var string $method
     */
    protected string $method;

    /**
     * HTTP GET variables.
     * @var array $getVariables
     */
    protected array $getVariables;

    /**
     * HTTP POST variables.
     * @var array $postVariables
     */
    protected array $postVariables;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->getVariables = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING) ?? [];
        $this->postVariables = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING) ?? [];
    }

    /**
     * Returns the HTTP request method.
     * 
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Returns the HTTP GET variables.
     * 
     * @return array
     */
    public function getGetVariables(): array
    {
        return $this->getVariables;
    }

    /**
     * Returns a HTTP GET variable by its name.
     * 
     * @param string $name GET variable name.
     * 
     * @return string
     */
    public function getGetVariableByName(string $name): string
    {
        return $this->getVariables[$name] ?? '';
    }

    /**
     * Adds a HTTP GET variable.
     * 
     * @param string $name  GET variable name.
     * @param string $value GET variable value.
     * 
     * @return void
     */
    public function addGetVariable(string $name, string $value): void
    {
        $this->getVariables[$name] = $value;
    }

    /**
     * Returns the HTTP POST variables.
     * 
     * @return array
     */
    public function getPostVariables(): array
    {
        return $this->postVariables;
    }

    /**
     * Returns a HTTP POST variable by its name.
     * 
     * @param string $name POST variable name.
     * 
     * @return string
     */
    public function getPostVariableByName(string $name): string
    {
        return $this->postVariables[$name] ?? '';
    }

    /**
     * Adds a HTTP POST variable.
     * 
     * @param string $name  POST variable name.
     * @param string $value POST variable value.
     * 
     * @return void
     */
    public function addPostVariable(string $name, string $value): void
    {
        $this->postVariables[$name] = $value;
    }
}
