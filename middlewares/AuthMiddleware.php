<?php
use Holded\Middleware;

class AuthMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        if(!$this->auth->isUserLoggedIn()){
            $this->flash->addMessage('error', 'Please Sign In before proceding.');
			return $response->withRedirect($this->router->pathFor('auth.signin'));
        }
        $response = $next($request, $response);
        return $response;
    }
}