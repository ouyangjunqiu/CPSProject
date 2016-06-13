<?php
/**
 * Created by PhpStorm.
 * User: ouyangjunqiu
 * Date: 16/4/14
 * Time: 上午11:54
 */

namespace application\modules\bigdata\controllers;


use application\modules\bigdata\model\DestRptSourceHistory;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;

class DestController extends Controller
{
    public function actionSource(){
        $nick = Env::getRequest("nick");
        $offset = Env::getRequest("offset");
        $data = Env::getRequest("rpt");
        $logdate = Env::getRequest("logdate");
        $nick = trim($nick);

        DestRptSourceHistory::model()->deleteAll("logdate=? AND nick=? AND offset=?",array($logdate,$nick,$offset));
        $model = new DestRptSourceHistory();
        $model->setAttributes(array(
            "nick"=>$nick,
            "offset"=>$offset,
            "logdate"=>$logdate,
            "data"=>$data
        ));

        if($model->save()){
            $this->renderJson(array(
                "isSuccess"=>true,
                "data"=>$model
            ));
        }else{
            $this->renderJson(array(
                "isSuccess"=>false,
                "data"=>$model->getErrors()
            ));
        }
    }

    public function actionHasget(){
        $nick = Env::getRequest("nick");
        $logdate = Env::getRequest("logdate");
        $nick = trim($nick);
        $count = DestRptSourceHistory::model()->count("logdate=? AND nick=?",array($logdate,$nick));
        $this->renderJson(array("isSuccess"=>true,"data"=>array("hasget"=>$count>0?true:false)));
    }

}