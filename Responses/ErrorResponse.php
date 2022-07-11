<?php

use Interfaces\ResponseInterface;

class ErrorResponse implements ResponseInterface
{

    protected $code;
    protected $message;

    public function __construct(int $code, string $message)
    {
        $this->code = $code;
        $this->message = $message;
    }

    public function getBody(): string
    {
        return json_encode(
            array(
                'status_code' => $this->code,
                'message' => $this->message,
            )
        );
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getResponseType(): string
    {
        return 'application/json';
    }
}
