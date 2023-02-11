<?php

declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use App\Domain\User\UserRepositoryInterface;
use App\Infrastructure\Persistence\User\UserRepository;
use DI\ContainerBuilder;
use Illuminate\Database\Capsule\Manager;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;


$capsule = new \Illuminate\Database\Capsule\Manager;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $container) {
            $settings = $container->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        Twig::class => function (ContainerInterface $container) {
            $settings = $container->get(SettingsInterface::class);
            return Twig::create(__DIR__ . '/../templates', $settings->get('twig'));
        },
        Manager::class => function (ContainerInterface $container) {
            $settings = $container->get(SettingsInterface::class);
            $capsule = new Manager();
            $capsule->addConnection($settings->get('db'));
            $capsule->setAsGlobal();
            $capsule->bootEloquent();
        
            return $capsule;
        }
    ]);
};
