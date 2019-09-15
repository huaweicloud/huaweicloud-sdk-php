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
    $response = $asClient->getInstanceList([
        'scaling_group_id' => 'scaling_group_id',
        'query' => [
            'life_cycle_state' => 'INSERVICE',
            'health_status' => 'INITIALIZING',
            'protect_from_scaling_down' => 'true',
            'start_number' => 0,
            'limit' => 30
        ]
    ]);
    if ($response->getStatus() == 200) {
        //成功时业务逻辑
        $data = $response->getData();
        $instanceList = $data['scaling_group_instances'];
        var_dump($instanceList);
    } else {
        //失败时业务逻辑
        var_dump($response);
        throw new Exception("getInstanceList is failed");
    }
} catch (Exception $e) {
    //捕获异常，例如记录日志等操作
    echo $e->getMessage();
}
