<?php

use Interfaces\ResponseInterface;

class SensorRecordResponse implements ResponseInterface
{

    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getBody(): string
    {
        return json_encode($this->data);
    }

    public function getCode(): string
    {
        return 200;
    }

    public function getResponseType(): string
    {
        return 'application/json';
    }
}
