<?php
class AuthService{
    protected $container;
    
    // constructor receives container instance
    public function __construct($container) {
        $this->container    = $container;
        $this->model        = $container->mongo->users;
        $this->user         = $this->getCurrentUser();
    }

    public function isUserLoggedIn(){
        return !empty($this->getCurrentUser());
    }

    public function login($userFields){
        $record = $this->model->findOne([
            'username' => $userFields['username']
        ]);
        $passwordIsOK = ( $record['password'] == sha1($userFields['password']) );
        if($passwordIsOK){
            if(empty($_SESSION['user']))
                $_SESSION['user'] = $record;
        }
        return $passwordIsOK;
    }

    public function getCurrentUser(){
        return $_SESSION['user'];
    }

    public function userExists($username){
        return $this->model->count(['username' => $username]) > 0;
    }

    public function createUser($userFields){
        return $this->model->insertOne([
            'username' => $userFields['username'],
            'password' => sha1($userFields['password'])
        ]);
    }
}