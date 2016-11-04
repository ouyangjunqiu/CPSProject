<?php
/**
 * @file ContactController.php
 * @author ouyangjunqiu
 * @version Created by 16/6/1 10:52
 */

namespace application\modules\main\controllers;


use application\modules\main\model\ShopContact;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;

/**
 * Class ContactController
 * @package application\modules\main\controllers
 */
class ContactController extends Controller
{
    /**
     *
     */
    public function actionSet(){
        $nick = Env::getRequest("nick");
        $qq = Env::getRequest("qq");
        $email = Env::getRequest("email");
        $phone = Env::getRequest("phone");
        $weixin = Env::getRequest("weixin");

        $model  = ShopContact::model()->find("nick=?",array($nick));
        if($model == null){
            $model = new ShopContact();
            $model->setIsNewRecord(true);
        }
        $model->setAttributes(
            array(
                "nick"=>$nick,
                "qq"=>$qq,
                "email"=>$email,
                "phone"=>$phone,
                "weixin"=>$weixin
            )
        );

        if($model->save()){
            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }else{
            $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
        }
    }

}