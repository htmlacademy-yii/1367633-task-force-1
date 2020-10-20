<?php

	namespace TaskForce\Actions;
	
	class DoneAction extends AbstractAction
	{
		public function getUser($idCustomer, $idImplementer, $idUser): bool
		{
			return $idImplementer !== $idUser;
		}

		public function getName(): string
		{
			return 'Выполнено';
		}

		public function getAction(): string
		{
			return 'done';
		}

		public function nextStatus(): string
		{
			return 'performed';
		}
	}
	