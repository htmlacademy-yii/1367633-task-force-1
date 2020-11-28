<?php

namespace frontend\models\requests;

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
}
