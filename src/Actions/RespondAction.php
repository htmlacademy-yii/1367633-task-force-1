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

		public function getName(): string
		{
			return 'Откликнуться';
		}

		public function getAction(): string
		{
			return 'respond';
		}

		public function nextStatus(): string
		{
			return 'processing';
		}
	}
	