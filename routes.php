<?php

use Api\V1\RequestsHandlers\SensorHandler;

$ROUTES = array(
    '/\/api\/v1\/sensors\/{?([^\/}]+)}?\/{?([^\/}]+)}?/i' => SensorHandler::class,
);
