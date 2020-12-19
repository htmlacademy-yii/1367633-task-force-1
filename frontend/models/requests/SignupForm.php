<?php

namespace frontend\models\requests;

use frontend\models\User;
use frontend\models\City;
use yii\base\Model;

class SignupForm extends Model
{
	public $email;
	public $name;
	public $city;
	public $password;

	public function rules()
	{
		return [
			[['email', 'name', 'city', 'password'], 'required'],
			[['email', 'name', 'city', 'password'], 'safe'],
			[['email', 'name', 'city', 'password'], 'string', 'max' => 100],
			[['email'], 'email', 'message' => 'Введите валидный адрес электронной почты'],
			[['email'], 'unique', 'targetClass' => User::class, 'message' => 'Данный E-mail занят'],
			['name', 'string', 'min' => 2, 'max' => 50, 'message' => 'Введите ваше имя и фамилию'],
			[['city'], 'exist', 'targetClass' => City::class, 'targetAttribute' => 'id'],
			[['password'], 'string', 'min' => 8, 'message' => 'Длина пароля от 8 символов']
		];
	}

	public function attributeLabels()
	{
		return [
			'email' => 'Электронная почта',
			'name' => 'Ваше имя',
			'city' => 'Город проживания',
			'password' => 'Пароль'
		];
	}
}
