<?php

	class Task
	{
		const STATUS_NEW = 'new'; 					// Новое
		const STATUS_PROCESSING = 'processing'; 	// В работе
		const STATUS_PERFORMED = 'performed'; 		// Выполнено
		const STATUS_FAILED = 'failed'; 			// Провалено
		const STATUS_CANCELED = 'canceled'; 		// Отменено

		const ACTION_RESPOND = 'respond'; 			// Откликнуться
		const ACTION_DONE = 'done'; 				// Выполнено
		const ACTION_REFUSE = 'refuse'; 			// Отказаться
		const ACTION_CANCEL = 'cancel'; 			// Отменить

		const ROLE_CUSTOMER = 'customer'; 			// Заказчик
		const ROLE_IMPLEMENTER = 'implementer'; 	// Исполнитель

		const MAP_STATUS = [
			self::STATUS_NEW => 'Новое',
			self::STATUS_PROCESSING => 'В работе',
			self::STATUS_PERFORMED => 'Выполнено',
			self::STATUS_FAILED => 'Отменено',
		];

		const MAP_ACTION = [
			self::ACTION_RESPOND => 'Откликнуться',
			self::ACTION_DONE => 'Выполнено',
			self::ACTION_REFUSE => 'Отказаться',
			self::ACTION_CANCEL => 'Отменить',
		];

		private $idCustomer;
		private $idImplementer;
		private $status;
		private $action;

		public function __construct($idCustomer, $idImplementer)
		{
			$this->idCustomer = $idCustomer;
			$this->idImplementer = $idImplementer;
		}

		public function getNextStatus($action)
		{
			switch ($action) {
				case self::ACTION_RESPOND:
					$status = self::STATUS_NEW;
					break;
				case self::ACTION_DONE:
					$status = self::STATUS_PERFORMED;
					break;
				case self::ACTION_REFUSE:
					$status = self::STATUS_FAILED;
					break;
				case self::ACTION_CANCEL:
					$status = self::STATUS_CANCELED;
					break;
				default:
					$status = $this->status;
					break;
			}

			return $status;
		}

		public function getStatus()
		{
			return self::MAP_STATUS;
		}

		public function getAction()
		{
			return self::MAP_ACTION;
		}
		
	}
	