<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Category;
use frontend\models\requests\TaskForm;

/**
 * Класс для работы с заданиями
 */
class TasksController extends \yii\web\Controller
{
	public function actionIndex()
	{
		$taskForm = new TaskForm();
		$taskForm->load(Yii::$app->request->post());

		$tasks = $taskForm->search();

		$categories = Category::find()->select(['id', 'name'])->all();
		$resultCategory = [];
		foreach ($categories as $category) {
			$resultCategory[$category->id] = $category->name;
		}
		$category = $resultCategory;

		return $this->render('index', ['tasks' => $tasks, 'category' => $category, 'model' => $taskForm]);
	}
}
