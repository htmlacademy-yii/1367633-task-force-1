<?php

namespace TaskForce\Actions;

class RespondAction extends AbstractAction
{
	const ACTION_RESPOND = 'respond';

	public function canUse($idCustomer, $idImplementer, $idUser): bool
	{
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
