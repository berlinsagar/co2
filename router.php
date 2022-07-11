<?php

error_reporting( E_ALL ^ E_STRICT );

use Services\DBService;
use Services\RecordFinderService;
use Services\RecordAddService;
use Services\Application;
use Services\Request;

if (preg_match('/\.(?:png|jpg|jpeg|gif)$/', $_SERVER['REQUEST_URI'])) {

    return false;    // serve the requested resource as-is.
} else {

    require_once './routes.php';
    require_once './config.php';
    require_once './Services/DBService.php';
    require_once './Services/RecordFinderService.php';
    require_once './Services/RecordAddService.php';
    require_once './Services/Application.php';
    require_once './Services/Request.php';
    require_once './Utilities/Utilities.php';

    require_once './Interfaces/RequestHandlerInterface.php';
    require_once './Interfaces/ResponseInterface.php';

    require_once './Responses/ErrorResponse.php';
    require_once './Responses/SensorRecordResponse.php';
    require_once './Api/V1/Requests/SensorHandler.php';

    function bootstrap($config, $routes)
    {
        $app = new Application();

        $app->setDBService(
            new DBService(
                $config['db']['host_address'],
                $config['db']['db_name'],
                $config['db']['username'],
                $config['db']['password']
            )
        );
        $request = new Request();
        $request->setMethod(strtolower($_SERVER['REQUEST_METHOD']));
        $request->setQueryParams($_GET);
        if (strtolower($_SERVER['REQUEST_METHOD']) === 'post') {
            $data = json_decode(file_get_contents("php://input"), true);

            if (empty($data)) {
                http_response_code(400);
                header('Content-Type:' . 'application/json');
                echo (new ErrorResponse(400, 'Bad Request, please send data to update.'))->getBody();
                die;
            }
            $request->setBody($data);
        }
        $foundHandler = false;
        foreach ($routes as $pathRegex => $handlerClassName) {
            $urlParams = array();
            if (preg_match($pathRegex, $_SERVER['REQUEST_URI'], $urlParams)) {
                $foundHandler = true;
                array_shift($urlParams);
                $request->setUrlParams($urlParams);
                if (strtolower($_SERVER['REQUEST_METHOD']) === 'post') {
                    $app->setRecordAddService(new RecordAddService($app->getDBService()));
                } else {
                    $app->setRecordFinderService(new RecordFinderService($app->getDBService()));
                }
                $handler = new $handlerClassName();
                $response = $handler->handleRequest($app, $request);
                http_response_code($response->getCode());
                header('Content-Type:' . $response->getResponseType());
                echo $response->getBody();
                break;
            }
        }
        if ($foundHandler === false) {
            http_response_code(404);
            header('Content-Type:' . 'application/json');
            echo (new ErrorResponse(404, 'Invalid API Endpoint'))->getBody();
        }
    }

    bootstrap($_APP_CONFIG, $ROUTES);
}
