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

		public function getName(): string
		{
			return 'Отказаться';
		}

		public function getAction(): string
		{
			return 'refuse';
		}

		public function nextStatus(): string
		{
			return 'failed';
		}
	}
	