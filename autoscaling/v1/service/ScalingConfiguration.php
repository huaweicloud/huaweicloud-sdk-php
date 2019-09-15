<?php
namespace autoscaling\v1\service;

use autoscaling\v1\client\ASV1Client;

use core\auth\AuthAkSkRequest;
use core\common\HttpRequest;
use core\util\Constants;
use Exception;

class ScalingConfiguration {

    static private $instance;

    static public function getInstance(){
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function createConfiguration(array $req, ASV1Client $asClient)
    {
        $authAkSkRequest = new AuthAkSkRequest();
        $authAkSkRequest->setMethod(Constants::HTTP_METHOD_POST);
        $authAkSkRequest->setUri('/autoscaling-api/v1/'.$asClient->getConfig()['project_id'].'/scaling_configuration');
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

    public function getConfigurationList(array $req, ASV1Client $asClient)
    {
        $authAkSkRequest = new AuthAkSkRequest();
        $authAkSkRequest->setMethod(Constants::HTTP_METHOD_GET);
        $authAkSkRequest->setUri('/autoscaling-api/v1/'.$asClient->getConfig()['project_id'].'/scaling_configuration');
        $authAkSkRequest->setHeaders(array('Content-Type'=>'application/json'));
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

    public function deleteConfiguration(array $req, ASV1Client $asClient)
    {
        $authAkSkRequest = new AuthAkSkRequest();
        $authAkSkRequest->setMethod(Constants::HTTP_METHOD_DELETE);
        if(empty($req['scaling_configuration_id'])){
            throw new Exception("Please configure your scaling_configuration_id");
        }
        $authAkSkRequest->setUri('/autoscaling-api/v1/'.$asClient->getConfig()['project_id'].'/scaling_configuration/'.$req['scaling_configuration_id']);
        $authAkSkRequest->setHeaders(array('Content-Type'=>'application/json'));
        $authAkSkRequest->setHost($asClient->getConfig()['endpoint']);
        $authAkSkRequest->sign($asClient);
        $authAkSkRequest->setRequestUrl();

        $response = httpRequest::http($authAkSkRequest->getRequestUrl(), $authAkSkRequest->getBody(),
            $authAkSkRequest->getMethod(), $authAkSkRequest->getHeaders(),$authAkSkRequest->getQuery(), $asClient->getConfig());
        return $response;
    }
}