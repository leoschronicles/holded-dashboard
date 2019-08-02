<?php
namespace Api\v1;

use Holded\BaseController;

class DashboardController extends BaseController{
    function index($request, $response, $args){
        $currentUser = $this->auth->user;
        $userCollection = $this->mongo->users;
        
        $dashboardData = $userCollection->findOne(
            ['username'     => $currentUser->username],
            ['projection'   => ['dashboard' => 1, '_id' => 0]]
        );
        return $response->withJson($dashboardData['dashboard'], 200);
    }

    function update($request, $response, $args){
        $body = $request->getParsedBody();
        $currentUser = $this->auth->user;

        $userCollection = $this->mongo->users;
        
        $userCollection->updateOne(
            ['username' => $currentUser->username],
            ['$set' => ['dashboard' => $body]]
        );
        return $response->withJson([], 200);
    }
}