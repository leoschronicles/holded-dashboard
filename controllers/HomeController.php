<?php
use \Holded\BaseController;

class HomeController extends BaseController
{
  public function index($request, $response, $args) {
    $container = $this->container;
    return $container->get('renderer')->render($response, 'index.phtml', $this->templateArgs($args));
  }
}