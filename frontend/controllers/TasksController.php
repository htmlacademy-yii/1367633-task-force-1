<?php

namespace frontend\controllers;

use frontend\models\Task;

class TasksController extends \yii\web\Controller
{
	public function actionIndex()
	{
		$tasks = Task::find()->where(['status' => Task::STATUS_NEW])->orderBy('date_created DESC')->all();

		return $this->render('index', ['tasks' => $tasks]);
	}
}
