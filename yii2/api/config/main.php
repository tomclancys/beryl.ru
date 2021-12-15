<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api\controllers',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules' => [],
    'components' => [
        'request' => [
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
            'csrfParam' => '_csrf-api',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'application/xml' => 'yii\web\XmlParser',
            ]
        ],
        'response' => [
            'formatters' => [
                'json' => [
                    'class' => 'yii\web\JsonResponseFormatter',
                    'prettyPrint' => YII_DEBUG,
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'showScriptName' => false,
            'rules' => [
                'POST equipment/' => 'equipment/create',
                'PUT equipment/<id:\d+>' => 'equipment/update',
                'DELETE equipment/<id:\d+>' => 'equipment/delete',
                'equipment/<id:\d+>' => 'equipment/view',
                'POST equipmenttype/' => 'equipmenttype/create',
                'PUT equipmenttype/<id:\d+>' => 'equipmenttype/update',
                'DELETE equipmenttype/<id:\d+>' => 'equipmenttype/delete',
                'equipmenttype/<id:\d+>' => 'equipmenttype/view',
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'equipmenttype',
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'equipment',
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
        ],
        'session' => [
            'name' => 'advanced-api',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'api/error',
        ],
    ],
    'params' => $params,
];
