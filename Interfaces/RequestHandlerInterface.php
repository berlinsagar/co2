<?php

namespace Interfaces;

use Services\Application;
use Services\Request as ServicesRequest;

interface RequestHandlerInterface
{

    public function handleRequest(Application $application, ServicesRequest $request): ResponseInterface;

}
