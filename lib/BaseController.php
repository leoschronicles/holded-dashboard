<?php
namespace Holded;
use Psr\Container\ContainerInterface;

class BaseController{
    protected $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    protected function templateArgs($arg1 = []){
        return array_merge($arg1, [
            "container" => $this->container,
            "helper"    => new ViewHelper($this->container)
        ]);
    }
}