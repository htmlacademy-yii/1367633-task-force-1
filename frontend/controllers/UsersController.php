<?php

namespace frontend\controllers;

use Yii;
use frontend\models\User;
use frontend\models\Category;
use frontend\models\requests\UserForm;
use yii\web\NotFoundHttpException;
use frontend\controllers\SecuredController;
use yii\data\Pagination;

/**
 * Класс для работы с пользователями
 */
class UsersController extends SecuredController
{
	public function actionIndex()
	{
		$userForm = new UserForm();
		$userForm->load(Yii::$app->request->post());

		$query = $userForm->search();

		$pagination = new Pagination([
			'totalCount' => $query->count(),
			'pageSize' => 5,
			'forcePageParam' => false,
			'pageSizeParam' => false
		]);

		$users = $query->offset($pagination->offset)->limit($pagination->limit)->all();

		$categories = Category::find()->select(['id', 'name'])->all();
		$resultCategory = [];
		foreach ($categories as $category) {
			$resultCategory[$category->id] = $category->name;
		}
		$category = $resultCategory;

		return $this->render('index', ['users' => $users, 'category' => $category, 'model' => $userForm, 'pagination' => $pagination]);
	}

	public function actionView($id)
	{
		$user = User::findOne($id);

		if (!$user) {
			throw new NotFoundHttpException("Пользователя с ID $id не найдено!");
		}

		return $this->render('view', ['user' => $user]);
	}

	public function actionLogout()
	{
		Yii::$app->user->logout();

		return $this->goHome();
	}
}
