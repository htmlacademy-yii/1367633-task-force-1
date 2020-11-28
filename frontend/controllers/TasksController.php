<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Task;
use frontend\models\Category;
use frontend\models\requests\TaskForm;

/**
 * Класс для работы с заданиями
 */
class TasksController extends \yii\web\Controller
{
	public function actionIndex()
	{
		$tasks = Task::find()->where(['status' => Task::STATUS_NEW])->orderBy('id DESC');

		$categories = Category::find()->all();
		$resultCategory = [];
		foreach ($categories as $category) {
			$resultCategory[$category->id] = $category->name;
		}
		$category = $resultCategory;

		$taskForm = new TaskForm();

		if (Yii::$app->request->isPost) {
			$taskForm->load(Yii::$app->request->post());

			if ($taskForm->category) {
				$tasks->andWhere(['category_id' => $taskForm->category]);
			}

			if ($taskForm->noResponse) {
				$tasks->joinWith('responses')->having('count(task_id) < 1')->groupBy('id');
			}

			if ($taskForm->remoteWork) {
				$tasks->andWhere('address is null');
			}

			if ($taskForm->period === "day") {
				$date = (new \DateTimeImmutable())->sub(\DateInterval::createFromDateString('-1 day'))->format('Y-m-d H:i:s');
				$tasks->andWhere( ['>=', 'date_created', $date]);
			}

			if ($taskForm->period === "week") {
				$date = (new \DateTimeImmutable())->sub(\DateInterval::createFromDateString('-1 week'))->format('Y-m-d H:i:s');
				$tasks->andWhere(['>=', 'date_created', $date]);
			}

			if ($taskForm->period === "month") {
				$date = date('Y-m-d H:i:s', strtotime('1 months ago'));
				$tasks->andFilterCompare('date_created', ">$date");
			}

			$tasks->andFilterWhere(['LIKE', 'title', $taskForm->searchName]);
		}

		$tasks = $tasks->all();

		return $this->render('index', ['tasks' => $tasks, 'category' => $category, 'model' => $taskForm]);
	}
}
