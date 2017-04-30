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
		'gridview' =>  [
			'class' => '\kartik\grid\Module',
			// enter optional module parameters below - only if you need to  
			// use your own export download action or custom translation 
			// message source
			'downloadAction' => 'gridview/export/download',
			'i18n' => [
				'class' => 'yii\i18n\PhpMessageSource',
				'basePath' => '@kvgrid/messages',
				'forceTranslation' => true
			]
		]
	],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
		  'formatter' => [
				'class' => 'yii\i18n\Formatter',
				'nullDisplay' => '',
				'timeZone' => 'Chile/Continental', //No funciona por alguna razon. Vease web/index.php
    ],
		'settings'=>[ 'class'=>'johnitvn\settings\Settings' ],
		
		'view' => [
         'theme' => [
             'pathMap' => [
                '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
             ],
         ],
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
		'authManager' => [
			'class'=>'yii\rbac\DbManager',
            'defaultRoles'=>['guest'],
		],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];
