<?php

	namespace TaskForce\Actions;
	
	/**
	 * CancelAction class наследует от AbstractAction, возвращает действие 'Отменить'
	 */
	class CancelAction extends AbstractAction
	{
		public function canUse($idCustomer, $idImplementer, $idUser){
			return $idImplementer !== $idUser;
		}

		public function getName()
		{
			return 'Отменить';
		}

		public function getAction()
		{
			return 'cancel';
		}

		public function nextStatus()
		{
			return 'canceled';
		}
	}
	