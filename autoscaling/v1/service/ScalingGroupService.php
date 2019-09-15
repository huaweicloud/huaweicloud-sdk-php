<?php
namespace autoscaling\v1\service;

use autoscaling\v1\client\ASV1Client;
use core\auth\AuthAkSkRequest;
use core\common\HttpRequest;
use core\util\Constants;
use Exception;

class ScalingGroupService {

    static private $instance;

    static public function getInstance(){
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getGroupList(array $req, ASV1Client $asClient)
    {
        $authAkSkRequest = new AuthAkSkRequest();
        $authAkSkRequest->setMethod(Constants::HTTP_METHOD_GET);
        $authAkSkRequest->setUri('/autoscaling-api/v1/'.$asClient->getConfig()['project_id'].'/scaling_group');
        $authAkSkRequest->setHost($asClient->getConfig()['endpoint']);
        if(!empty($req['query'])){
            $authAkSkRequest->setQuery($req['query']);
        }
        $authAkSkRequest->sign($asClient);
        $authAkSkRequest->setRequestUrl();

        $response = httpRequest::http($authAkSkRequest->getRequestUrl(), $authAkSkRequest->getBody(),
            $authAkSkRequest->getMethod(), $authAkSkRequest->getHeaders(),$authAkSkRequest->getQuery(), $asClient->getConfig());
        return $response;
    }

    public function createGroup(array $req, ASV1Client $asClient)
    {
        $authAkSkRequest = new AuthAkSkRequest();
        $authAkSkRequest->setMethod(Constants::HTTP_METHOD_POST);
        $authAkSkRequest->setUri('/autoscaling-api/v1/'.$asClient->getConfig()['project_id'].'/scaling_group');
        $authAkSkRequest->setHeaders(array('Content-Type'=>'application/json'));
        $authAkSkRequest->setHost($asClient->getConfig()['endpoint']);
        if(empty($req['body'])){
            throw new Exception("Please build your request body");
        }
        $authAkSkRequest->setBody(json_encode($req['body']));
        $authAkSkRequest->sign($asClient);
        $authAkSkRequest->setRequestUrl();

        $response = httpRequest::http($authAkSkRequest->getRequestUrl(), $authAkSkRequest->getBody(),
            $authAkSkRequest->getMethod(), $authAkSkRequest->getHeaders(),$authAkSkRequest->getQuery(), $asClient->getConfig());
        return $response;
    }
    
    public function updateGroup(array $req, ASV1Client $asClient)
    {
        $authAkSkRequest = new AuthAkSkRequest();
        $authAkSkRequest->setMethod(Constants::HTTP_METHOD_PUT);
        if(empty($req['scaling_group_id'])){
            throw new Exception("Please configure your scaling_group_id");
        }
        $authAkSkRequest->setUri('/autoscaling-api/v1/'.$asClient->getConfig()['project_id'].'/scaling_group/'.$req['scaling_group_id']);
        $authAkSkRequest->setHeaders(array('Content-Type'=>'application/json'));
        $authAkSkRequest->setHost($asClient->getConfig()['endpoint']);
        if(empty($req['body'])){
            throw new Exception("Please build your request body");
        }
        $authAkSkRequest->setBody(json_encode($req['body']));
        $authAkSkRequest->sign($asClient);
        $authAkSkRequest->setRequestUrl();

        $response = httpRequest::http($authAkSkRequest->getRequestUrl(), $authAkSkRequest->getBody(),
            $authAkSkRequest->getMethod(), $authAkSkRequest->getHeaders(),$authAkSkRequest->getQuery(), $asClient->getConfig());
        return $response;
    }

    public function deleteGroup(array $req, ASV1Client $asClient)
    {
        $authAkSkRequest = new AuthAkSkRequest();
        $authAkSkRequest->setMethod(Constants::HTTP_METHOD_DELETE);
        if(empty($req['scaling_group_id'])){
            throw new Exception("Please configure your scaling_group_id");
        }
        $authAkSkRequest->setUri('/autoscaling-api/v1/'.$asClient->getConfig()['project_id'].'/scaling_group/'. $req['scaling_group_id']);
        $authAkSkRequest->setHost($asClient->getConfig()['endpoint']);
        if(!empty($req['query'])){
            $authAkSkRequest->setQuery($req['query']);
        }
        $authAkSkRequest->sign($asClient);
        $authAkSkRequest->setRequestUrl();

        $response = httpRequest::http($authAkSkRequest->getRequestUrl(), $authAkSkRequest->getBody(),
            $authAkSkRequest->getMethod(), $authAkSkRequest->getHeaders(),$authAkSkRequest->getQuery(), $asClient->getConfig());
        return $response;
    }

    public function actionGroup(array $req, ASV1Client $asClient)
    {
        $authAkSkRequest = new AuthAkSkRequest();
        $authAkSkRequest->setMethod(Constants::HTTP_METHOD_POST);
        if(empty($req['scaling_group_id'])){
            throw new Exception("Please configure your scaling_group_id");
        }
        $authAkSkRequest->setUri('/autoscaling-api/v1/'.$asClient->getConfig()['project_id'].'/scaling_group/'.$req['scaling_group_id']. '/action');
        $authAkSkRequest->setHost($asClient->getConfig()['endpoint']);
        $authAkSkRequest->setHeaders(array('Content-Type'=>'application/json'));
        if(empty($req['body'])){
            throw new Exception("Please build your request body");
        }
        $authAkSkRequest->setBody(json_encode($req['body']));
        $authAkSkRequest->sign($asClient);
        $authAkSkRequest->setRequestUrl();

        $response = httpRequest::http($authAkSkRequest->getRequestUrl(), $authAkSkRequest->getBody(),
            $authAkSkRequest->getMethod(), $authAkSkRequest->getHeaders(),$authAkSkRequest->getQuery(), $asClient->getConfig());
        return $response;
    }
}