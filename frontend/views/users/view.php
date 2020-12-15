<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'TaskForce - Пользователь';

?>
<section class="content-view">
	<div class="user__card-wrapper">
		<div class="user__card">
			<img src="/<?= $user->photo; ?>" width="120" height="120" alt="Аватар пользователя">
			<div class="content-view__headline">
				<h1><?= $user->name; ?></h1>
				<p><?= $user->city->name; ?>, <?= $user->age; ?> лет</p>
				<div class="profile-mini__name five-stars__rate">
					<?= str_repeat('<span></span>', $user->rate); ?>
					<?=	str_repeat('<span class="star-disabled"></span>', 5 - $user->rate); ?>
					<b><?= $user->rate; ?></b>
				</div>
				<b class="done-task">Выполнил <?= count($user->implementerTasks); ?> заказов</b><b class="done-review">Получил <?= count($user->implementerReviews); ?> отзывов</b>
			</div>
			<div class="content-view__headline user__card-bookmark user__card-bookmark--current">
				<span>Был на сайте <?= Yii::$app->formatter->asRelativeTime($user->last_active); ?></span>
				<a href="#"><b></b></a>
			</div>
		</div>
		<div class="content-view__description">
			<p><?= $user->about; ?></p>
		</div>
		<div class="user__card-general-information">
			<div class="user__card-info">
				<h3 class="content-view__h3">Специализации</h3>
				<div class="link-specialization">
				<?php foreach($user->specializations as $specialization) : ?>
					<a href="#" class="link-regular"><?= $specialization->category->name; ?></a>
				<?php endforeach; ?>
				</div>
				<h3 class="content-view__h3">Контакты</h3>
				<div class="user__card-link">
					<a class="user__card-link--tel link-regular" href="#"><?= $user->phone; ?></a>
					<a class="user__card-link--email link-regular" href="#"><?= $user->email; ?></a>
					<a class="user__card-link--skype link-regular" href="#"><?= $user->skype; ?></a>
				</div>
			</div>
			<?php if (count($user->photoWork) > 0) : ?>
			<div class="user__card-photo">
				<h3 class="content-view__h3">Фото работ</h3>
				<?php foreach($user->photoWork as $photo) : ?>
				<a href="#"><img src="/<?= $photo ?>" width="85" height="86" alt="Фото работы"></a>
				<?php endforeach; ?>
			</div>
			<?php endif ?>
		</div>
	</div>
	<?php if (count($user->implementerReviews) > 0) : ?>
	<div class="content-view__feedback">
		<h2>Отзывы<span>(<?= count($user->implementerReviews); ?>)</span></h2>
		<div class="content-view__feedback-wrapper reviews-wrapper">
		<?php foreach($user->implementerReviews as $reviews) : ?>
			<div class="feedback-card__reviews">
				<p class="link-task link">Задание <a href="#" class="link-regular">«<?= $reviews->task->title; ?>»</a></p>
				<div class="card__review">
					<a href="#"><img src="/img/man-glasses.jpg" width="55" height="54"></a>
					<div class="feedback-card__reviews-content">
						<p class="link-name link"><a href="#" class="link-regular"><?= $reviews->customer->name; ?></a></p>
						<p class="review-text">
							<?= $reviews->message; ?>
						</p>
					</div>
					<div class="card__review-rate">
						<?php if ($reviews->rate > 3) : ?>
							<p class="five-rate big-rate"><?= $reviews->rate; ?><span></span></p>
							<?php else : ?>
								<p class="three-rate big-rate"><?= $reviews->rate; ?><span></span></p>
						<?php endif ?>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<?php endif ?>
</section>
<section class="connect-desk">
	<div class="connect-desk__chat">

	</div>
</section>