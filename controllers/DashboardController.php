<?php
use \Holded\BaseController;

class DashboardController extends BaseController
{
  public function index($request, $response, $args) {
    $container = $this->container;

    return $container->get('renderer')->render($response, 'index.phtml', $args);
  }
}
