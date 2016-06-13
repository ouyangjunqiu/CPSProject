<?php
/**
 * @file AdzonerptController.php
 * @author ouyangjunqiu
 * @version Created by 16/6/2 11:23
 */

namespace application\modules\zuanshi\controllers;


use application\modules\zuanshi\model\AdzoneRptSource;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;
use cloud\core\utils\Sorter;

class AdzonerptController extends Controller
{

    public function actionSource(){
        $nick = Env::getRequest("nick");
        $offset = Env::getRequest("offset");
        $data = Env::getRequest("rpt");
        $logdate = date("Y-m-d");
        $nick = trim($nick);

        AdzoneRptSource::model()->deleteAll("logdate=? AND nick=? AND offset=?",array($logdate,$nick,$offset));
        $model = new AdzoneRptSource();
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
        $logdate = date("Y-m-d");
        $nick = trim($nick);
        $count = AdzoneRptSource::model()->count("logdate=? AND nick=?",array($logdate,$nick));
        $this->renderJson(array("isSuccess"=>true,"data"=>array("hasget"=>$count>0?true:false)));

    }

    public function actionIndex(){
        $nick = Env::getRequest("nick");
        $orderby = Env::getRequestWithSessionDefault("orderby","charge","zuanshi.adzonerpt.index.orderby");
        $nick = trim($nick);
        $data = AdzoneRptSource::fetchAllSummaryByCache($nick);
        if(!empty($orderby)) {
            Sorter::sort($data,$orderby);
        }

        $this->render("index",array("list"=>$data,"query"=>array("nick"=>$nick,"orderby"=>$orderby)));
    }

}