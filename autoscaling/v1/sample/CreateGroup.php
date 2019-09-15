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
    $response = $asClient->createGroup([
        'body' => [
            'scaling_group_name' => 'GroupNameTest',
            'scaling_configuration_id' => '5ba14544-d699-442a-92b3-e9e91f01569e',
            'desire_instance_number' => 0,
            'min_instance_number' => 0,
            'max_instance_number' => 10,
            'health_periodic_audit_method' => 'NOVA_AUDIT',
            'vpc_id' => 'ad20dadf-a4b9-42ca-80ee-44bc78bddcab',
            'available_zones' => ['XXXa', 'XXXb'],
            'networks' => [[
                'id' => '6cd48e1e-85fe-4434-a3f4-eb16ad88e9ef'
                ]
            ],
            'enterprise_project_id' => '0',
            'multi_az_priority_policy' => 'PICK_FIRST'
        ]
    ]);
    if ($response->getStatus() == 200) {
        //成功时业务逻辑
        echo "success";
    } else {
        //失败时业务逻辑
        var_dump($response);
        throw new Exception ("createGroup is failed");
    }
} catch (Exception $e) {
    //捕获异常，例如记录日志等操作
    echo $e->getMessage();
}



