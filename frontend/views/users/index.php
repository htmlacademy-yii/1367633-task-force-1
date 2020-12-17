<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'TaskForce - Исполнители';

$formConfig = [
	'method' => 'post',
	'action' => 'users',
	'options' => [
		'class' => 'search-task__form',
		'id' => 'filterForm',
		'name' => 'users'
	],
];

?>
<section class="user__search">
	<div class="user__search-link">
		<p>Сортировать по:</p>
		<ul class="user__search-list">
			<li class="user__search-item user__search-item--current">
				<a href="#" class="link-regular">Рейтингу</a>
			</li>
			<li class="user__search-item">
				<a href="#" class="link-regular">Числу заказов</a>
			</li>
			<li class="user__search-item">
				<a href="#" class="link-regular">Популярности</a>
			</li>
		</ul>
	</div>
	<?php foreach($users as $user) : ?>
		<div class="content-view__feedback-card user__search-wrapper">
			<div class="feedback-card__top">
				<div class="user__search-icon">
					<a href="<?= Url::to(['users/view', 'id' => $user->id]); ?>"><img src="<?= $user->photo; ?>" width="65" height="65"></a>
					<span><?= count($user->implementerTasks); ?> заданий</span>
					<span><?= count($user->implementerReviews); ?> отзывов</span>
				</div>
				<div class="feedback-card__top--name user__search-card">
					<p class="link-name"><a href="<?= Url::to(['users/view', 'id' => $user->id]); ?>" class="link-regular"><?= $user->name; ?></a></p>

					<?= str_repeat('<span></span>', $user->rate); ?>
					<?=	str_repeat('<span class="star-disabled"></span>', 5 - $user->rate); ?>
					
					<b><?= $user->rate; ?></b>
					<p class="user__search-content">
						<?= $user->about; ?>
					</p>
				</div>
				<span class="new-task__time"><?= Yii::$app->formatter->asRelativeTime($user->last_active); ?></span>
			</div>
			<div class="link-specialization user__search-link--bottom">
				<?php foreach($user->specializations as $specialization) : ?>
					<a href="#" class="link-regular"><?= $specialization->category->name; ?></a>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endforeach; ?>
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
					$form->field($model, 'freeNow', [
						'options' => ['tag' => false],
						'template' => '{input}{label}{error}'
					])->checkbox(['class' => 'visually-hidden checkbox__input', 'uncheck' => null], false);
				?>
				<?=
					$form->field($model, 'online', [
						'options' => ['tag' => false],
						'template' => '{input}{label}{error}'
					])->checkbox(['class' => 'visually-hidden checkbox__input', 'uncheck' => null], false);
				?>
				<?=
					$form->field($model, 'hasReviews', [
						'options' => ['tag' => false],
						'template' => '{input}{label}{error}'
					])->checkbox(['class' => 'visually-hidden checkbox__input', 'uncheck' => null], false);
				?>
				<?=
					$form->field($model, 'inFavorites', [
						'options' => ['tag' => false],
						'template' => '{input}{label}{error}'
					])->checkbox(['class' => 'visually-hidden checkbox__input', 'uncheck' => null], false);
				?>
			<?= Html::endTag('fieldset'); ?>

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