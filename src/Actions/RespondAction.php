<?php

	namespace TaskForce\Actions;
	
	class RespondAction extends AbstractAction
	{
		public function getUser($idCustomer, $idImplementer, $idUser){
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
	