<?php

namespace frontend\controllers;

use Yii;
use frontend\models\User;
use frontend\models\Category;
use frontend\models\requests\UserForm;
use yii\web\NotFoundHttpException;

/**
 * Класс для работы с пользователями
 */
class UsersController extends \yii\web\Controller
{
	public function actionIndex()
	{
		$userForm = new UserForm();
		$userForm->load(Yii::$app->request->post());

		$users = $userForm->search()->all();

		$categories = Category::find()->select(['id', 'name'])->all();
		$resultCategory = [];
		foreach ($categories as $category) {
			$resultCategory[$category->id] = $category->name;
		}
		$category = $resultCategory;

		return $this->render('index', ['users' => $users, 'category' => $category, 'model' => $userForm]);
	}

	public function actionView($id)
	{
		$user = User::findOne($id);

		if (!$user) {
			throw new NotFoundHttpException("Пользователя с ID $id не найдено!");
		}

		return $this->render('view', ['user' => $user]);
	}
}
