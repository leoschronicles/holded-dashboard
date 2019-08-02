<?php
use \Holded\BaseController;

class HomeController extends BaseController
{
  public function index($request, $response, $args) {
    return $response->withRedirect($this->router->pathFor('auth.signin'));
  }
}
