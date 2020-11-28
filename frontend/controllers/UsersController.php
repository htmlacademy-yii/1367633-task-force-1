<?php

namespace frontend\controllers;

use Yii;
use frontend\models\User;
use frontend\models\Category;
use frontend\models\requests\UserForm;

/**
 * Класс для работы с пользователями
 */
class UsersController extends \yii\web\Controller
{
	public function actionIndex()
	{
		$users = User::find()->where(['role' => User::ROLE_IMPLEMENTER])->orderBy('id DESC');

		$categories = Category::find()->all();
		$resultCategory = [];
		foreach ($categories as $category) {
			$resultCategory[$category->id] = $category->name;
		}
		$category = $resultCategory;

		$userForm = new UserForm();

		if (Yii::$app->request->isPost) {
			$userForm->load(Yii::$app->request->post());

			if ($userForm->category) {
				$users->joinWith('specializations')->andWhere(['category_id' => $userForm->category]);
			}

			if ($userForm->freeNow) {
				$users->andWhere('not exists (select 1 from task where implementer_id = user.id and status in ("processing", "new"))');
			}

			if ($userForm->online) {
				$lastActive = date('Y-m-d H:i:s', strtotime('-30 mins'));
				$users->andFilterCompare('last_active', ">$lastActive");
			}

			if ($userForm->hasReviews) {
				$users->joinWith('implementerReviews')->andWhere(['not', ['message' => null]]);
			}

			if ($userForm->inFavorites) {
				$users->joinWith('implementerFavorites')->andWhere(['not', ['favorite_id' => null]]);
			}

			if ($userForm->searchName) {
				$users->andFilterWhere(['LIKE', 'name', $userForm->searchName]);
			}
		}

		$users = $users->all();

		return $this->render('index', ['users' => $users, 'category' => $category, 'model' => $userForm]);
	}
}
