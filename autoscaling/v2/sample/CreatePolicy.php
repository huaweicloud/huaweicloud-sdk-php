<?php

use autoscaling\v2\client\ASV2Client;

require_once __DIR__ . '/../../../core/autoloader.php';

$asClient = new ASV2Client([
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

//创建弹性伸缩策略
try{
    $response = $asClient->createPolicy([
        'body' => [
            "alarm_id" => "al1513822380493GvlJKZwA8",
            "cool_down_time" => 900,
            "scaling_resource_id" => "8ade64b5-d685-40b8-8582-4ce306ea37a6",
            "scaling_resource_type" => "BANDWIDTH",
            "scaling_policy_action" => [
                "size" => 1,
                "operation" => "ADD",
                "limits" => 10
            ],
            "scaling_policy_name" => "hth_aspolicy_1",
            "scaling_policy_type" => "ALARM"
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
