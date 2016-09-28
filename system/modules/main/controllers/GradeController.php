<?php
/**
 * @file GradeController.php
 * @author ouyangjunqiu
 * @version Created by 2016/9/28 15:31
 */

namespace application\modules\main\controllers;


use application\modules\main\model\ShopGrade;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;

class GradeController extends Controller
{
    public function actionSet(){
        $nick = Env::getRequest("nick");
        $grade = Env::getRequest("grade");
        ShopGrade::model()->deleteAll("nick=?",array($nick));
        $model = new ShopGrade();
        $model->setAttributes(array(
            "nick"=>$nick,
            "grade"=>$grade
        ));

        if($model->save()){
            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }else{
            $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
        }
    }

}