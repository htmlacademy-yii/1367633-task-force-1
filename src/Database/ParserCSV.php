<?php

namespace TaskForce\Database;

use TaskForce\Exception\ExistsException;
use SplFileObject;

/**
 * Класс для конвертирования записей из датасетов в формат SQL
 */
class ParserCSV
{
	private $file;
	private $fileSql;
	private $output;
	private $data;
	private $fileNameSql;
	private $columns;
	private $tableName;
	private $filename;

	public function __construct(string $filename, array $columns)
	{
		$this->filename = $filename;
		$this->columns = str_replace('﻿', '', $columns); // Убираем ZWNBSP
		$this->fileNameSql = $filename;
		$this->tableName = $filename;
	}

	public function importFile(string $filename, array $columns): void
	{
		if (!$this->validateColumns($columns)) {
			throw new ExistsException("Заданы неверные заголовки столбцов");
		}

		if (!file_exists($filename)) {
			throw new ExistsException("Файл '" . $filename . "' не существует");
		}

		try {
			$this->file = new SplFileObject($filename);
		} catch (ExistsException $exception) {
			throw new ExistsException("Не удалось открыть файл '" . $filename . "' на чтение");
		}

		if ($this->file->getExtension() !== 'csv') {
			throw new ExistsException("Недопустимое расширение файла '" . $filename . "'");
		}

		$dataHeader = $this->getDataHeader();

		if ($dataHeader !== $columns) {
			throw new ExistsException("Исходный файл '" . $filename . "' не содержит необходимых столбцов");
		}

		foreach ($this->getNextLine() as $line) {
			if (implode($line) == null) {
				continue;
			} else {
				$stringData = implode(', ', array_map(function ($item) {
					return "'{$item}'";
				}, $line));
				$stringData = sprintf('(%s)', $stringData);
				$this->data[] = $stringData;
			}
		}
	}

	public function getData(): array
	{
		return $this->data;
	}

	private function getDataHeader(): array
	{
		$this->file->rewind();

		return $this->file->fgetcsv();
	}

	private function getNextLine(): ?iterable
	{
		$output = null;
		while (!$this->file->eof()) {
			yield $this->file->fgetcsv();
		}

		return $output;
	}

	private function validateColumns($columns): bool
	{
		$output = true;

		if (!count($columns)) {
			$output = false;
		}

		foreach ($columns as $column) {
			if (!is_string($column)) {
				return false;
			}
		}

		return $output;
	}

	public function writeFile($fileNameSql): void
	{
		try {
			$this->fileSql = new SplFileObject($fileNameSql, 'w');
		} catch (ExistsException $exception) {
			throw new ExistsException("Не удалось открыть файл '" . $fileNameSql . "' на запись");
		}

		$query = sprintf(
			"INSERT INTO %s (%s) VALUES " . PHP_EOL . "%s;",
			$this->tableName,
			implode(',', $this->columns),
			implode(', ' . PHP_EOL, $this->data)
		);

		$this->fileSql->fwrite($query);

		print("Файл '" . $fileNameSql . "' успешно создан!<br />");
	}
}
