<?php

	namespace TaskForce\Models;

	use TaskForce\Actions\AbstractAction;
	use TaskForce\Actions\CancelAction;
	use TaskForce\Actions\DoneAction;
	use TaskForce\Actions\RefuseAction;
	use TaskForce\Actions\RespondAction;
	use TaskForce\Exception\ExistsException;

	/**
	 * Класс для определения всех доступных действий и статусов
	 */
	class Task
	{
		const STATUS_NEW = 'new'; 						// Новое
		const STATUS_PROCESSING = 'processing'; 		// В работе
		const STATUS_PERFORMED = 'performed'; 			// Выполнено
		const STATUS_FAILED = 'failed'; 				// Провалено
		const STATUS_CANCELED = 'canceled'; 			// Отменено

		const ROLE_CUSTOMER = 'customer'; 				// Заказчик
		const ROLE_IMPLEMENTER = 'implementer'; 		// Исполнитель

		const STATUS_NAMES = [
			self::STATUS_NEW => 'Новое',
			self::STATUS_PROCESSING => 'В работе',
			self::STATUS_PERFORMED => 'Выполнено',
			self::STATUS_FAILED => 'Отменено',
		];

		const ACTION_AVAILABLE = [
			self::STATUS_NEW => [RespondAction::class, CancelAction::class],
			self::STATUS_PROCESSING => [DoneAction::class, RefuseAction::class],
		];

		private $idCustomer;
		private $idImplementer;
		private $status;

		/**
		 * Конструктор для получения id исполнителя и id заказчика
		 *
		 * @param int $idCustomer
		 * @param int $idImplementer
		 * @param int $idUser
		 */
		public function __construct($idCustomer, $idImplementer)
		{
			$this->idCustomer = $idCustomer;
			$this->idImplementer = $idImplementer;
		}

		public function setStatus($status): bool
		{
			if(!array_key_exists($status, self::STATUS_NAMES))
			{
				throw new ExistsException('Передано неизвестный статус: ' . $status);
			}

			$this->status = $status;
			return true;
		}

		public function getActions($idUser): ?array
		{
			if(!$this->status)
			{
				return null;
			}

			$ActionAvailable = [];
			if(array_key_exists($this->status, self::ACTION_AVAILABLE))
			{
				foreach(self::ACTION_AVAILABLE[$this->status] as $action){
					$action = new $action();
					if($action->getUser($this->idCustomer, $this->idImplementer, $idUser)){
						$ActionAvailable = $action->getAction();
					}
				}
			}

			return $ActionAvailable;
		}

		/**
		 * Метод для возвращения статуса в который перейдет задание
		 *
		 * @param string $action
		 * @return string $status
		 * @throws ExistsException
		 */
		public function getNextStatus($action): ?string
		{
			if(!$this->status || !isset(self::ACTION_AVAILABLE[$this->status]))
			{
				throw new ExistsException('Передано неизвестное действие: ' . $action);
			}

			foreach(self::ACTION_AVAILABLE[$this->status] as $act){
				if($act::getAction() === $action){
					return $act::nextStatus();
				}
			}

			return null;
		}
		
	}
	