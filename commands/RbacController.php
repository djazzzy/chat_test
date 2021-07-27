<?php

namespace app\commands;

use Yii;
use app\models\User;
use yii\console\Controller;
//use common\components\rbac\UserRoleRule;

class RbacController extends Controller
{
	public function actionInit()
	{
		$auth = Yii::$app->authManager;
		$auth->removeAll();

		$userRoleRule = new \app\rbac\UserRoleRule();
        $auth->add($userRoleRule);

		$adminka = $auth->createPermission('adminka');
		$adminka->description = 'Админка';
		$auth->add($adminka);

		$user = $auth->createRole('user');
		$user->description = 'Пользователь';
		$user->ruleName = $userRoleRule->name;
		$auth->add($user);

		$admin = $auth->createRole('admin');
		$admin->description = 'Администратор';
		$admin->ruleName = $userRoleRule->name;
		$auth->add($admin);
		$auth->addChild($admin, $user);
		$auth->addChild($admin, $adminka);

		$this->stdout('Done!' . PHP_EOL);
	}
}