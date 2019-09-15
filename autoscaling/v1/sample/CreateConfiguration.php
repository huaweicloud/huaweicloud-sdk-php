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
    $response = $asClient->createConfiguration([
        'body' => [
            'scaling_configuration_name' => 'scaling_configuration_name',
            'instance_config' => [
                'flavorRef' => 's3.medium.2',
                'imageRef' => '3a64bd37-955e-40cd-ab9e-129db56bc05d',
                'disk' => [[
                    'size' => 40,
                    'volume_type' => 'SATA',
                    'disk_type' => 'SYS'
                    ],
                    [
                    'size' => 40,
                    'volume_type' => 'SATA',
                    'disk_type' => 'DATA'
                    ]
                ],
                'key_name' => 'KeyPair-huidu3-20190622',
                'security_groups' => [[
                    'id' => '5487a098-42eb-4fc6-8ab8-96822096673a'
                ]
                ],
                'multi_flavor_priority_policy' => 'PICK_FIRST'
            ]
        ]
    ]);
    if ($response->getStatus() == 200) {
        //成功时业务逻辑
        echo "success";
    } else {
        //失败时业务逻辑
		var_dump($response);
        throw new Exception ("createConfiguration is failed");
    }
} catch (Exception $e) {
    //捕获异常，例如记录日志等操作
    echo $e->getMessage();
}




