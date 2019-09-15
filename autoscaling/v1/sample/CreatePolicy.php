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
    $response = $asClient->createPolicy([
        "body" => [
            "scaling_policy_name" => "as-policy-7a75",
            "scaling_policy_action" => [
                "operation" => "ADD",
                "instance_number" => 1
            ],
            "cool_down_time" => 900,
            "scheduled_policy" => [
                "launch_time" => "16:00",
                "recurrence_type" => "Daily",
                "start_time" => "2015-12-14T03:34Z",
                "end_time" => "2015-12-27T03:34Z"
            ],
            "scaling_policy_type" => "RECURRENCE",
            "scaling_group_id" => "5bc3aa02-b83e-454c-aba1-4d2095c68f8b"
        ]
    ]);
    if ($response->getStatus() == 200) {
        //成功时业务逻辑
        echo "success";
    } else {
        //失败时业务逻辑
        throw new Exception ("createPolicy is failed");
    }
    
} catch (Exception $e) {
    //捕获异常，例如记录日志等操作
    echo $e->getMessage();
}
