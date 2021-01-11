<?php

namespace frontend\models\requests;

use Yii;
use frontend\models\Task;
use yii\base\Model;

class TaskForm extends Model
{
	public $category;
	public $noResponse;
	public $remoteWork;
	public $period;
	public $searchName;

	public function rules()
	{
		return [
			[['category', 'noResponse', 'remoteWork', 'period', 'searchName'], 'safe'],
			[['searchName'], 'string', 'max' => 100],
			[['noResponse', 'remoteWork'], 'boolean'],
			[['period'], 'in', 'range' => ['day', 'week', 'month']],
		];
	}

	public function attributeLabels()
	{
		return [
			'category' => 'Категории',
			'noResponse' => 'Без откликов',
			'remoteWork' => 'Удаленная работа',
			'period' => 'Период',
			'searchName' => 'Поиск по названию',
		];
	}

	public function getPeriods()
	{
		return [
			'' => 'За все время',
			'day' => 'За день',
			'week' => 'За неделю',
			'month' => 'За месяц',
		];
	}

	public function search()
	{
		$tasks = Task::find()->where(['status' => Task::STATUS_NEW])->orderBy('id DESC');

		if ($this->category) {
			$tasks->andWhere(['category_id' => $this->category]);
		}

		if ($this->noResponse) {
			$tasks->joinWith('responses')->having('count(task_id) < 1')->groupBy('id');
		}

		if ($this->remoteWork) {
			$tasks->andWhere('address is null');
		}

		if ($this->period === "day") {
			$date = (new \DateTimeImmutable())->sub(\DateInterval::createFromDateString('-1 day'))->format('Y-m-d H:i:s');
			$tasks->andWhere( ['>=', 'date_created', $date]);
		}

		if ($this->period === "week") {
			$date = (new \DateTimeImmutable())->sub(\DateInterval::createFromDateString('-1 week'))->format('Y-m-d H:i:s');
			$tasks->andWhere(['>=', 'date_created', $date]);
		}

		if ($this->period === "month") {
			$date = date('Y-m-d H:i:s', strtotime('1 months ago'));
			$tasks->andFilterCompare('date_created', ">$date");
		}

		$tasks->andFilterWhere(['LIKE', 'title', $this->searchName]);

		return $tasks;
	}
}
