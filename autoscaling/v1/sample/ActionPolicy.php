<?php

use autoscaling\v1\client\ASV1Client;

require_once __DIR__ . '/../../../core/autoloader.php';

$asClient = new ASV1Client([
    'ak' => "your ak",
    'sk' => "your sk",
    'endpoint' => "your endpoint",
    'project_id' => "your project_id",
    'request_options' => [
        'debug' => false,//是否打印日志，false为关闭
        'verify' => false,//是否开启ssl验证，false为关闭
        'timeout' => 10,//CURLOPT_TIMEOUT
        'connect_timeout' => 10//CURLOPT_CONNECTTIMEOUT
    ]
]);

try{
    $response = $asClient->actionPolicy([
        'scaling_policy_id' => 'scaling_policy_id',
        'body' => [
            'action' => 'resume'
        ]
    ]);
    if ($response->getStatus() == 204) {
        //成功时业务逻辑
        echo "success";
    } else {
        //失败时业务逻辑
        throw new Exception("actionPolicy is failed");
    }
    
} catch (Exception $e) {
    //捕获异常，例如记录日志等操作
    echo $e->getMessage();
}

