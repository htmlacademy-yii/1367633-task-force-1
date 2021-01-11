<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\Task;
use yii\widgets\ActiveForm;
use yii\web\Response;

class LandingController extends \yii\web\Controller
{
	public $layout = 'landing';

	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::class,
				'denyCallback' => function ($rule, $action) {
					return $this->redirect('/tasks');
				},
				'rules' => [
					[
						'allow' => true,
						'roles' => ['?'],
					]
				]
			]
		];
	}

	public function actionLogin()
	{
		$tasks = Task::find()->where(['status' => Task::STATUS_NEW])->orderBy('id DESC')->limit(4)->all();

		$login = new LoginForm();
		if (Yii::$app->request->getIsPost()) {
			$login->load(Yii::$app->request->post());
			if (Yii::$app->request->isAjax) {
				Yii::$app->response->format = Response::FORMAT_JSON;
				return ActiveForm::validate($login);
			}
			if ($login->validate() && $login->login()) {
				return $this->redirect('/tasks');
			}
		}

		return $this->render('login', ['model' => $login, 'tasks' => $tasks]);
	}
}
