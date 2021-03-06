<?php
namespace app\commands;

use yii\console\Controller;
use app\rbac\GroupRule;

class RbacController extends Controller
{
	public function actionInit($id = null)
	{
		$auth = \Yii::$app->authManager;
		// Rules
		$groupRule = new GroupRule();
		$auth->add($groupRule);
		// Roles
		$user = $auth->createRole('user');
		$user->description = 'User';
		$user->ruleName = $groupRule->name;
		$auth->add($user);
		$admin = $auth->createRole('admin');
		$admin->description = 'Admin';
		$admin->ruleName = $groupRule->name;
		$auth->add($admin);
		$auth->addChild($admin, $user);
		$superadmin = $auth->createRole('superadmin');
		$superadmin->description = 'Superadmin';
		$superadmin->ruleName = $groupRule->name;
		$auth->add($superadmin);
		$auth->addChild($superadmin, $admin);
		// Superadmin assignments
		if ($id !== null) {
			$auth->assign($superadmin, $id);
		}
	}
}