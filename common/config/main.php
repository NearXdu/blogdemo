<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    "timeZone" => "Asia/Shanghai",
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
          //  'class' => 'yii\caching\FileCache',
            'class'=>'yii\redis\Cache',
        ],
        'redis'=>[
            'class'=>'yii\redis\Connection',
            'hostname'=>'localhost',
            'port'=>6379,
            'database'=>0,
        ],
        'authManager'=>[
            'class'=>'yii\rbac\DbManager',
        ],
    ],
];
