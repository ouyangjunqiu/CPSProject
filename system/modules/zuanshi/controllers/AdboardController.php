<?php
/**
 * Created by PhpStorm.
 * User: ouyangjunqiu
 * Date: 16/4/14
 * Time: 上午11:54
 */

namespace application\modules\zuanshi\controllers;


use cloud\core\controllers\Controller;
use cloud\core\utils\Env;
use cloud\core\utils\Sorter;
use application\modules\zuanshi\model\AdboardRptSource;

class AdboardController extends Controller
{
    public function actionSource(){
        $nick = Env::getRequest("nick");
        $offset = Env::getRequest("offset");
        $data = Env::getRequest("rpt");
        $logdate = date("Y-m-d");
        $nick = trim($nick);

        AdboardRptSource::model()->deleteAll("logdate=? AND nick=? AND offset=?",array($logdate,$nick,$offset));
        $model = new AdboardRptSource();
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

    public function actionIndex(){
        $nick = Env::getRequest("nick");
        $orderby = Env::getSession("orderby","charge","zuanshi.adboard.index");
        $logdate = date("Y-m-d");
        $nick = trim($nick);
        $data = AdboardRptSource::fetchAllSummaryByCache($nick);
        if(!empty($orderby)) {
            Sorter::sort($data,$orderby);
        }

        $this->render("index",array("list"=>$data,"query"=>array("nick"=>$nick,"log_date"=>$logdate,"orderby"=>$orderby)));
    }

    public function actionHasget(){
        $nick = Env::getRequest("nick");
        $logdate = date("Y-m-d");
        $nick = trim($nick);
        $count = AdboardRptSource::model()->count("logdate=? AND nick=?",array($logdate,$nick));
        $this->renderJson(array("isSuccess"=>true,"data"=>array("hasget"=>$count>0?true:false)));
    }

}