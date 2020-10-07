<?php

	namespace TaskForce\Actions;
	
	class RefuseAction extends AbstractAction
	{
		public function getUser($idCustomer, $idImplementer, $idUser){
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
	}
	