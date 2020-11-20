<?php

namespace frontend\controllers;

use frontend\models\User;

/**
 * Класс для работы с пользователями
 */
class UsersController extends \yii\web\Controller
{
	public function actionIndex()
	{
		$users = User::find()->where(['role' => User::ROLE_IMPLEMENTER])->orderBy('id DESC')->all();

		return $this->render('index', ['users' => $users]);
	}
}
