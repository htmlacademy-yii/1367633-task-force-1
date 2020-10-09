<?php

	namespace TaskForce\Actions;
	
	class DoneAction extends AbstractAction
	{
		public function getUser($idCustomer, $idImplementer, $idUser){
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
	