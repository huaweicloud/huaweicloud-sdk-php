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


//修改弹性伸缩组
try{
    $response = $asClient->updateGroup([
        'scaling_group_id' => 'a8327883-6b07-4497-9c61-68d03ee193a1',
        'body' => [
            "scaling_group_name" => "group_1",
            "scaling_configuration_id" => "f8327883-6a07-4497-9a61-68c03e8e72a2",
            "enterprise_project_id" => "c92b1a5d-6f20-43f2-b1b7-7ce35e58e413",
            "desire_instance_number" => 1,
            "min_instance_number" => 1,
            "max_instance_number" => 3,
            "cool_down_time" => 200,
            "multi_az_priority_policy" => "PICK_FIRST"
        ]
    ]);
    if ($response->getStatus() == 200) {
        //成功时业务逻辑
        echo "success";
    } else {
        //失败时业务逻辑
        throw new Exception ("updateGroup is failed");
    }
} catch (Exception $e) {
    //捕获异常，例如记录日志等操作
    echo $e->getMessage();
}



