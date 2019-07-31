<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    // Authenticated routes
    $app->group('', function() {
        $this->get('/account/signout', 'AuthController:getLogOut')->setName('auth.logout');
        $this->get('/account/password/change', 'PasswordController:getChangePassword')->setName('auth.password.change');
    }); //->add(new AuthMiddleware($container));

    // Guest routes
    $app->group('', function(){
        $this->get('/[{name}]', 'HomeController:index')->setName('home');
        $this->post('/account/login', 'AuthController:postLogIn')->setName('auth.login');
        $this->get('/account/signin', 'AuthController:getSignIn')->setName('auth.signin');
    });
};
