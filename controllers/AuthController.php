<?php
use \Holded\BaseController;

class AuthController extends BaseController
{
    /**
     * Pages
     */
    public function signIn($request, $response, $args)
    {
        if($this->auth->user){
            return $response->withRedirect($this->router->pathFor('dashboard.index'));
        }
        return $this->renderer->render($response, 'auth/sign_in.phtml', $this->templateArgs($args));
    }

    public function signUp($request, $response, $args)
    {
        if($this->auth->user){
            return $response->withRedirect($this->router->pathFor('dashboard.index'));
        }
        return $this->renderer->render($response, 'auth/sign_up.phtml', $this->templateArgs($args));
    }

    /**
     * Submit actions
     */
    public function login($request, $response, $args)
    {
        $userFields = $request->getParsedBody();
        $success = $this->auth->login($userFields);
        if(!$success){
            $this->flash->addMessage('error', 'User does not exist or password does not match');
            return $response->withRedirect($this->router->pathFor('auth.signin'));
        }

        return $response->withRedirect($this->router->pathFor('dashboard.index'));
    }

    public function register($request, $response, $args)
    {
        $userFields = $request->getParsedBody();

        $username = $userFields['username'];
        $password = $userFields['password'];
        $name = $userFields['name'];
        
        if(empty($username) || empty($password)){
            $this->flash->addMessage('error', 'Username and password must be provided');
            return $response->withRedirect($this->router->pathFor('auth.signup'));
        }

        if(empty($name)){
            $this->flash->addMessage('error', 'You must provide a name');
            return $response->withRedirect($this->router->pathFor('auth.signup'));
        }

        if($this->auth->userExists($username)){
            $this->flash->addMessage('error', 'User already exists');
            return $response->withRedirect($this->router->pathFor('auth.signup'));
        }

        if($userFields['password-confirmation'] != $userFields['password']){
            $this->flash->addMessage('error', 'Password fields do not match');
            return $response->withRedirect($this->router->pathFor('auth.signup'));
        }

        $result = $this->auth->createUser($userFields);
        
        $this->flash->addMessage('success', 'User created! Please, login');
        return $response->withRedirect($this->router->pathFor('auth.signin'));
    }
}
