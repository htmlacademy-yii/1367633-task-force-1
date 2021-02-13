<?php

namespace frontend\models\requests;

use yii\base\Model;

class PerformedTaskForm extends Model
{
	public $performed;
	public $message;
	public $rate;
	
	public $radioLabels = ['yes' => 'Да', 'difficult' => 'Возникли проблемы'];

	public function rules()
	{
		return [
			[['rate', 'message'], 'required'],
			['rate', 'number', 'min' => 1],
		];
	}

	public function attributeLabels()
	{
		return [
			'performed' => 'Задание выполнено?',
			'message' => 'Комментарий'
		];
	}
}
