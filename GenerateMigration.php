<?php

require_once __DIR__ . '/vendor/autoload.php';

use TaskForce\Database\ParserCSV;
use TaskForce\Exception\ExistsException;

$path = glob('./data/*.csv');

for ($i = 0; $i < count($path); $i++) {
	$pathFileName = pathinfo($path[$i], PATHINFO_FILENAME);

	$file[$i] = new SplFileObject($path[$i]);

	$file[$i]->rewind();

	$columns = $file[$i]->fgetcsv();

	$outputFile = "./migrations/" . $pathFileName . ".sql";

	$parserCSV = new ParserCSV($pathFileName, $columns);

	try {
		$parserCSV->importFile($path[$i], $columns);
	} catch (ExistsException $error) {
		error_log('Неверная форма файла импорта: ' . $error->getMessage());
	} catch (ExistsException $error) {
		error_log('Не удалось обработать csv файл' . $path[$i] . ": " . $error->getMessage());
	}

	try {
		$parserCSV->writeFile($outputFile);
	} catch (ExistsException $error) {
		error_log('Не удалось обработать файл' . $outputFile . ': ' . $error->getMessage());
	}
}
