<?php

namespace frontend\controllers;

use frontend\models\Task;

class TasksController extends \yii\web\Controller
{
	public function actionIndex()
	{
		$tasks = Task::find()->where(['status' => Task::STATUS_NEW])->all();

		return $this->render('index', ['tasks' => $tasks]);
	}
}
