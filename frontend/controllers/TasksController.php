<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Task;
use frontend\models\Category;
use frontend\models\requests\TaskForm;
use yii\web\NotFoundHttpException;
use frontend\controllers\SecuredController;
use yii\data\Pagination;

/**
 * Класс для работы с заданиями
 */
class TasksController extends SecuredController
{
	public function actionIndex()
	{
		$taskForm = new TaskForm();
		$taskForm->load(Yii::$app->request->post());

		$query = $taskForm->search();

		$pagination = new Pagination([
			'totalCount' => $query->count(),
			'pageSize' => 5,
			'forcePageParam' => false,
			'pageSizeParam' => false
		]);

		$tasks = $query->offset($pagination->offset)->limit($pagination->limit)->all();

		$categories = Category::find()->select(['id', 'name'])->all();
		$resultCategory = [];
		foreach ($categories as $category) {
			$resultCategory[$category->id] = $category->name;
		}
		$category = $resultCategory;

		return $this->render('index', ['tasks' => $tasks, 'category' => $category, 'model' => $taskForm, 'pagination' => $pagination]);
	}

	public function actionView($id)
	{
		$task = Task::findOne($id);
		
		if (!$task) {
			throw new NotFoundHttpException("Задание с ID $id не найдено!");
		}

		return $this->render('view', ['task' => $task]);
	}
}
