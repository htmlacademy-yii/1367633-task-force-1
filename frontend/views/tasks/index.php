<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'TaskForce - Задания';

$formConfig = [
	'method' => 'post',
	'action' => 'tasks',
	'options' => [
		'class' => 'search-task__form',
		'id' => 'filterForm',
		'name' => 'filter-form'
	],
];

?>
<section class="new-task">
	<div class="new-task__wrapper">
		<h1>Новые задания</h1>
		<?php foreach($tasks as $task) : ?>
			<div class="new-task__card">
				<div class="new-task__title">
					<a href="<?= Url::to(['tasks/view', 'id' => $task->id]); ?>" class="link-regular">
						<h2><?= $task->title; ?></h2>
					</a>
					<a class="new-task__type link-regular" href="#">
						<p><?= $task->category->name; ?></p>
					</a>
				</div>
				<div class="new-task__icon new-task__icon--<?= $task->category->icon; ?>"></div>
				<p class="new-task_description">
					<?= $task->description; ?>
				</p>
				<b class="new-task__price new-task__price--<?= $task->category->icon; ?>"><?= $task->budget; ?><b> ₽</b></b>
				<p class="new-task__place"><?= $task->city->name; ?>, <?= $task->address; ?></p>
				<span class="new-task__time"><?= Yii::$app->formatter->asRelativeTime($task->date_created); ?></span>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="new-task__pagination">
		<ul class="new-task__pagination-list">
			<li class="pagination__item"><a href="#"></a></li>
			<li class="pagination__item pagination__item--current">
				<a>1</a></li>
			<li class="pagination__item"><a href="#">2</a></li>
			<li class="pagination__item"><a href="#">3</a></li>
			<li class="pagination__item"><a href="#"></a></li>
		</ul>
	</div>
</section>
<section class="search-task">
	<div class="search-task__wrapper">
		<?php $form = ActiveForm::begin($formConfig); ?>
			<?= Html::beginTag('fieldset', ['class' => 'search-task__categories']); ?>
				<?= Html::tag('legend', 'Категории'); ?>
				<?=
					$form->field($model, 'category', 
						['options' => ['tag' => null]]
					)->label(false)->CheckboxList($category, [
						'tag' => false,
						'unselect' => null,
						'item' => static function ($index, $label, $name, $checked, $value) {
							$checked = $checked === true ? 'checked' : '';
							return "<input class =\"visually-hidden checkbox__input\" id=$index type=\"checkbox\" name=$name value=$value $checked>" . 
							"<label for=$index>$label</label>";
						}
					]);
				?>
			<?= Html::endTag('fieldset'); ?>

			<?= Html::beginTag('fieldset', ['class' => 'search-task__categories']); ?>
				<?= Html::tag('legend', 'Дополнительно'); ?>
				<?=
					$form->field($model, 'noResponse', [
						'options' => ['tag' => false],
						'template' => '{input}{label}{error}'
					])->checkbox(['class' => 'visually-hidden checkbox__input', 'uncheck' => null], false);
				?>

				<?=
					$form->field($model, 'remoteWork', [
						'options' => ['tag' => false],
						'template' => '{input}{label}{error}'
					])->checkbox(['class' => 'visually-hidden checkbox__input', 'uncheck' => null], false);
				?>
			<?= Html::endTag('fieldset'); ?>

			<?=
				$form->field($model, 'period', [
					'options' => ['tag' => false],
					'template' => '{label}{input}{error}',
					'labelOptions' => ['class' => 'search-task__name']
				])->listBox($model->periods, [
					'tag' => false,
					'options' => ['' => ['selected' => true]],
					'class' => 'multiple-select input',
					'unselect' => null,
					'size' => 1
				]);
			?>

			<?= 
				$form->field($model, 'searchName', [
					'options' => ['tag' => false],
					'template' => '{label}{input}{error}',
					'labelOptions' => ['class' => 'search-task__name'],
					'inputOptions' => ['type' => 'search', 'class' => 'input-middle input'],
				]);
			?>
			<?= Html::submitButton('Искать', ['class' => 'button']); ?>
		<?php ActiveForm::end(); ?>
	</div>
</section>