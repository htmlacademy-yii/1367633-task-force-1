<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'TaskForce - Задания';

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
			<div class="content-view__attach">
				<h3 class="content-view__h3">Вложения</h3>
				<a href="#">my_picture.jpeg</a>
				<a href="#">agreement.docx</a>
			</div>
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
			<button class=" button button__big-color response-button open-modal" type="button" data-for="response-form">Откликнуться</button>
			<button class="button button__big-color refusal-button open-modal" type="button" data-for="refuse-form">Отказаться</button>
			<button class="button button__big-color request-button open-modal" type="button" data-for="complete-form">Завершить</button>
		</div>
	</div>
	<div class="content-view__feedback">
		<h2>Отклики <span>(<?= count($task->reviews); ?>)</span></h2>
		<?php foreach($task->reviews as $reviews) : ?>
		<div class="content-view__feedback-wrapper">
			<div class="content-view__feedback-card">
				<div class="feedback-card__top">
					<a href="#"><img src="/img/man-glasses.jpg" width="55" height="55"></a>
					<div class="feedback-card__top--name">
						<p><a href="#" class="link-regular"><?= $reviews->implementer->name; ?></a></p>

						<?= str_repeat('<span></span>', $reviews->implementer->rate); ?>
						<?=	str_repeat('<span class="star-disabled"></span>', 5 - $reviews->implementer->rate); ?>
						
						<b><?= $reviews->implementer->rate; ?></b>
					</div>
					<span class="new-task__time"><?= Yii::$app->formatter->asRelativeTime($reviews->date_created); ?></span>
				</div>
				<div class="feedback-card__content">
					<p>
						<?= $reviews->message; ?>
					</p>
					<span><?= $reviews->budget; ?> ₽</span>
				</div>
				<div class="feedback-card__actions">
					<a class="button__small-color request-button button" type="button">Подтвердить</a>
					<a class="button__small-color refusal-button button" type="button">Отказать</a>
				</div>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
</section>
<section class="connect-desk">
	<div class="connect-desk__profile-mini">
		<div class="profile-mini__wrapper">
			<h3>Заказчик</h3>
			<div class="profile-mini__top">
				<img src="/img/man-brune.jpg" width="62" height="62" alt="Аватар заказчика">
				<div class="profile-mini__name five-stars__rate">
					<p><?= $task->customer->name; ?></p>
				</div>
			</div>
			<p class="info-customer"><span><?= count($task->customer->customerTasks); ?> заданий</span><span class="last-">2 года на сайте</span></p>
			<a href="#" class="link-regular">Смотреть профиль</a>
		</div>
	</div>
	<div id="chat-container">
		<!--добавьте сюда атрибут task с указанием в нем id текущего задания-->
		<chat class="connect-desk__chat"></chat>
	</div>
</section>