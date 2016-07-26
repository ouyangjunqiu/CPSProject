<?php
namespace application\modules\zuanshi\controllers;
use CJSON;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;
use cloud\core\utils\ExtRangeDate;
use application\modules\main\model\Shop;
use application\modules\zuanshi\model\AccountRpt;
use application\modules\zuanshi\model\AccountRpt2;
use application\modules\zuanshi\model\AccountRptSource;
use application\modules\zuanshi\model\AccountRptSource2;
use application\modules\zuanshi\model\ShopTradeRpt;

class RptController extends Controller
{

    public function actionSource(){
        $nick = Env::getRequest("nick");
        $rpts = Env::getRequest("rpts");

        if(empty($nick) || empty($rpts))
            $this->renderJson(array("isSuccess"=>false,"msg"=>"参数错误"));

        AccountRptSource::model()->deleteAll("date=? AND nick=?",array(date("Y-m-d"),trim($nick)));
        $model = new AccountRptSource();
        $model->setIsNewRecord(true);
        $model->setAttributes(array("nick"=>trim($nick),"rpts"=>$rpts,"date"=>date("Y-m-d")));
        if($model->save()){

            $rpts = json_decode($rpts,true);
            if(isset($rpts["data"]["rptAdvertiserDayList"]) && !empty($rpts["data"]["rptAdvertiserDayList"])){
                foreach($rpts["data"]["rptAdvertiserDayList"] as $rpt){
                    $date = $rpt["logDate"];
                    AccountRpt::model()->deleteAll("log_date=? AND nick=?",array($date,$rpt["advertiserName"]));

                    $listModel = new AccountRpt();
                    $listModel->setAttributes(array(
                        "advertiser_id"=>$rpt["advertiserId"],
                        "nick"=> $rpt["advertiserName"],
                        "ad_pv"=> $rpt["adPv"],
                        "charge"=> $rpt["charge"],
                        "click"=> $rpt["click"],
                        "ctr"=> $rpt["ctr"],
                        "log_date"=> $rpt["logDate"],
                        "ecpc"=> $rpt["ecpc"],
                        "ecpm"=> $rpt["ecpm"],
                        "roi"=> $rpt["roi"],
                        "roi7"=> $rpt["roi7"],
                        "roi15"=> $rpt["roi15"],
                        "extra"=>json_encode($rpt)
                    ));
                    $listModel->save();
                }
            }
            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }else{
            $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
        }
    }

    public function actionSource2(){
        $nick = Env::getRequest("nick");
        $rpts = Env::getRequest("rpts");

        if(empty($nick) || empty($rpts))
            $this->renderJson(array("isSuccess"=>false,"msg"=>"参数错误"));

        $model = new AccountRptSource2();
        $model->setIsNewRecord(true);
        $model->setAttributes(array("nick"=>trim($nick),"userinfo"=>"","rpts"=>$rpts,"date"=>date("Y-m-d")));
        if($model->save()){

            $rpts = json_decode($rpts,true);
            if(isset($rpts["data"]["rptAdvertiserDayList"]) && !empty($rpts["data"]["rptAdvertiserDayList"])){
                foreach($rpts["data"]["rptAdvertiserDayList"] as $rpt){
                    $date = $rpt["logDate"];
                    AccountRpt2::model()->deleteAll("log_date=? AND nick=?",array($date,$rpt["advertiserName"]));

                    $listModel = new AccountRpt2();
                    $listModel->setAttributes(array(
                        "advertiser_id"=>$rpt["advertiserId"],
                        "nick"=> $rpt["advertiserName"],
                        "ad_pv"=> $rpt["adPv"],
                        "charge"=> $rpt["charge"],
                        "click"=> $rpt["click"],
                        "ctr"=> $rpt["ctr"],
                        "log_date"=> $rpt["logDate"],
                        "ecpc"=> $rpt["ecpc"],
                        "ecpm"=> $rpt["ecpm"],
                        "roi"=> $rpt["roi"],
                        "roi7"=> $rpt["roi7"],
                        "roi15"=> $rpt["roi15"],
                        "extra"=>json_encode($rpt)
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

        $page = Env::getSession("page",1,"main.default.index");
        $pageSize = Env::getSession("page_size",PAGE_SIZE,"main.default.index");
        $q = Env::getSession("q","","main.default.index");

        $pic = Env::getSession("pic","","main.default.index");

        $criteria = new \CDbCriteria();
        $criteria->addCondition("status='0'");
        if(!empty($pic)) {
            $criteria->addCondition("(pic LIKE '%{$pic}%' OR zuanshi_pic LIKE '%{$pic}%' OR bigdata_pic LIKE '%{$pic}%' OR ztc_pic  LIKE '%{$pic}%')");
        }
        if(!empty($q)) {
            $criteria->addCondition("(shopcatname LIKE '%{$q}%' OR shoptype LIKE '%{$q}%' OR nick LIKE '%{$q}%' OR pic LIKE '%{$q}%' OR zuanshi_pic LIKE '%{$q}%' OR bigdata_pic LIKE '%{$q}%' OR ztc_pic  LIKE '%{$q}%')");
        }

        $count = Shop::model()->count($criteria);

        $criteria->offset = ($page-1)*$pageSize;
        $criteria->limit = $pageSize;

        $list = Shop::model()->fetchAll($criteria);

        $this->render("index",array(
            "list"=>$list,
            "pager"=>array(
                "count"=>$count,
                "page"=>$page,
                "page_size"=>$pageSize
            ),
            "query"=>array("q"=>$q,"pic"=>$pic)
        ));
    }


    public function actionIndex2(){

        $page = Env::getSession("page",1,"main.default.index");
        $pageSize = Env::getSession("page_size",PAGE_SIZE,"main.default.index");
        $q = Env::getSession("q","","main.default.index");
        $page = (int)$page;
        $pageSize = (int)$pageSize;

        $pic = Env::getSession("pic","","main.default.index");

        $criteria = new \CDbCriteria();
        $criteria->addCondition("status='0'");
        if(!empty($q)) {
            $criteria->addCondition("(nick LIKE '%{$q}%' OR pic LIKE '%{$q}%' OR zuanshi_pic LIKE '%{$q}%' OR bigdata_pic LIKE '%{$q}%' OR ztc_pic  LIKE '%{$q}%')");
        }
        if(!empty($pic)) {
            $criteria->addCondition("(pic LIKE '%{$pic}%' OR zuanshi_pic LIKE '%{$pic}%' OR bigdata_pic LIKE '%{$pic}%' OR ztc_pic  LIKE '%{$pic}%')");
        }

        $count = Shop::model()->count($criteria);

        $criteria->offset = ($page-1)*$pageSize;
        $criteria->limit = $pageSize;

        $list = Shop::model()->fetchAll($criteria);
        $date = date("Y-m-d");
        foreach($list as &$row){
            $row["rpt"] = AccountRptSource2::model()->fetch("nick='{$row["nick"]}' AND date='{$date}'");

        }


        $this->render("index2",array("list"=>$list,"pager"=>array("count"=>$count,"page"=>$page,"page_size"=>$pageSize),"query"=>array("q"=>$q,"pic"=>$pic)));

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

        $list = AccountRpt::model()->fetchAll("log_date>=? AND log_date<=? AND nick=?",array($beginDate,$endDate,$nick));

        foreach($list as &$rpt){
            if(!empty($rpt["extra"])) {
                $extra = CJSON::decode($rpt["extra"], true);
                $rpt["extra"] = $extra;
            }else{
                $rpt["extra"] = array();
            }
        }


        if(strtolower($view) == "json") {
            $this->renderJson(array("data"=>array("list"=>$list,"query"=>array("nick"=>$nick,"beginDate"=>$beginDate,"endDate"=>$endDate))));
        }else{
            $this->render("more",array("list"=>$list,"query"=>array("nick"=>$nick,"beginDate"=>$beginDate,"endDate"=>$endDate)));
        }
    }

    public function actionHasget(){
        $nick = Env::getRequest("nick");
        $nick = trim($nick);
        $date = date("Y-m-d");
        $exists = AccountRptSource::model()->exists("nick='$nick' AND date='{$date}'");
        $this->renderJson(array("isSuccess"=>true,"data"=>array("hasget"=>$exists)));
    }

    public function actionHasget2(){
        $nick = Env::getRequest("nick");
        if(empty($nick)){
            $this->renderJson(array("isSuccess"=>true,"data"=>array("hasget"=>true)));
        }

        //8点之前不采集数据,主要针对获取不正确的数据
        $hour = date("H");
        $hour = (int)$hour;
        if($hour < 8){
            $this->renderJson(array("isSuccess"=>true,"data"=>array("hasget"=>true)));
        }

        $nick = trim($nick);
        $date = date("Y-m-d");
        $exists = AccountRptSource::model()->exists("date=? AND nick=?",array($date,$nick));
        $exists2 = AccountRptSource2::model()->exists("date=? AND nick=?",array($date,$nick));
        $this->renderJson(array("isSuccess"=>true,"data"=>array("hasget"=>$exists && $exists2)));
    }

    public function actionGetbynick(){
        $nick = Env::getRequest("nick");
        $shopname = Env::getRequest("shopname");
        $nick = trim($nick);
        $date = date("Y-m-d");
        $rptSource = AccountRptSource::model()->fetch("date=? AND nick=?",array($date,$nick));
        if(empty($rptSource)){
            $this->renderJson(array("isSuccess"=>false,"data"=>array("list"=>array())));
            return;
        }
        $rpts = json_decode($rptSource["rpts"],true);
        if(isset($rpts["data"]["rptAdvertiserDayList"]) && !empty($rpts["data"]["rptAdvertiserDayList"])) {
            $data = array();
            $total = array(
                "pay" => 0,
                "pay7" => 0,
                "pay15" => 0,
                "favcount" =>0,
                "roi"=>0,
                "roi3"=>0,
                "roi7"=>0,
                "roi15"=>0,
            );
            $tradeRpt = ShopTradeRpt::fetchAllByLast15Days($shopname);

            foreach ($rpts["data"]["rptAdvertiserDayList"] as $rpt) {

                $trade = array("payAmt"=>0,"payAmtStr"=>"-","chargeRateStr"=>"-");
                if(isset($tradeRpt[$rpt["logDateStr"]]["payAmt"])){
                    $trade["payAmtStr"] = $trade["payAmt"] = $tradeRpt[$rpt["logDateStr"]]["payAmt"];
                    $trade["chargeRateStr"] = @round($rpt["charge"]/$tradeRpt[$rpt["logDateStr"]]["payAmt"]*100,2);
                }
                $data[] = array_merge(array(
                    "date" => $rpt["logDateStr"],
                    "pv" => $rpt["adPv"],
                    "click" => $rpt["click"],
                    "charge" => $rpt["charge"],
                    "ecpc" => $rpt["ecpc"],
                    "paycount" => $rpt["alipayInShopNum"],
                    "roi3" => $rpt["roi"],
                    "ctr" => $rpt["ctrStr"],
                    "favcount" => $rpt["dirShopColNum"] + $rpt["inshopItemColNum"]
                ),$rpt,$trade);

                $total["pay"] += $rpt["charge"]*$rpt["roi"];
                $total["pay7"] += $rpt["charge"]*$rpt["roi7"];
                $total["pay15"] += $rpt["charge"]*$rpt["roi15"];
                $total["favcount"] += ($rpt["dirShopColNum"] + $rpt["inshopItemColNum"]);
            }

            $total["roi"] = $total["roi3"] = round(@($total["pay"]/$rpts["data"]["rptAdvertiserDayTotal"]["charge"]),2);
            $total["roi7"] = round(@($total["pay7"]/$rpts["data"]["rptAdvertiserDayTotal"]["charge"]),2);
            $total["roi15"] = round(@($total["pay15"]/$rpts["data"]["rptAdvertiserDayTotal"]["charge"]),2);
            $totalRpt = array_merge(
                $rpts["data"]["rptAdvertiserDayTotal"],
                $total,
                array(
                    "payAmtStr"=>isset($tradeRpt["total_pay_amt"])?$tradeRpt["total_pay_amt"]:"-",
                    "chargeRateStr"=>isset($tradeRpt["total_pay_amt"])?@round($rpts["data"]["rptAdvertiserDayTotal"]["charge"]/$tradeRpt["total_pay_amt"]*100,2):"-"
                )
            );

            $this->renderJson(array("isSuccess"=>true,"data"=>array("list"=>$data,"total"=>$totalRpt)));


        }else{
            $this->renderJson(array("isSuccess"=>true,"data"=>array("list"=>array())));
            return;
        }
    }

    public function actionWeek(){
        $page = Env::getSession("page",1,"main.default.index");
        $pageSize = Env::getSession("page_size",20,"main.default.index");
        $nick = Env::getSession("nick","","main.default.index");
        $pic = Env::getSession("pic","","main.default.index");
        $shoptype = Env::getSession("shoptype","","main.default.index");

        $pic = addslashes($pic);

        $criteria = new \CDbCriteria();
        $criteria->addCondition("status='0'");
        if(!empty($nick)) {
            $criteria->addSearchCondition("nick",$nick);
        }
        if(!empty($pic)) {
            $criteria->addCondition("(zuanshi_pic LIKE '%{$pic}%' OR bigdata_pic LIKE '%{$pic}%' OR ztc_pic  LIKE '%{$pic}%')");
        }
        if(!empty($shoptype)) {
            $criteria->addCondition("shoptype = '{$shoptype}'");
        }

        $count = Shop::model()->count($criteria);

        $criteria->offset = ($page-1)*$pageSize;
        $criteria->limit = $pageSize;

        $list = Shop::model()->fetchAll($criteria);

        foreach($list as &$row){
            $row["lastWeekRpt"] = AccountRpt::summaryLastWeekByNick($row["nick"]);
            $row["weekRpt"] = AccountRpt::summaryWeekByNick($row["nick"]);
            $row["lastWeekTradeRpt"] = ShopTradeRpt::summaryLastWeekByNick($row["shopname"]);
            $row["weekTradeRpt"] = ShopTradeRpt::summaryWeekByNick($row["shopname"]);
        }

        $this->render("weektable", array("list" => $list, "pager" => array("count" => $count, "page" => $page, "page_size" => $pageSize), "query" => array("nick" => $nick, "pic" => $pic, "shoptype" => $shoptype)));

    }

}