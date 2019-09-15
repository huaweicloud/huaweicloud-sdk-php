<?php
namespace autoscaling\v1\service;

use autoscaling\v1\client\ASV1Client;
use core\auth\AuthAkSkRequest;
use core\common\HttpRequest;
use core\util\Constants;

use Exception;


class ScalingLogService {

    static private $instance;

    static public function getInstance(){
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getLogList(array $req, ASV1Client $asClient)
    {
        $authAkSkRequest = new AuthAkSkRequest();
        $authAkSkRequest->setMethod(Constants::HTTP_METHOD_GET);
        if(empty($req['scaling_group_id'])){
            throw new Exception("Please configure your scaling_group_id");
        }
        $authAkSkRequest->setUri('/autoscaling-api/v1/'.$asClient->getConfig()['project_id'].'/scaling_activity_log/'.$req['scaling_group_id']);
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