<?php

namespace frontend\models\requests;

use yii\base\Model;

class ResponseForm extends Model
{
	public $price;
	public $description;

	public function rules()
	{
		return [
			[['price', 'description'], 'required'],
			['price', 'integer', 'min' => 1],
		];
	}

	public function attributeLabels()
	{
		return [
			'price' => 'Ваша цена',
			'description' => 'Комментарий',
		];
	}
}
