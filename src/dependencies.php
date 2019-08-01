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

    // MongoDB
    // Link: https://docs.mongodb.com/php-library/current/tutorial/crud/
    $container['mongo'] = function ($c) {
        $dbName = $c->get('settings')['db']['name'];
        
        $client = new MongoDB\Client();
        return $client->{$dbName};
    };

    // auth
    $container['auth'] = function ($c) {
        return new AuthService($c);
    };
    
};
