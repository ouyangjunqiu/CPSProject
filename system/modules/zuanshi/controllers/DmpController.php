<?php
namespace application\modules\zuanshi\controllers;

use application\modules\zuanshi\model\Dmp;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;

class DmpController extends Controller {

    public function actionSource(){
        $nick = Env::getRequest("nick");
        $data = Env::getRequest("data");
        $logdate = date("Y-m-d");
        $logtime = date("H:i:s");

        Dmp::model()->deleteAll("logdate=? AND nick=?",array($logdate,$nick));

        $arr = array(
            "nick"=>$nick,
            "data"=>$data,
            "logdate"=>$logdate,
            "logtime"=>$logtime
        );

        $model = new Dmp();
        $model->setAttributes($arr);
        if($model->save()) {
            $this->renderJson(array("isSuccess" => true, "data" => $model));
        }else{
            $this->renderJson(array("isSuccess" => false, "data" => $model->getErrors()));
        }
    }
}