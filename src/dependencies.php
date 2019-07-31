<?php

use Slim\App;

return function (App $app) {
    $container = $app->getContainer();

    $container['project_root'] = realpath(__DIR__ . '/../');

    // view renderer
    $container['renderer'] = function ($c) {
        $settings = $c->get('settings')['renderer'];
        return new \Slim\Views\PhpRenderer($settings['template_path']);
    };

    // monolog
    $container['logger'] = function ($c) {
        $settings = $c->get('settings')['logger'];
        $logger = new \Monolog\Logger($settings['name']);
        $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
        $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
        return $logger;
    };

    // Flash
    $container['flash'] = function () {
        return new \Slim\Flash\Messages();
    };

    // auth
    $container['auth'] = function ($c) {
        return new AuthService($c);
    };
};
