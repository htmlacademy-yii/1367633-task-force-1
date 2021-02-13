<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'TaskForce - Задание';

$actionAvailable = $taskState->getActions(Yii::$app->user->getId());

$this->registerJsFile('@web/js/main.js');

?>
<section class="content-view">
	<div class="content-view__card">
		<div class="content-view__card-wrapper">
			<div class="content-view__header">
				<div class="content-view__headline">
					<h1><?= $task->title; ?></h1>
					<span>Размещено в категории
						<a href="#" class="link-regular"><?= $task->category->name ?></a>
						<?= Yii::$app->formatter->asRelativeTime($task->date_created); ?></span>
				</div>
				<b class="new-task__price new-task__price--<?= $task->category->icon; ?> content-view-price"><?= $task->budget; ?><b> ₽</b></b>
				<div class="new-task__icon new-task__icon--<?= $task->category->icon; ?> content-view-icon"></div>
			</div>
			<div class="content-view__description">
				<h3 class="content-view__h3">Общее описание</h3>
				<p>
					<?= $task->description; ?>
				</p>
			</div>
			<?php if (count($task->attachments) > 0) : ?>
				<div class="content-view__attach">
					<h3 class="content-view__h3">Вложения</h3>
					<?php foreach ($task->attachments as $file) : ?>
						<a href="/<?= $file ?>"><?= basename($file) ?></a>
					<?php endforeach; ?>
				</div>
			<?php endif ?>
			<div class="content-view__location">
				<h3 class="content-view__h3">Расположение</h3>
				<div class="content-view__location-wrapper">
					<div class="content-view__map">
						<a href="#"><img src="/img/map.jpg" width="361" height="292" alt="Москва, Новый арбат, 23 к. 1"></a>
					</div>
					<div class="content-view__address">
						<span class="address__town"><?= $task->city->name; ?></span><br>
						<span><?= $task->address; ?></span>
						<p><?= $task->address_info; ?></p>
					</div>
				</div>
			</div>
		</div>
		<div class="content-view__action-buttons">
			<?php if (in_array(\TaskForce\Actions\RespondAction::ACTION_RESPOND, $actionAvailable)) : ?>
			<button class=" button button__big-color response-button open-modal" type="button" data-for="response-form">Откликнуться</button>
			<?php endif; ?>
			<?php if (in_array(\TaskForce\Actions\RefuseAction::ACTION_REFUSE, $actionAvailable)) : ?>
			<button class="button button__big-color refusal-button open-modal" type="button" data-for="refuse-form">Отказаться</button>
			<?php endif; ?>
			<?php if (in_array(\TaskForce\Actions\DoneAction::ACTION_DONE, $actionAvailable)) : ?>
			<button class="button button__big-color request-button open-modal" type="button" data-for="complete-form">Завершить</button>
			<?php endif; ?>
		</div>
	</div>
	<?php if (count($task->responses) > 0) : ?>
		<div class="content-view__feedback">
			<h2>Отклики <span>(<?= count($task->responses); ?>)</span></h2>
			<?php foreach ($task->responses as $response) : ?>
				<?php if (Yii::$app->user->getId() === $task->customer_id || Yii::$app->user->getId() === $response->implementer_id) : ?>
					<div class="content-view__feedback-wrapper">
						<div class="content-view__feedback-card">
							<div class="feedback-card__top">
								<a href="<?= Url::to(['users/view', 'id' => $response->implementer_id]); ?>">
									<img src="/<?= $response->implementer->photo; ?>" width="55" height="55">
								</a>
								<div class="feedback-card__top--name">
									<p><a href="<?= Url::to(['users/view', 'id' => $response->implementer_id]); ?>" class="link-regular"><?= $response->implementer->name; ?></a></p>

									<?= str_repeat('<span></span>', $response->implementer->rate); ?>
									<?= str_repeat('<span class="star-disabled"></span>', 5 - $response->implementer->rate); ?>

									<b><?= $response->implementer->rate; ?></b>
								</div>
								<span class="new-task__time"><?= Yii::$app->formatter->asRelativeTime($response->date_created); ?></span>
							</div>
							<div class="feedback-card__content">
								<p>
									<?= $response->description; ?>
								</p>
								<span><?= $response->price; ?> ₽</span>
							</div>
							<?php if ($response->status === "new" && Yii::$app->user->getId() === $task->customer_id && $task->status === "new") : ?>
								<div class="feedback-card__actions">
									<a class="button__small-color request-button button" href="<?= Url::toRoute(['tasks/accept', 'taskId' => $response->task_id, 'implementerId' => $response->implementer_id]) ?>" type="button">Подтвердить</a>
									<a class="button__small-color refusal-button button" href="<?= Url::to(['tasks/cancel', 'taskId' => $response->task_id, 'responseId' => $response->id]) ?>" type="button">Отказать</a>
								</div>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</section>
<section class="connect-desk">
	<div class="connect-desk__profile-mini">
		<div class="profile-mini__wrapper">
			<h3>Заказчик</h3>
			<div class="profile-mini__top">
				<img src="/<?= $task->customer->photo; ?>" width="62" height="62" alt="Аватар заказчика">
				<div class="profile-mini__name five-stars__rate">
					<p><?= $task->customer->name; ?></p>
				</div>
			</div>
			<p class="info-customer">
				<span><?= count($task->customer->customerTasks); ?> заданий</span>
				<span class="last-">2 года на сайте</span>
			</p>
			<a href="<?= Url::to(['users/view', 'id' => $task->customer->id]); ?>" class="link-regular">Смотреть профиль</a>
		</div>
	</div>
	<div id="chat-container">
		<!--добавьте сюда атрибут task с указанием в нем id текущего задания-->
		<chat class="connect-desk__chat"></chat>
	</div>
</section>

<section class="modal response-form form-modal" id="response-form">
	<h2>Отклик на задание</h2>
	<?php $formResponse = ActiveForm::begin(['method' => 'post', 'action' => Url::toRoute(['tasks/view/', 'id' => $task->id, 'form' => 'response'])]); ?>
		<?=
			$formResponse->field($responseModel, 'price', [
				'labelOptions' => ['class' => 'form-modal-description', 'for' => 'response-payment'],
				'options' => ['tag' => 'p']
			])->input('text', [
				'class' => 'response-form-payment input input-middle input-money',
				'id' => 'response-payment'
			]);
		?>
		<?=
			$formResponse->field($responseModel, 'description', [
				'labelOptions' => ['class' => 'form-modal-description', 'for' => 'response-comment'],
				'options' => ['tag' => 'p']
			])->textarea([
				'class' => 'input textarea',
				'rows' => 4,
				'id' => 'response-comment',
				'placeholder' => 'Place your text'
			]);
		?>
		<?= Html::submitButton('Отправить', ['class' => 'button modal-button']); ?>
	<?php ActiveForm::end(); ?>
	<button class="form-modal-close" type="button">Закрыть</button>
</section>
<section class="modal completion-form form-modal" id="complete-form">
	<h2>Завершение задания</h2>
	<p class="form-modal-description">Задание выполнено?</p>
	<?php $formPerformed = ActiveForm::begin(['method' => 'post', 'action' => Url::toRoute(['tasks/view/', 'id' => $task->id, 'form' => 'performed'])]); ?>
		<?= $formPerformed->field($performedModel, 'performed', [
			'options' => ['tag' => false],
			'template' => "{input}",
			])->radioList($performedModel->radioLabels, [
				'item' => function ($index, $label, $name, $checked, $value) {
					$inputClass = 'visually-hidden completion-input completion-input--' . $value;
					$labelClass = 'completion-label completion-label--' . $value;
					$id = 'completion-radio--' . $value;
					return "<input class=\"$inputClass\" type=\"radio\" id=\"$id\" name=\"$name\" value=$value><label class=\"$labelClass\" for=$id>$label</label>";
				}
			]);
		?>
		<?=
			$formPerformed->field($performedModel, 'message', [
				'labelOptions' => ['class' => 'form-modal-description'],
				'options' => ['tag' => 'p']
			])->textarea([
				'class' => 'input textarea',
				'rows' => 4,
				'placeholder' => 'Place your text'
			]);
		?>
		<p class="form-modal-description">
			Оценка
			<div class="feedback-card__top--name completion-form-star">
				<span class="star-disabled"></span>
				<span class="star-disabled"></span>
				<span class="star-disabled"></span>
				<span class="star-disabled"></span>
				<span class="star-disabled"></span>
			</div>
		</p>
		<?=
			$formPerformed->field($performedModel, 'rate', [
				'template' => "{input}",
				'options' => ['tag' => false]
			])->hiddenInput(['id' => 'rating']);
		?>
		<?= Html::submitButton('Отправить', ['class' => 'button modal-button']); ?>
	<?php ActiveForm::end(); ?>
	<button class="form-modal-close" type="button">Закрыть</button>
</section>
<section class="modal form-modal refusal-form" id="refuse-form">
	<h2>Отказ от задания</h2>
	<p>
		Вы собираетесь отказаться от выполнения задания.
		Это действие приведёт к снижению вашего рейтинга.
		Вы уверены?
	</p>
	<?php ActiveForm::begin(['method' => 'post', 'action' => Url::toRoute(['tasks/view/', 'id' => $task->id, 'form' => 'failed'])]); ?>
		<button class="button__form-modal button" id="close-modal" type="button">Отмена</button>
		<?= Html::submitButton('Отказаться', ['class' => 'button__form-modal refusal-button button']); ?>
	<?php ActiveForm::end(); ?>
	<button class="form-modal-close" type="button">Закрыть</button>
</section>
<div class="overlay"></div>