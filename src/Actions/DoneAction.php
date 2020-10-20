<?php

	namespace TaskForce\Actions;
	
	/**
	 * DoneAction class наследует от AbstractAction, возвращает действие 'Выполнено'
	 */
	class DoneAction extends AbstractAction
	{
		public function canUse($idCustomer, $idImplementer, $idUser){
			return $idImplementer !== $idUser;
		}

		public function getName(): string
		{
			return 'Выполнено';
		}

		public function getAction(): string
		{
			return 'done';
		}

		public function nextStatus(): string
		{
			return 'performed';
		}
	}
	