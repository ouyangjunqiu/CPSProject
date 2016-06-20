<?php
namespace application\modules\zuanshi\controllers;


use cloud\core\controllers\Controller;
use cloud\core\utils\Env;
use cloud\core\utils\ExtRangeDate;
use application\modules\main\model\Shop;
use application\modules\zuanshi\model\AccountRpt;
use application\modules\zuanshi\model\ShopTradeRpt;

class SummaryController extends Controller
{
    public function actionIndex(){
        $page = Env::getRequestWithSessionDefault("page",1,"main.default.index.page");
        $pageSize = Env::getRequestWithSessionDefault("page_size",PAGE_SIZE,"main.default.index.pagesize");
        $q = Env::getRequestWithSessionDefault("q","","main.default.index.q");
        $q = addslashes($q);
        $defaultDate = ExtRangeDate::range(7);

        $startdate = Env::getRequestWithSessionDefault("startdate",$defaultDate->startDate,"zuanshi.rpt.summary.startdate");
        $enddate = Env::getRequestWithSessionDefault("enddate",$defaultDate->endDate,"zuanshi.rpt.summary.enddate");

        $criteria = new \CDbCriteria();
        $criteria->addCondition("status='0'");

        if(!empty($q)) {
            $criteria->addCondition("(shopcatname LIKE '%{$q}%' OR shoptype LIKE '%{$q}%' OR nick LIKE '%{$q}%' OR pic LIKE '%{$q}%' OR zuanshi_pic LIKE '%{$q}%' OR bigdata_pic LIKE '%{$q}%' OR ztc_pic  LIKE '%{$q}%')");
        }

        $count = Shop::model()->count($criteria);

        $criteria->offset = ($page-1)*$pageSize;
        $criteria->limit = $pageSize;

        $list = Shop::model()->fetchAll($criteria);

        foreach($list as &$row){

            $row["rpt"] = AccountRpt::summaryByNick($startdate,$enddate,$row["nick"]);

            $row["tradeRpt"] = ShopTradeRpt::summaryByNick($startdate,$enddate,$row["shopname"]);
        }

        $this->render("index", array("list" => $list, "pager" => array("count" => $count, "page" => $page, "page_size" => $pageSize), "query" => array("q" => $q,"startdate"=>$startdate,"enddate"=>$enddate)));

    }

    public function actionPic(){
        $defaultDate = ExtRangeDate::range(7);

        $startdate = Env::getRequestWithSessionDefault("startdate",$defaultDate->startDate,"zuanshi.rpt.summary.startdate");
        $enddate = Env::getRequestWithSessionDefault("enddate",$defaultDate->endDate,"zuanshi.rpt.summary.enddate");

        $criteria = new \CDbCriteria();
        $criteria->addCondition("status='0'");

        $list = Shop::model()->fetchAll($criteria);

        $result = array();

        foreach($list as &$row){

            if(!empty($row["zuanshi_pic"])){
                $row["rpt"] = AccountRpt::summaryByNick($startdate,$enddate,$row["nick"]);

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
                $summary["ad_pv"] += $rpt["rpt"]["ad_pv"];
                $summary["click"] += $rpt["rpt"]["click"];
                $summary["charge"] += $rpt["rpt"]["charge"];
                $summary["pay"] += $rpt["rpt"]["pay"];
                $summary["pay7"] += $rpt["rpt"]["pay7"];
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