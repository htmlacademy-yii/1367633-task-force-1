<?php

namespace TaskForce\Actions;

class RefuseAction extends AbstractAction
{
	const ACTION_REFUSE = 'refuse';

	public function canUse($idCustomer, $idImplementer, $idUser): bool
	{
		return $idImplementer === $idUser;
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
