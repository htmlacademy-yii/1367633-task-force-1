<?php

namespace TaskForce\Rule;

use Yii;
use yii\filters\AccessRule;
use frontend\models\User;

class CustomerAccess extends AccessRule
{
	public function allows($action, $user, $request)
	{
		$parent = parent::allows($action, $user, $request);

		if ($parent !== true) {
			return $parent;
		}

		$role = Yii::$app->user->identity->role;
		return ($role === User::ROLE_CUSTOMER);
	}
}
