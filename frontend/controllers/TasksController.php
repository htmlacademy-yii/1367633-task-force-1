<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Task;
use frontend\models\Category;
use frontend\models\requests\TaskForm;
use frontend\models\requests\TaskCreateForm;
use yii\web\NotFoundHttpException;
use frontend\controllers\SecuredController;
use frontend\models\requests\PerformedTaskForm;
use frontend\models\requests\ResponseForm;
use frontend\models\Response;
use frontend\models\Reviews;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\web\UploadedFile;

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

	public function actionView($id, $form = '')
	{
		$task = Task::findOne($id);

		if (!$task) {
			throw new NotFoundHttpException("Задание с ID $id не найдено!");
		}
		
		$errors = [];

		$responseModel = new ResponseForm();
		if (Yii::$app->request->isPost && $form === 'response') {
			$responseModel->load(Yii::$app->request->post());
			if ($responseModel->validate()) {
				$response = new Response();
				$response->task_id = $id;
				$response->implementer_id = Yii::$app->user->getId();
				$response->status = Response::STATUS_NEW;
				$response->description = $responseModel->description;
				$response->rate = Yii::$app->user->getIdentity()->rate;
				$response->price = $responseModel->price;
				$response->save();

				return $this->redirect(['tasks/view', 'id' => $id]);
			}

			$errors = $responseModel->getErrors();
		}

		$performedModel = new PerformedTaskForm();
		if (Yii::$app->request->isPost && $form === 'performed') {
			$performedModel->load(Yii::$app->request->post());
			if ($performedModel->validate()) {
				$review = new Reviews();
				$review->customer_id = Yii::$app->user->getId();
				$review->implementer_id = $task->implementer_id;
				$review->task_id = $task->id;
				$review->message = $performedModel->message;
				$review->rate = $performedModel->rate;
				$review->save();

				$task->status = ($performedModel->performed === 'yes') ? Task::STATUS_PERFORMED : Task::STATUS_FAILED;
				$task->save();

				return $this->redirect(['tasks/view', 'id' => $id]);
			}

			$errors = $performedModel->getErrors();
		}

		if (Yii::$app->request->isPost && $form === 'failed') {
			$task->status = Task::STATUS_FAILED;
			$task->save();

			return $this->redirect(['tasks/view', 'id' => $id]);
		}

		if (Yii::$app->request->isPost && $form === 'cancel') {
			$task->status = Task::STATUS_CANCELED;
			$task->save();

			return $this->redirect(['tasks/view', 'id' => $id]);
		}
		
		$taskState = new \TaskForce\Models\Task($task->customer_id, $task->implementer_id);
		$taskState->setStatus($task->status);

		$actionAvailable = $taskState->getActions(Yii::$app->user->getId());

		return $this->render('view', ['task' => $task, 'taskState' => $taskState, 'responseModel' => $responseModel,  'performedModel' => $performedModel, 'errors' => $errors, 'actionAvailable' => $actionAvailable]);
	}

	public function actionCreate()
	{
		$taskCreate = new TaskCreateForm();

		$categories = Category::find()->select(['id', 'name'])->all();
		$resultCategory = [];
		foreach ($categories as $category) {
			$resultCategory[$category->id] = $category->name;
		}
		$category = $resultCategory;

		$errors = [];

		if (Yii::$app->request->isPost) {
			$taskCreate->load(Yii::$app->request->post());
			if ($taskCreate->validate() && empty($taskCreate->getErrors())) {
				$task = new Task();
				$task->customer_id = Yii::$app->user->getId();
				$task->status = Task::STATUS_NEW;
				$task->title = $taskCreate->title;
				$task->description = $taskCreate->description;
				$task->category_id = $taskCreate->category;
				$task->budget = $taskCreate->budget;
				$task->end_date = $taskCreate->end_date;
				$task->date_created = date('Y-m-d h:i:s');
				$task->save();

				$taskCreate->attachments = UploadedFile::getInstances($taskCreate, 'attachments');
				foreach ($taskCreate->attachments as $file) {
					$name = 'attachments/' . $task->id . '_' . $file->baseName . '.' . $file->extension;
					$file->saveAs($name);
				}

				return $this->redirect(Url::toRoute(['tasks/view', 'id' => $task->id]));
			}

			$errors = $taskCreate->getErrors();
		}

		return $this->render('create', ['model' => $taskCreate, 'category' => $category, 'errors' => $errors]);
	}

	public function actionAccept($taskId, $implementerId)
	{
		$task = Task::find()->where(['id' => $taskId])->one();
		$task->implementer_id = $implementerId;
		$task->status = Task::STATUS_PROCESSING;
		$task->save();

		return $this->redirect(['tasks/view', 'id' => $taskId]);
	}

	public function actionCancel($taskId, $responseId)
	{
		$response = Response::find()->where(['id' => $responseId])->one();
		$response->status = Response::STATUS_CANCELED;
		$response->save();
		
		return $this->redirect(['tasks/view', 'id' => $taskId]);
	}
}
