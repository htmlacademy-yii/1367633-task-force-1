<?php

	class Task
	{
		const STATUS_NEW = 'Новое';
		const STATUS_PROCESSING = 'В работе';
		const STATUS_DONE = 'Выполнено';
		const STATUS_FAILED = 'Провалено';
		const STATUS_CANCELED = 'Отменено';

		const ACTION_RESPOND = 'Откликнуться';
		const ACTION_DONE = 'Выполнено';
		const ACTION_REFUSE = 'Отказаться';
		const ACTION_CANCEL = 'Отменить';

		const ROLE_CUSTOMER = 'Заказчик';
		const ROLE_IMPLEMENTER = 'Исполнитель';

		const MAP = [
			
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