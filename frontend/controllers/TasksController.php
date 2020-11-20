<?php

namespace frontend\controllers;

use frontend\models\Task;

/**
 * Класс для работы с заданиями
 */
class TasksController extends \yii\web\Controller
{
	public function actionIndex()
	{
		$tasks = Task::find()->where(['status' => Task::STATUS_NEW])->orderBy('id DESC')->all();

		return $this->render('index', ['tasks' => $tasks]);
	}
}
