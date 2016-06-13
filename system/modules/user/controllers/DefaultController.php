<?php

/**
 * user模块默认控制器
 * @package application.modules.user.controllers
 * @version $Id: DefaultController.php 5175 2015-06-17 13:25:24Z Aeolus $
 */

namespace application\modules\user\controllers;

use application\modules\user\model\User;
use cloud\core\controllers\Controller;

use Yii;

class DefaultController extends Controller {

	/**
	 * 登陆处理动作
	 */
	public function actionLogin() {
		$user = $_REQUEST["user"];
		if(empty($user["username"]) && !empty($user["NAME"])){
			$user["username"] = $user["NAME"];
		}
		Yii::app()->session->add("user",$user);

		$userinfo = array(
			"uid"=>$user["id"],
			"loginno"=>$user["loginno"],
			"name"=>$user["name"],
			"email"=>$user["email"],
			"telephone"=>$user["telephone"],
			"deptname"=>$user["defaultDepartmentName"]
		);

		$model = User::model()->find("uid=?",array($userinfo["uid"]));
		if($model == null){
			$model = new User();
		}
		$model->setAttributes($userinfo);
		$model->save();
		$this->renderJson(array("isSuccess"=>true));
	}

	/**
	 * 登出
	 */
	public function actionLogout() {
		Yii::app()->user->logout();
		$loginUrl = Yii::app()->urlManager->createUrl( 'user/default/login' );
		$this->success( Yii::lang( 'Logout succeed' ), $loginUrl );
	}

}
