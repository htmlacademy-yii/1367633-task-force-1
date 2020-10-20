<?php

declare(strict_types=1);
ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';

use TaskForce\Models\Task;
use TaskForce\Exception\ExistsException;

try{
	$task = new Task(1, 2);
	$task->getNextStatus("done");
}
catch(\TaskForce\Exception\ExistsException $error){
	error_log("Ошибка: " . $error->getMessage());
}

assert($task->getNextStatus("cancel") == Task::STATUS_CANCELED);
	
