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

		public function getName()
		{
			return 'Выполнено';
		}

		public function getAction()
		{
			return 'done';
		}

		public function nextStatus()
		{
			return 'performed';
		}
	}
	