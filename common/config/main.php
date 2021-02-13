<?php
return [
	'language' => 'ru-RU',
	'aliases' => [
		'@bower' => '@vendor/bower-asset',
		'@npm'   => '@vendor/npm-asset',
	],
	'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
	'components' => [
		'urlManager' => [
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'enableStrictParsing' => false,
			'rules' => [
				'//' => '/',
				'/' => 'landing/login',
				'tasks/page/<page:\d+>' => 'tasks/index',
				'tasks' => 'tasks/index',
				'tasks/accept/<taskId>/<implementerId>' => 'tasks/accept',
				'tasks/cancel/<taskId>/<responseId>' => 'tasks/cancel',
				'users/page/<page:\d+>' => 'users/index',
				'users' => 'users/index',
				'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
				'signup' => 'signup/index',
				'logout' => 'users/logout',
			],
		],
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],
		'user' => [
			'identityClass' => 'frontend\models\User',
			'loginUrl' => ['landing/login']
		],
	],
];
