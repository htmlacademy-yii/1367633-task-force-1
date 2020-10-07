<?php

	namespace TaskForce\Actions;
	
	class CancelAction extends AbstractAction
	{
		public function getUser($idCustomer, $idImplementer, $idUser){
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
	}
	