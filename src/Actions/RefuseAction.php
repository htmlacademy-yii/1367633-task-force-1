<?php

	namespace TaskForce\Actions;
	
	/**
	 * RefuseAction class наследует от AbstractAction, возвращает действие 'Отказаться'
	 */
	class RefuseAction extends AbstractAction
	{
		public function canUse($idCustomer, $idImplementer, $idUser){
			return $idCustomer !== $idUser;
		}

		public function getName()
		{
			return 'Отказаться';
		}

		public function getAction()
		{
			return 'refuse';
		}

		public function nextStatus()
		{
			return 'failed';
		}
	}
	