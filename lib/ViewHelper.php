<?php
namespace Holded;
use Psr\Container\ContainerInterface;

class PartialNotFoundError extends \RuntimeException{

}

class ViewHelper{
    public function __construct(ContainerInterface $container){
        $this->container = $container;
        $this->root = $this->container['project_root'];
    }

    public function loadPartial($path, $params){
        $fullpath = $this->root . "/templates/partials/_$path.phtml";
        if(!file_exists($fullpath)){
            throw new PartialNotFoundError("Partial view at '$fullpath' not found");
        }
        $this->protectedIncludeScope($fullpath, $params);
    }

    protected function protectedIncludeScope ($template, $data) {
        extract($data);
        include $template;
    }
}