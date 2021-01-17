<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Task;
use frontend\models\User;
use frontend\models\Category;
use frontend\models\requests\TaskForm;
use frontend\models\requests\TaskCreateForm;
use yii\web\NotFoundHttpException;
use frontend\controllers\SecuredController;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * Класс для работы с заданиями
 */
class TasksController extends SecuredController
{
	public function behaviors()
	{
		$rules = parent::behaviors();
		$rule = [
			'allow' => false,
			'actions' => ['create'],
			'matchCallback' => function ($rule, $action) {
				$user = User::findOne(Yii::$app->user->id);
				return $user->role !== User::ROLE_CUSTOMER;
			}
		];
		array_unshift($rules['access']['rules'], $rule);

		return $rules;
	}

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
			if ($taskCreate->validate()) {
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
}
