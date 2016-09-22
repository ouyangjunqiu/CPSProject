<?php
/**
 * @file CustrptController.php
 * @author ouyangjunqiu
 * @version Created by 16/9/20 17:50
 */

namespace application\modules\ztc\controllers;


use application\modules\ztc\model\CustRpt;
use application\modules\ztc\model\CustRptSource;
use cloud\core\controllers\Controller;
use cloud\core\utils\Curl;
use cloud\core\utils\Env;
use cloud\core\utils\ExtRangeDate;

class CustrptController extends Controller
{
    public function actionSource()
    {
        $logdate = date("Y-m-d");
        $nick = Env::getRequest("nick");
        $effectType = Env::getRequest("effectType");
        $effect = Env::getRequest("effect");
        $data = Env::getRequest("data");
        $effectType = ($effectType == "click" ? "click" : "impression");
        CustRptSource::model()->deleteAll("logdate=? AND nick=? AND effectType=? AND effect=?", array($logdate, $nick, $effectType, $effect));
        $model = new CustRptSource();
        $model->setAttributes(array(
            "logdate" => $logdate,
            "nick" => $nick,
            "effectType" => $effectType,
            "effect" => $effect,
            "data" => $data
        ));

        if ($model->save()) {

            $rpts = json_decode($data, true);
            foreach ($rpts as $rpt) {
                if (!empty($rpt["date"])) {
                    CustRpt::model()->deleteAll("logdate=? AND nick=? AND effectType=? AND effect=?", array($rpt["date"], $nick, $effectType, $effect));
                    $listModel = new CustRpt();
                    $listModel->setAttributes(array(
                        "logdate" => $rpt["date"],
                        "nick" => $nick,
                        "effectType" => $effectType,
                        "effect" => $effect,
                        "data" => \CJSON::encode($rpt)
                    ));
                    $listModel->save();
                }

            }
            $this->renderJson(array("isSuccess" => true, "data" => $model));
        } else {
            $this->renderJson(array("isSuccess" => false, "msg" => $model->getErrors()));
        }
    }

    public function actionGetbyapi(){
        $nick = Env::getQueryDefault("nick","");
        $rangeDate = ExtRangeDate::range(15);
        $startDate = Env::getQueryDefault("start_date",$rangeDate->startDate);
        $endDate = Env::getQueryDefault("end_date",$rangeDate->endDate);
        $url = "http://yj.da-mai.com/index.php?r=api/getCustReport";
        $curl = new Curl();
        $resp = $curl->getJson($url,array("nick"=>$nick,"startDate"=>$startDate,"endDate"=>$endDate));
        if($curl->hasError()){
            $this->renderJson(array("isSuccess" => false, "msg" => $curl->getError()));
        }

        if($resp["status"]!=1){
            $this->renderJson(array("isSuccess" => false));
        }

        $data = $resp["data"];
        if(empty($data) || !is_array($data)){
            $this->renderJson(array("isSuccess" => false));
        }


        $source = array();
        foreach($data as $k => $row){
            $logdate = date("Y-m-d",strtotime($k));
            $rpt = array_merge($row["base"],$row["effect"]);
            $rpt["paycount"] = $rpt["directpaycount"]+$rpt["indirectpaycount"];
            $rpt["favcount"] = $rpt["favitemcount"]+$rpt["favshopcount"];
            $rpt["pay"] = $rpt["directpay"]+$rpt["indirectpay"];
            $rpt["ppc"] = @round($rpt["charge"]/$rpt["click"],2);
            $rpt["roi"] = @round($rpt["pay"]/$rpt["cost"],2);
            $source["logdate"] = $logdate;
            $source[] = $rpt;
        }
        $this->renderJson(array("isSuccess" => true,"data"=>$source));

    }

    public function actionHasget(){
        $nick = Env::getRequest("nick");
        $hasget = CustRptSource::model()->exists("log_date=? AND nick=?",array(date("Y-m-d"),$nick));
        $this->renderJson(array("isSuccess" => true,"hasget"=>$hasget));

    }

    public function actionGetbyclick(){
        $nick = Env::getQueryDefault("nick","");
        $effect = Env::getQueryDefault("effect",15);
        $rangeDate = ExtRangeDate::range(30);
        $beginDate = Env::getQueryDefault("begin_date",$rangeDate->startDate);
        $endDate = Env::getQueryDefault("end_date",$rangeDate->endDate);

        $data = CustRpt::fetchByNick($nick,$beginDate,$endDate,"click",$effect);
        $this->renderJson(array("isSuccess"=>true,"data"=>$data));

    }


}