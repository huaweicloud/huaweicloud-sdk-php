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
    $response = $asClient->deleteGroup([
        'scaling_group_id'=>'a8327883-6b07-4497-9c61-68d03ee193a1',
        'query'=>[
            'force_delete'=>'yes'
        ]
    ]);
    if ($response->getStatus() == 204) {
        //成功时业务逻辑
        echo "success";
    } else {
        //失败时业务逻辑
        throw new Exception("deleteConfiguration is failed");
    }
    
} catch (Exception $e) {
    //捕获异常，例如记录日志等操作
    echo $e->getMessage();
}


