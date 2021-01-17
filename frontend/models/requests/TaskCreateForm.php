<?php

namespace frontend\models\requests;

use Yii;
use frontend\models\Category;
use yii\base\Model;

class TaskCreateForm extends Model
{
	public $title;
	public $description;
	public $category;
	public $attachments;
	// public $location;
	public $budget;
	public $end_date;

	public function rules()
	{
		return [
			[['title', 'description', 'category', 'budget', 'end_date'], 'safe'],
			[['title', 'description', 'category', 'budget', 'end_date'], 'required'],
			[['title', 'description'], 'string', 'min' => 1],
			[['category'], 'exist', 'targetClass' => Category::class, 'targetAttribute' => 'id'],
			[['budget'], 'number', 'min' => '1'],
			[['end_date'], 'date', 'format' => 'php:Y-m-d'],
			[['attachments'], 'file', 'mimeTypes' => 'image/*', 'maxFiles' => 5],
		];
	}

	public function attributeLabels()
	{
		return [
			'title' => 'Мне нужно',
			'description' => 'Подробности задания',
			'category' => 'Категория',
			'attachments' => 'Файлы',
			// 'location' => 'Локация',
			'budget' => 'Бюджет',
			'end_date' => 'Срок исполнения',
		];
	}
}
