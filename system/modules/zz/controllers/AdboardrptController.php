<?php
/**
 * Created by PhpStorm.
 * User: ouyangjunqiu
 * Date: 16/4/14
 * Time: 上午11:54
 */

namespace application\modules\zz\controllers;


use application\modules\zuanshi\model\AboardPackage;
use application\modules\zz\model\AdboardRptHistory;
use application\modules\zz\model\AdboardWeekRpt;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;
use cloud\core\utils\Sorter;

class AdboardrptController extends Controller
{
    public function actionGetbynick(){
        $nick = Env::getRequest("nick");

        if(empty($nick)){
            return $this->renderJson(array("isSuccess"=>false,));
        }

        $logdate = Env::getQueryDefault("logdate",date("Y-m-d",strtotime("-1 days")));
        $effect = Env::getQueryDefault("effect",7);

        $data = AdboardRptHistory::fetchAllByNick($logdate,$logdate,$nick,"click",$effect);

        $this->renderJson(array(
            "isSuccess"=>true,
            "data"=>$data,
            "query"=>array(
                "nick"=>$nick,
                "logdate"=>$logdate,
                "effect"=>$effect
            )
        ));

    }

    public function actionWeek(){
        $nick = Env::getRequest("nick");
        $orderby = Env::getQueryDefault("orderby","charge");
        $date = Env::getQueryDefault("date",date("Y-m-d"));
        $w  = date('w',strtotime($date));
        $now_start = date('Y-m-d',strtotime("$date -".($w ? $w - 1 : 6).' days')); //获取本周开始日期，如果$w是0，则表示周日，减去 6 天

        $begindate = date('Y-m-d',strtotime("$now_start -7 days"));  //上周开始日期
        $enddate = date('Y-m-d',strtotime("$begindate + 6 days"));  //上周结束日期

        $nick = trim($nick);
        $source = AdboardWeekRpt::model()->fetch("begindate=? AND enddate=? AND nick=?",array($begindate,$enddate,$nick));
        $data = array();
        if(!empty($source)) {

            $data = \CJSON::decode($source["data"]);
            if(!empty($data) && !empty($orderby)) {
                Sorter::sort($data,$orderby);
            }

            if(count($data)>5){
                $data = array_slice($data,0,5);
            }

            foreach($data as &$row){
                $package = AboardPackage::model()->fetch("adboardId=?",array($row["adboardId"]));
                if(!empty($package)){
                    $packageData = \CJSON::decode($package["data"]);
                    $row["imagePath"] = $packageData["imagePath"];
                }else{
                    $row["imagePath"] = "";
                }
            }
            $this->renderJson(array(
                "isSuccess"=>true,
                "data"=>$data,
                "query"=>array(
                    "nick"=>$nick,
                    "begindate"=>$begindate,
                    "enddate"=>$enddate,
                    "orderby"=>$orderby
                )
            ));

        }else{
            $this->renderJson(array(
                "isSuccess"=>false,
                "data"=>array(),
                "query"=>array(
                    "nick"=>$nick,
                    "begindate"=>$begindate,
                    "enddate"=>$enddate,
                    "orderby"=>$orderby
                )
            ));
        }

    }

}