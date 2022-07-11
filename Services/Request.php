<?php

namespace Services;

use Utilities\Utility;

class Request
{

    protected $queryParams;
    protected $method;
    protected $urlParams;
    protected $body;

    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod(string $method)
    {
        $this->method = $method;
    }

    public function getQueryParam(string $paramName, $default = null)
    {
        return $_GET[$paramName] ?? $default;
    }

    public function setQueryParams(array $queryParams)
    {
        $this->queryParams = filter_var_array($queryParams);
    }

    public function setBody(array $requestBody)
    {
        $this->body = Utility::clean($requestBody);
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getUrlParams(): array
    {
        return $this->urlParams;
    }

    public function getUrlParam(int $paramIndex)
    {
        return $this->urlParams[$paramIndex];
    }

    public function setUrlParams(array $urlParams)
    {
        $this->urlParams = Utility::clean($urlParams);
    }

}
