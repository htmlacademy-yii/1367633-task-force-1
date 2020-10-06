<?php

	require_once __DIR__ . '/vendor/autoload.php';

	use TaskForce\models\Task;

	$task = new Task(1, 2);

	echo '<pre>';

	print_r($task::STATUS_NAMES);

	print_r($task::ACTION_NAMES);

	print_r($task->getNextStatus("done"));

	assert($task->getNextStatus("done") == Task::STATUS_PERFORMED, 'Ожидайте действие: "done"');
	assert($task->getNextStatus("cancel") == Task::STATUS_CANCELED, 'Ожидайте действие: "cancel"');
	