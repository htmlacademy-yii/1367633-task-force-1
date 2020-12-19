<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'TaskForce - Регистрация';

$formConfig = [
	'method' => 'post',
	'action' => 'signup',
	'options' => [
		'class' => 'registration__user-form form-create',
		'id' => 'signupForm',
		'name' => 'signup-form'
	],
	'enableClientScript' => false
];

?>
<section class="registration__user">
	<h1>Регистрация аккаунта</h1>
	<div class="registration-wrapper">
		<?php $form = ActiveForm::begin($formConfig); ?>
			<?=
				$form->field($model, 'email', [
					'options' => ['tag' => false],
					'errorOptions' => ['tag' => 'span'],
					'labelOptions' => ['class' => isset($errors['email']) ? 'input-danger' : '']
				])->textarea(['class' => 'input textarea', 'rows' => 1, 'id' => '16', 'placeholder' => 'kumarm@mail.ru']);
			?>

			<?=
				$form->field($model, 'name', [
					'options' => ['tag' => false],
					'errorOptions' => ['tag' => 'span'],
					'labelOptions' => ['class' => isset($errors['name']) ? 'input-danger' : '']
				])->textarea(['class' => 'input textarea', 'rows' => 1, 'id' => '17', 'placeholder' => 'Мамедов Кумар']);
			?>
			
			<?=
				$form->field($model, 'city', [
					'options' => ['tag' => false],
					'errorOptions' => ['tag' => 'span'],
					'labelOptions' => ['class' => isset($errors['city']) ? 'input-danger' : '']
				])->listBox(ArrayHelper::map($city, 'id', 'name'), [
					'prompt' => 'Укажите город',
					'class' => 'multiple-select input town-select registration-town',
					'size' => 1,
					'unselect' => null
				]);
			?>

			<?=
				$form->field($model, 'password', [
					'options' => ['tag' => false],
					'errorOptions' => ['tag' => 'span'],
					'labelOptions' => ['class' => isset($errors['password']) ? 'input-danger' : '']
				])->input('password', ['class' => 'input textarea']);
			?>

			<?= Html::submitButton('Cоздать аккаунт', ['class' => 'button button__registration']); ?>
		<?php ActiveForm::end(); ?>
	</div>
</section>