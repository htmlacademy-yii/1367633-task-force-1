<?php

	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);

	require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/vendor/autoload.php';

	$task = new Task(1, 2);

	assert($task->getActions(1) === null);

	assert($task->setStatus('nonexistent') === false);
	assert($task->setStatus(Task::STATUS_NEW));

	assert($task->getActions(3) === []);

	assert($task->getActions(1) == ["refuse"], 'Действия должны совпадать');
	assert($task->getActions(2) == ["done"]);

	assert($task->getNextStatus("done") === Task::STATUS_PERFORMED, 'Ожидайте действие: "done"');
	assert($task->getNextStatus("cancel") === Task::STATUS_CANCELED, 'Ожидайте действие: "cancel"');

	$task->setStatus(Task::STATUS_CANCELED);
	assert($task->getActions(1) === [] && $task->getActions(2) === []);
	assert($task->getNextStatus("refuse") === null);
