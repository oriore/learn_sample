<?php

declare(strict_types=1);

use App\Application\Middleware\SessionMiddleware;
use Slim\Views\{ Twig, TwigMiddleware};
use Slim\App;

return function (App $app) {
    $app->add(SessionMiddleware::class);
    $app->add(TwigMiddleware::createFromContainer($app, Twig::class));
};
