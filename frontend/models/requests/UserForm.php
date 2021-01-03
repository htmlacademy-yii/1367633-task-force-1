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

	public function search()
	{
		$users = User::find()->where(['role' => User::ROLE_IMPLEMENTER])->orderBy('id DESC');

		if ($this->category) {
			$users->joinWith('specializations')->andWhere(['category_id' => $this->category]);
		}

		if ($this->freeNow) {
			$users->andWhere('not exists (select 1 from task where implementer_id = user.id and status in ("processing", "new"))');
		}

		if ($this->online) {
			$lastActive = date('Y-m-d H:i:s', strtotime('-30 mins'));
			$users->andFilterCompare('last_active', ">$lastActive");
		}

		if ($this->hasReviews) {
			$users->joinWith('implementerReviews')->andWhere(['not', ['message' => null]]);
		}

		if ($this->inFavorites) {
			$users->joinWith('implementerFavorites')->andWhere(['not', ['favorite_id' => null]]);
		}

		if ($this->searchName) {
			$users->andFilterWhere(['LIKE', 'name', $this->searchName]);
		}

		return $users;
	}
}
