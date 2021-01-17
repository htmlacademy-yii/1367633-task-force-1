<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'TaskForce - Создать задание';

$formConfig = [
	'method' => 'post',
	'action' => '/tasks/create',
	'options' => [
		'class' => 'create__task-form form-create',
		'enctype' => 'multipart/form-data',
		'id' => 'task-form',
		'name' => 'create-task-form'
	],
	'enableClientScript' => false
];

?>
<section class="create__task">
	<h1>Публикация нового задания</h1>
	<div class="create__task-main">
		<?php $form = ActiveForm::begin($formConfig); ?>
		<?=
		$form->field($model, 'title', [
			'options' => ['tag' => false],
			'hintOptions' => ['tag' => 'span'],
			'labelOptions' => ['class' => isset($errors['title']) ? 'input-danger' : ''],
			'template' => "{label}\n{input}\n{hint}"
		])->textarea([
			'class' => 'input textarea',
			'rows' => 1,
			'id' => '10',
			'placeholder' => 'Повесить полку'
		])->hint(isset($errors['title']) ? $errors['title'][0] : 'Кратко опишите суть работы');
		?>
		<?=
		$form->field($model, 'description', [
			'options' => ['tag' => false],
			'hintOptions' => ['tag' => 'span'],
			'labelOptions' => ['class' => isset($errors['description']) ? 'input-danger' : ''],
			'template' => "{label}\n{input}\n{hint}"
		])->textarea([
			'class' => 'input textarea',
			'rows' => 7,
			'id' => '11',
			'placeholder' => 'Place your text'
		])->hint(isset($errors['description']) ? $errors['description'][0] : 'Укажите все пожелания и детали, чтобы исполнителям было проще соориентироваться');
		?>
		<?=
		$form->field($model, 'category', [
			'options' => ['tag' => false],
			'hintOptions' => ['tag' => 'span'],
			'labelOptions' => ['class' => isset($errors['category']) ? 'input-danger' : ''],
			'template' => "{label}\n{input}\n{hint}"
		])->listBox($category, [
			'class' => 'multiple-select input multiple-select-big',
			'size' => 1,
			'id' => '12',
		])->hint(isset($errors['category']) ? $errors['category'][0] : 'Выберите категорию');
		?>
		<?=
		$form->field($model, 'attachments[]', [
			'options' => ['tag' => false],
			'hintOptions' => ['tag' => 'span'],
			'labelOptions' => ['class' => isset($errors['attachments']) ? 'input-danger' : ''],
			'inputOptions' => ['class' => 'dropzone'],
			'template' => "{label}\n{hint}\n<div class='create__file dz-clickable'><span>Добавить новый файл</span>{input}\n</div>",
		])->fileInput([
			'multiple' => true,
			'accept' => 'image/*',
		])->hint(isset($errors['attachments']) ? $errors['attachments'][0] : 'Загрузите файлы, которые помогут исполнителю лучше выполнить или оценить работу');
		?>
		<!-- <label for="13">Локация</label>
			<input class="input-navigation input-middle input" id="13" type="search" name="q" placeholder="Санкт-Петербург, Калининский район">
			<span>Укажите адрес исполнения, если задание требует присутствия</span> -->
		<div class="create__price-time">
			<?=
			$form->field($model, 'budget', [
				'options' => ['tag' => 'div', 'class' => 'create__price-time--wrapper'],
				'hintOptions' => ['tag' => 'span'],
				'labelOptions' => ['class' => isset($errors['budget']) ? 'input-danger' : ''],
				'template' => "{label}\n{input}\n{hint}"
			])->textarea([
				'class' => 'input textarea input-money',
				'rows' => 1,
				'id' => '14',
				'placeholder' => '1000'
			])->hint(isset($errors['budget']) ? $errors['budget'][0] : 'Не заполняйте для оценки исполнителем');
			?>
			<?=
			$form->field($model, 'end_date', [
				'options' => ['tag' => 'div', 'class' => 'create__price-time--wrapper'],
				'hintOptions' => ['tag' => 'span'],
				'labelOptions' => ['class' => isset($errors['end_date']) ? 'input-danger' : ''],
				'template' => "{label}\n{input}\n{hint}"
			])->input('date', [
				'class' => 'input-middle input input-date',
				'id' => '15',
				'placeholder' => '10.11, 15:00'
			])->hint(isset($errors['end_date']) ? $errors['end_date'][0] : 'Укажите крайний срок исполнения');
			?>
		</div>
		<?php ActiveForm::end(); ?>
		<div class="create__warnings">
			<div class="warning-item warning-item--advice">
				<h2>Правила хорошего описания</h2>
				<h3>Подробности</h3>
				<p>Друзья, не используйте случайный<br>
					контент – ни наш, ни чей-либо еще. Заполняйте свои
					макеты, вайрфреймы, мокапы и прототипы реальным
					содержимым.</p>
				<h3>Файлы</h3>
				<p>Если загружаете фотографии объекта, то убедитесь,
					что всё в фокусе, а фото показывает объект со всех
					ракурсов.</p>
			</div>
			<?php if ($model->hasErrors()) : ?>
				<div class="warning-item warning-item--error">
					<h2>Ошибки заполнения формы</h2>
					<?php foreach ($model->errors as $attribute => $errors) : ?>
						<h3><?= $model->getAttributeLabel($attribute) ?></h3>
						<?php foreach ($errors as $error) : ?>
							<p><?= $error; ?></p>
						<?php endforeach; ?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<?= Html::submitButton('Опубликовать', ['class' => 'button', 'form' => 'task-form']); ?>
</section>