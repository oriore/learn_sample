<?php

declare(strict_types=1);

use App\Application\Controllers\MysqlController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->group('/mysql', function (Group $group) {
        $group->get('', MysqlController::class . ':index');
        $group->post('', MysqlController::class . ':injection');
        $group->get('/fix', MysqlController::class . ':fix');
        $group->post('/fix', MysqlController::class . ':injectionFix');
    });
};
