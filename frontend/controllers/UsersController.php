<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Category;
use frontend\models\requests\UserForm;

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
}
