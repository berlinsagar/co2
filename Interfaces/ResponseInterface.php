<?php

namespace Interfaces;

interface ResponseInterface
{

    public function getBody(): string;

    public function getCode(): string;

    public function getResponseType(): string;

}
