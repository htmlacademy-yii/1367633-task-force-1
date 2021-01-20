<?php

namespace frontend\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;
use TaskForce\Rule\CustomerAccess;

abstract class SecuredController extends Controller
{
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::class,
				'rules' => [
					[
						'allow' => true,
						'roles' => ['@']
					]
				]
			],
			'accessCustomer' => [
				'class' => AccessControl::class,
				'only' => ['create'],
				'rules' => [
					[
						'allow' => true,
						'roles' => ['@'],
						'actions' => ['create'],
					]
				],
				'ruleConfig' => ['class' => CustomerAccess::class],
			]
		];
	}
}
