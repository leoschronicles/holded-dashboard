<?php

use Slim\App;

return function (App $app) {
    $container = $app->getContainer();

    // Dashboard
    $app->group('/dashboard', function() {
        $this->get('', 'DashboardController:index')->setName('dashboard.index');
    })->add(new AuthMiddleware($container));

    // API (DASHBOARD)
    $app->group('/api/v1/dashboard', function() {
        $this->get('', "\\Api\\v1\\DashboardController:index");
        $this->put('', "\\Api\\v1\\DashboardController:update");
    })->add(new AuthMiddleware($container));

    // Guest routes
    $app->group('', function(){
        $this->get('/', 'HomeController:index')->setName('home');
        
        $this->post('/account/signin', 'AuthController:login')->setName('auth.login');
        $this->post('/account/signup', 'AuthController:register')->setName('auth.register');

        $this->get('/account/signin', 'AuthController:signIn')->setName('auth.signin');
        $this->get('/account/signup', 'AuthController:signUp')->setName('auth.signup');
    });
};
