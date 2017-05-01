<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');
$db2 = require(__DIR__ . '/db2.php');

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'components' => [
        'mailer' => [  
           'class' => 'yii\swiftmailer\Mailer',  
           'viewPath' => '@app/mail', //使用模板文件在/mail/
           'useFileTransport' =>false,//这句一定有，false发送邮件，true只是生成邮件在runtime文件夹下，不发邮件
           'transport' => [  
               'class' => 'Swift_SmtpTransport',  
               'host' => 'smtp.126.com',  //每种邮箱的host配置不一样
               'username' => 'zyf819681825@126.com',  
               'password' => '*******',  
               'port' => '25',  
               'encryption' => 'tls',
            ],   
           'messageConfig'=>[  
               'charset'=>'UTF-8',  
               'from'=>['zyf819681825@126.com'=>'janfer'] 
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'db2' => $db2,
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
