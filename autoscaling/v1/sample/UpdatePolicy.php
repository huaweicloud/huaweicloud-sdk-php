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

//修改弹性伸缩策略
try{
    $response = $asClient->updatePolicy([
        'scaling_policy_id' => '0h327883-324n-4dzd-9c61-68d03ee191dd',
        'body' => [
            "scaling_policy_type" => "RECURRENCE",
            "scaling_policy_name" => "policy_01",
            "scheduled_policy" => [
                "launch_time" => "16:00",
                "recurrence_type" => "Daily",
                "end_time" => "2016-02-08T17:31Z",
                "start_time" => "2016-01-08T17:31Z"
            ],
            "scaling_policy_action" => [
                "operation" => "SET",
                "instance_number" => 2
            ]
        ]
    ]);
    if ($response->getStatus() == 200) {
        //成功时业务逻辑
        echo "success";
    } else {
        //失败时业务逻辑
        throw new Exception ("updatePolicy is failed");
    }
} catch (Exception $e) {
    //捕获异常，例如记录日志等操作
    echo $e->getMessage();
}



