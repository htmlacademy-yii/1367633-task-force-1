<?php

	class Task
	{
		const STATUS_NEW = 'new'; 					// Новое
		const STATUS_PROCESSING = 'processing'; 	// В работе
		const STATUS_DONE = 'done'; 				// Выполнено
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
			self::STATUS_DONE => 'Выполнено',
			self::STATUS_FAILED => 'Отменено',
		];

		private $idCustomer;
		private $idImplementer;
		private $statusTask;
		private $dateCompletion;

		public function __construct($idCustomer, $idImplementer)
		{
			# code...
		}

		public function getStatus()
		{
			# code...
		}

		public function getAction()
		{
			# code...
		}
		
	}