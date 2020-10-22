<?php

namespace TaskForce\Actions;

class RefuseAction extends AbstractAction
{
	public function canUse($idCustomer, $idImplementer, $idUser): bool
	{
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
