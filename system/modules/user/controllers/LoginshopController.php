<?php
/**
 * @file LoginshopController.php
 * @author ouyangjunqiu
 * @version Created by 16/6/7 15:35
 */

namespace application\modules\user\controllers;


use application\modules\user\model\UserLoginShopLog;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;

class LoginshopController extends Controller
{
    public function actionSource(){
        $username = Env::getRequest("username");
        $nick = Env::getRequest("nick");
        $login_type = Env::getRequest("login_type");
        $logdate = date("Y-m-d");
        $logtime = date("H:i:s");

        $attr = array(
            "username" => $username,
            "nick" => $nick,
            "login_type" => $login_type,
            "logdate" => $logdate,
            "logtime" => $logtime
        );
        $model = new UserLoginShopLog();
        $model->setAttributes($attr);

        if($model->save()){
            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }else{
            $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
        }
    }

}