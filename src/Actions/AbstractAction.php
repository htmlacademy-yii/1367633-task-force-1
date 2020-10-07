<?php

	namespace TaskForce\Actions;

	/**
	 * Класс для определения действия которую может совершить пользователь
	 */
	abstract class AbstractAction
	{
		/**
		 * Метод для проверки прав пользователя на использования действия
		 *
		 * @param [int] $idCustomer
		 * @param [int] $idImplementer
		 * @param [int] $idUser
		 * @return true если у пользователя есть право на действие
		 */
		abstract public function getUser($idCustomer, $idImplementer, $idUser);

		/**
		 * Метод для локализации имя действия
		 *
		 * @return string
		 */
		abstract public function getName();

		/**
		 * Метод для не локализованного имя действия
		 *
		 * @return string
		 */
		abstract public function getAction();
	}
