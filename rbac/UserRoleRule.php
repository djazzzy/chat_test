<?php

namespace app\rbac;

use Yii;
use app\models\User;
use yii\helpers\ArrayHelper;
use yii\rbac\Rule;

class UserRoleRule extends Rule
{
	public $name = 'userRole';
	public function execute($user, $item, $params)
	{
		//Получаем массив пользователя из базы
		$user = ArrayHelper::getValue($params, 'user', User::findOne($user));
		if ($user) {
			$role = $user->role; //Значение из поля role базы данных
			if ($item->name === 'admin') {
				return $role == User::ROLE_ADMIN;

            }elseif ($item->name === 'user') {
                return $role == User::ROLE_ADMIN
                    || $role == User::ROLE_USER;
        }
		}
		return false;
	}
}