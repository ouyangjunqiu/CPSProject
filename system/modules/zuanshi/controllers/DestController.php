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
use application\modules\zuanshi\model\DestRptSource;
use cloud\core\utils\Sorter;

class DestController extends Controller
{
    public function actionSource(){
        $nick = Env::getRequest("nick");
        $offset = Env::getRequest("offset");
        $data = Env::getRequest("rpt");
        $logdate = date("Y-m-d");
        $nick = trim($nick);

        DestRptSource::model()->deleteAll("logdate=? AND nick=? AND offset=?",array($logdate,$nick,$offset));
        $model = new DestRptSource();
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
        $orderby = Env::getRequestWithSessionDefault("orderby","charge","zuanshi.dest.index.orderby");
        $nick = trim($nick);
        $data = DestRptSource::fetchAllSummaryByCache($nick);
        if(!empty($orderby)) {
            Sorter::sort($data,$orderby);
        }

        $this->render("index",array("list"=>$data,"query"=>array("nick"=>$nick,"orderby"=>$orderby)));

    }

    public function actionHasget(){
        $nick = Env::getRequest("nick");
        $logdate = date("Y-m-d");
        $nick = trim($nick);
        $count = DestRptSource::model()->count("logdate=? AND nick=?",array($logdate,$nick));
        $this->renderJson(array("isSuccess"=>true,"data"=>array("hasget"=>$count>0?true:false)));
    }

}