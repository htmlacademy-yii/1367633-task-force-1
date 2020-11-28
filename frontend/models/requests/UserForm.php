<?php

namespace frontend\models\requests;

use frontend\models\User;
use yii\base\Model;

class UserForm extends Model
{
	public $category;
	public $freeNow;
	public $online;
	public $hasReviews;
	public $inFavorites;
	public $searchName;

	public function rules()
	{
		return [
			[['category', 'freeNow', 'online', 'hasReviews', 'inFavorites', 'searchName'], 'safe'],
			[['searchName'], 'string', 'max' => 100],
			[['freeNow', 'online', 'hasReviews', 'inFavorites'], 'boolean'],
		];
	}

	public function attributeLabels()
	{
		return [
			'category' => 'Категории',
			'freeNow' => 'Сейчас свободен',
			'online' => 'Сейчас онлайн',
			'hasReviews' => 'Есть отзывы',
			'inFavorites' => 'В избранном',
			'searchName' => 'Поиск по имени'
		];
	}
}
