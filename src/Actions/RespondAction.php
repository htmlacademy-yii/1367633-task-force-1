<?php

	namespace TaskForce\Actions;
	
	/**
	 * RespondAction class наследует от AbstractAction, возвращает действие 'Откликнуться'
	 */
	class RespondAction extends AbstractAction
	{
		public function canUse($idCustomer, $idImplementer, $idUser){
			return $idCustomer !== $idUser;
		}

		public function getName()
		{
			return 'Откликнуться';
		}

		public function getAction()
		{
			return 'respond';
		}

		public function nextStatus()
		{
			return 'processing';
		}
	}
	