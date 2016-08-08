<?php
namespace application\modules\zz\controllers;


use application\modules\main\utils\ShopSearch;
use application\modules\zz\model\AdvertiserRpt;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;
use cloud\core\utils\ExtRangeDate;
use application\modules\main\model\Shop;
use application\modules\zuanshi\model\ShopTradeRpt;

class SummaryController extends Controller
{
    public function actionIndex(){
        $defaultDate = ExtRangeDate::range(7);

        $startdate = Env::getSession("startdate",$defaultDate->startDate,"zuanshi.rpt.summary");
        $enddate = Env::getSession("enddate",$defaultDate->endDate,"zuanshi.rpt.summary");


        $data = ShopSearch::openlist();

        foreach($data["list"] as &$row){

            $row["rpt"] = AdvertiserRpt::fetchAllByNick($startdate,$enddate,$row["nick"],"click");

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

            if(!empty($row["zuanshi_pic"])){
                $row["rpt"] = AdvertiserRpt::fetchAllByNick($startdate,$enddate,$row["nick"],"click");

                $row["tradeRpt"] = ShopTradeRpt::summaryByNick($startdate,$enddate,$row["shopname"]);
                $row["zuanshi_pic"] = trim($row["zuanshi_pic"]);
                $result[$row["zuanshi_pic"]][$row["nick"]] = $row;
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
                "pay7" => 0,
                "tradeRpt" => 0
            );
            foreach($rpts as $rpt){
                $summary["shopcount"] ++ ;
                $summary["ad_pv"] += $rpt["rpt"]["click3"]["total"]["adPv"];
                $summary["click"] += $rpt["rpt"]["click3"]["total"]["click"];
                $summary["charge"] += $rpt["rpt"]["click3"]["total"]["charge"];
                $summary["pay"] += $rpt["rpt"]["click3"]["total"]["alipayInshopAmt"];
                $summary["pay7"] += $rpt["rpt"]["click7"]["total"]["alipayInshopAmt"];
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