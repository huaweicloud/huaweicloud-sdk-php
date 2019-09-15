<?php
namespace autoscaling\v2\service;

use autoscaling\v2\client\ASV2Client;
use core\auth\AuthAkSkRequest;
use core\common\HttpRequest;
use core\util\Constants;

use Exception;


class ScalingPolicyService {

    static private $instance;

    static public function getInstance(){
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function createPolicy(array $req, ASV2Client $asClient)
    {
        $authAkSkRequest = new AuthAkSkRequest();
        $authAkSkRequest->setMethod(Constants::HTTP_METHOD_POST);
        $authAkSkRequest->setUri('/autoscaling-api/v2/'.$asClient->getConfig()['project_id'].'/scaling_policy');
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

    public function updatePolicy(array $req, ASV2Client $asClient)
    {
        $authAkSkRequest = new AuthAkSkRequest();
        $authAkSkRequest->setMethod(Constants::HTTP_METHOD_PUT);
         if(empty($req['scaling_policy_id'])){
             throw new Exception("Please configure your scaling_policy_id");
         }
        $authAkSkRequest->setUri('/autoscaling-api/v2/'.$asClient->getConfig()['project_id'].'/scaling_policy/'.$req['scaling_policy_id']);
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

    public function getPolicyList(array $req, ASV2Client $asClient)
    {
        $authAkSkRequest = new AuthAkSkRequest();
        $authAkSkRequest->setMethod(Constants::HTTP_METHOD_GET);
        if(empty($req['scaling_resource_id'])){
            throw new Exception("Please configure your scaling_resource_id");
        }
        $authAkSkRequest->setUri('/autoscaling-api/v2/'.$asClient->getConfig()['project_id'].'/scaling_policy/'. $req['scaling_resource_id']. '/list');
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
}