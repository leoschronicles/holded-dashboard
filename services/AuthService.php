<?php
class AuthService{
    protected $container;
    
    // constructor receives container instance
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function isUserLoggedIn(){

    }
}