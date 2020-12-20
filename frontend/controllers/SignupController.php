<?php

namespace frontend\controllers;

use Yii;
use frontend\models\User;
use frontend\models\City;
use frontend\models\requests\SignupForm;

/**
 * Класс для работы с регистрацией пользователей
 */
class SignupController extends \yii\web\Controller
{
	public function actionIndex()
	{
		$signupForm = new SignupForm();

		$city = City::find()->all();

		$errors = [];

		if (Yii::$app->request->isPost) {
			$signupForm->load(Yii::$app->request->post());
			if ($signupForm->validate()) {
				$user = new User();
				$user->name = $signupForm->name;
				$user->email = $signupForm->email;
				$user->password = Yii::$app->security->generatePasswordHash($signupForm->password);
				$user->city_id = $signupForm->city;
				$user->role = User::ROLE_CUSTOMER;
				$user->save();

				return $this->goHome();
			}

			$errors = $signupForm->getErrors();
		}

		return $this->render('index', ['model' => $signupForm, 'city' => $city, 'errors' => $errors]);
	}
}
