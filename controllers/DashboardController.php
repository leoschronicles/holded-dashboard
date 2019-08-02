<?php
use \Holded\BaseController;

class DashboardController extends BaseController
{
  /**
   * Pages
   */
  public function index($request, $response, $args) {
    return $this->renderer->render($response, 'dashboard.phtml', $this->templateArgs($args));
  }
}
