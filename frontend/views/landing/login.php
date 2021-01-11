<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'TaskForce - Главная';
$this->params['tasks'] = $tasks;

?>

<section class="modal enter-form form-modal" id="enter-form">
	<h2>Вход на сайт</h2>
	<?php $form = ActiveForm::begin(['method' => 'post', 'action' => '/', 'enableAjaxValidation' => true]); ?>
	<?=
		$form->field($model, 'email', [
			'options' => ['tag' => 'p'],
			'errorOptions' => ['tag' => 'span'],
		])->input('email', [
			'class' => 'enter-form-email input input-middle'
		])->label('Email', ['class' => 'form-modal-description']);
	?>
	<?=
		$form->field($model, 'password', [
			'options' => ['tag' => 'p'],
			'errorOptions' => ['tag' => 'span'],
		])->input('password', [
			'class' => 'enter-form-email input input-middle'
		])->label('Пароль', ['class' => 'form-modal-description']);
	?>
	<?= Html::submitButton('Войти', ['class' => 'button']); ?>
	<?php ActiveForm::end(); ?>
	<button class="form-modal-close" type="button">Закрыть</button>
</section>