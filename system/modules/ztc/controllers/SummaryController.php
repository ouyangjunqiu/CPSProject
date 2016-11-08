<?php
namespace application\modules\ztc\controllers;


use application\modules\main\utils\ShopSearch;
use application\modules\ztc\model\CustRpt;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;
use cloud\core\utils\ExtRangeDate;
use application\modules\main\model\Shop;
use application\modules\sycm\model\ShopTradeRpt;

class SummaryController extends Controller
{
    public function actionIndex(){
        $defaultDate = ExtRangeDate::range(7);

        $startdate = Env::getSession("startdate",$defaultDate->startDate,"zuanshi.rpt.summary");
        $enddate = Env::getSession("enddate",$defaultDate->endDate,"zuanshi.rpt.summary");


        $data = ShopSearch::openlist();

        foreach($data["list"] as &$row){

            $row["rpt"] = CustRpt::fetchByNick($row["nick"],$startdate,$enddate,"click",15);

            $row["tradeRpt"] = ShopTradeRpt::summaryByNick($startdate,$enddate,$row["shopname"]);
        }

        $data["query"]["startdate"] = $startdate;
        $data["query"]["enddate"] = $enddate;
        $this->render("index",$data);

    }

    public function actionPic(){
        $defaultDate = ExtRangeDate::range(7);

        $startdate = Env::getSession("startdate",$defaultDate->startDate,"zuanshi.rpt.summary");
        $enddate = Env::getSession("enddate",$defaultDate->endDate,"zuanshi.rpt.summary");

        $criteria = new \CDbCriteria();
        $criteria->addCondition("status='0'");

        $list = Shop::model()->fetchAll($criteria);

        $result = array();

        foreach($list as &$row){

            if(!empty($row["ztc_pic"])){
                $row["rpt"] = CustRpt::fetchByNick($row["nick"],$startdate,$enddate,"click",15);

                $row["tradeRpt"] = ShopTradeRpt::summaryByNick($startdate,$enddate,$row["shopname"]);
                $row["ztc_pic"] = trim($row["ztc_pic"]);
                $result[$row["ztc_pic"]][$row["nick"]] = $row;
            }
        }

        $list = array();
        foreach($result as $key=>$rpts){

            $summary = array(
                "shopcount" => 0,
                "ad_pv" => 0,
                "click" => 0,
                "charge" => 0,
                "pay" => 0,
                "tradeRpt" => 0
            );
            foreach($rpts as $rpt){
                $summary["shopcount"] ++ ;
                $summary["ad_pv"] += $rpt["rpt"]["total"]["impressions"];
                $summary["click"] += $rpt["rpt"]["total"]["click"];
                $summary["charge"] += $rpt["rpt"]["total"]["cost"];
                $summary["pay"] += $rpt["rpt"]["total"]["pay"];
                $summary["tradeRpt"] += $rpt["tradeRpt"]["total_pay_amt"];
            }

            $list[$key] =  $summary;
        }

        $this->render("pic",array(
            "list"=>$list,
            "query" => array(
                "startdate"=>$startdate,
                "enddate"=>$enddate
            )
        ));
    }

}