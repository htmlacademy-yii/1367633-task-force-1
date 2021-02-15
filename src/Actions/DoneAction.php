<?php

namespace TaskForce\Actions;

class DoneAction extends AbstractAction
{
	const ACTION_DONE = 'done';

	public function canUse($idCustomer, $idImplementer, $idUser): bool
	{
		return $idCustomer === $idUser;
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
