<?php
/**
 * @file AdvertiserrptController.php
 * @author ouyangjunqiu
 * @version Created by 16/7/28 15:46
 */

namespace application\modules\zuanshi\controllers;

use application\modules\main\utils\ShopSearch;
use application\modules\zuanshi\model\AdvertiserRpt;
use application\modules\zuanshi\model\AdvertiserRptSource;
use application\modules\zuanshi\model\ShopTradeRpt;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;
use cloud\core\utils\ExtRangeDate;

class AdvertiserrptController extends Controller
{
    public function actionSource(){
        $logdate = date("Y-m-d");
        $nick = Env::getRequest("nick");
        $effectType = Env::getRequest("effectType");
        $effect = Env::getRequest("effect");
        $data = Env::getRequest("data");
        $effectType = ($effectType=="click"?"click":"impression");
        AdvertiserRptSource::model()->deleteAll("logdate=? AND nick=? AND effectType=? AND effect=?",array($logdate,$nick,$effectType,$effect));
        $model = new AdvertiserRptSource();
        $model->setAttributes(array(
            "logdate" => $logdate,
            "nick" => $nick,
            "effectType" => $effectType,
            "effect" => $effect,
            "data" => $data
        ));

        if($model->save()) {

            $rpts = json_decode($data, true);
            foreach($rpts as $rpt){
                if(!empty($rpt["logDate"])){
                    AdvertiserRpt::model()->deleteAll("logdate=? AND nick=? AND effectType=? AND effect=?",array($rpt["logDate"],$nick,$effectType,$effect));
                    $listModel = new AdvertiserRpt();
                    $listModel->setAttributes(array(
                        "logdate" => $rpt["logDate"],
                        "nick" => $nick,
                        "effectType" => $effectType,
                        "effect" => $effect,
                        "data" => \CJSON::encode($rpt)
                    ));
                    $listModel->save();
                }

            }
            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }else{
            $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
        }

    }

    public function actionIndex(){
        $data = ShopSearch::openlist();

        $this->render("index",$data);
    }

    public function actionMore(){
        $nick = Env::getSession("nick","","zuanshi.rpt.index");

        $rangeDate = ExtRangeDate::range(30);
        $beginDate = Env::getSession("begin_date",$rangeDate->startDate,"zuanshi.rpt.index");
        $endDate = Env::getSession("end_date",$rangeDate->endDate,"zuanshi.rpt.index");
        $view = Env::getRequest("view");

        if(empty($nick)){

            if(strtolower($view) == "json") {
                $this->renderJson(array("data"=>array("list"=>array(),"query"=>array("nick"=>$nick,"beginDate"=>$beginDate,"endDate"=>$endDate))));
            }else{
                $this->render("more",array("list"=>array(),"query"=>array("nick"=>$nick,"beginDate"=>$beginDate,"endDate"=>$endDate)));
            }
        }

        $list = AdvertiserRpt::fetchAllByNick($nick,$beginDate,$endDate,"click");

        if(strtolower($view) == "json") {
            $this->renderJson(array("data"=>array("list"=>$list,"query"=>array("nick"=>$nick,"beginDate"=>$beginDate,"endDate"=>$endDate))));
        }else{
            $this->render("more",array("list"=>$list,"query"=>array("nick"=>$nick,"beginDate"=>$beginDate,"endDate"=>$endDate)));
        }
    }

    public function actionGetbynick(){
        $nick = Env::getQueryDefault("nick","");
        $shopname = Env::getQueryDefault("shopname","");
        $data = AdvertiserRptSource::fetchAllByNick($nick);


        if($data === false){
            $this->renderJson(array("isSuccess"=>false));
        }else{
            $data["trade"] = ShopTradeRpt::fetchAllByShopname($shopname,16);

            $this->renderJson(array("isSuccess"=>true,"data"=>$data));
        }
    }

}