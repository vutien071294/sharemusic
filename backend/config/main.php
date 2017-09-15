<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'categorys' => [
            'class' => 'backend\modules\categorys\categorys',
        ],
         'systems' => [
            'class' => 'backend\modules\systems\systems',
        ],
        'users' => [
            'class' => 'backend\modules\users\users',
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module',
            'downloadAction' => 'gridview/export/download',
        ],

    ],
    'as beforeRequest' => [  //if guest user access site so, redirect to login page.
    'class' => 'yii\filters\AccessControl',
    'rules' => [
        [
            'actions' => ['login', 'error'],
            'allow' => true,
        ],
        [
            'allow' => true,
            'roles' => ['@'],
        ],
    ],
],
    'components' => [
        // 'request' => [
        //     'csrfParam' => '_csrf-backend',
        // ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'loginUrl' => ['site/login'],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        // 'log' => [
        //     'traceLevel' => YII_DEBUG ? 3 : 0,
        //     'targets' => [
        //         [
        //             'class' => 'yii\log\FileTarget',
        //             'levels' => ['error', 'warning'],
        //         ],
        //     ],
        // ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        // backend, under components array
        'request'=>[
            'class' => 'common\components\Request',
            'web'=> '/backend/web',
            'adminUrl' => '/admin'
        ],
        'urlManager' => [
                'enablePrettyUrl' => true,
                'showScriptName' => false,
                'rules' => [
                    // ...
                    ['class' => 'common\helpers\UrlRule', 'connectionID' => 'db', /* ... */],
                ],
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'nullDisplay' => '',
        ],
         'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],

        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
        ],

    ],
    'params' => [$params]
];
