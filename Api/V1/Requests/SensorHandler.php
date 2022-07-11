<?php

namespace Api\V1\RequestsHandlers;

use SensorRecordResponse;
use ErrorResponse;
use Interfaces\RequestHandlerInterface;
use Interfaces\ResponseInterface;
use Services\Application;
use Services\Request;


class SensorHandler implements RequestHandlerInterface
{
    protected $getServiceNames = [
        'metrics',
        'alerts',
        'measurements',
        'status'
    ];

    protected $postServiceNames = [
        'measurements',
    ];

    protected $allowedMethods = [
        'get',
        'post',
    ];

    /**
     * @param Application $application
     * @param Request $request
     * @return ResponseInterface
     */
    public function handleRequest(Application $application, Request $request): ResponseInterface
    {

        $sensorID = $request->getUrlParam(0);
        $sensorService = $request->getUrlParam(1);

        if (!in_array($request->getMethod(), $this->allowedMethods)) {
            return new ErrorResponse(405, 'Method Not Allowed');
        }

        if ($request->getMethod() === 'get' && !in_array($sensorService, $this->getServiceNames)) {
            return new ErrorResponse(404, 'Invalid API Endpoint');
        }

        if ($request->getMethod() == 'post' && !in_array($sensorService, $this->postServiceNames)) {
            return new ErrorResponse(404, 'Invalid API Endpoint');
        }


        if ($sensorID === null) {
            return new ErrorResponse(400, sprintf('Bad Request', $sensorID));
        }


        if ($request->getMethod() === 'get') {
            $record = $application->getRecordFinderService()->findIdMapByService($sensorService, $sensorID);
            if (empty($record)) {
                return new ErrorResponse(404, sprintf('Record not found with UUID %s.', $sensorID));
            }
        } else {
            $record = $application->getRecordAddService()->execute($request);
            if (empty($record)) {
                return new ErrorResponse(404, sprintf('Record has not added with UUID: %s.', $sensorID));
            } elseif ($record['error'] === 'badRequest') {
                return new ErrorResponse(400, sprintf('Bad Request: %s', $record['message']));
            }
        }


        return new SensorRecordResponse($record);
    }


}
