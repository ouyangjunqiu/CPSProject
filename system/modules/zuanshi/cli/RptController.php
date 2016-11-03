<?php
namespace application\modules\zuanshi\cli;

use application\modules\main\model\Shop;
use application\modules\zuanshi\model\AccountRpt;
use application\modules\zz\model\AdvertiserMonthRpt;
use application\modules\zz\model\AdvertiserRpt;
use cloud\core\cli\Controller;

class RptController  extends Controller
{

    public function actionTransfer(){
        $fields3 = array(
            "adPv"=>"adPv",
            "alipayInShopNum"=>"alipayInShopNum",
            "charge"=>"charge",
            "click"=>"click",
            "cartNum"=>"cartNum3",
            "ctr"=>"ctr",
            "cvr"=>"cvr3",
            "dirShopColNum"=>"dirShopColNum",
            "ecpc"=>"ecpc",
            "ecpm"=>"ecpm",
            "inshopItemColNum"=>"inshopItemColNum",
            "logDate"=>"logDate",
            "memberId"=>"advertiserId",
            "roi"=>"roi",
            "uv"=>"clickUv"
        );
        $fields7 = array(
            "adPv"=>"adPv",
            "alipayInShopNum"=>"alipayInShopNum7",
            "charge"=>"charge",
            "click"=>"click",
            "cartNum"=>"cartNum7",
            "ctr"=>"ctr",
            "cvr"=>"cvr7",
            "dirShopColNum"=>"dirShopColNum",
            "ecpc"=>"ecpc",
            "ecpm"=>"ecpm",
            "inshopItemColNum"=>"inshopItemColNum",
            "logDate"=>"logDate",
            "memberId"=>"advertiserId",
            "roi"=>"roi7",
            "uv"=>"clickUv"
        );
        $fields15 = array(
            "adPv"=>"adPv",
            "alipayInShopNum"=>"alipayInShopNum15",
            "charge"=>"charge",
            "click"=>"click",
            "cartNum"=>"cartNum15",
            "ctr"=>"ctr",
            "cvr"=>"cvr15",
            "dirShopColNum"=>"dirShopColNum",
            "ecpc"=>"ecpc",
            "ecpm"=>"ecpm",
            "inshopItemColNum"=>"inshopItemColNum",
            "logDate"=>"logDate",
            "memberId"=>"advertiserId",
            "roi"=>"roi15",
            "uv"=>"clickUv"
        );

        $count = AccountRpt::model()->count("log_date<?",array("2016-07-12"));
        $p = ceil($count/200);
        for($i=0;$i<=$p;$i++){
            $offset = $i*200;
            $c = new \CDbCriteria();
            $c->addCondition("log_date<='2016-07-12'");
            $c->offset = $offset;
            $c->limit = 200;
            $list = AccountRpt::model()->fetchAll($c);
            foreach($list as $row) {
                $rpt = \CJSON::decode($row["extra"]);

                $rpt3 = $rpt7 = $rpt15 = array();
                foreach ($fields3 as $f => $t) {
                    $rpt3[$f] = empty($rpt[$t])?0:$rpt[$t];
                }

                foreach ($fields7 as $f => $t) {
                    $rpt7[$f] = empty($rpt[$t])?0:$rpt[$t];
                }

                foreach ($fields15 as $f => $t) {
                    $rpt15[$f] = empty($rpt[$t])?0:$rpt[$t];
                }

                AdvertiserRpt::model()->deleteAll("logdate=? AND nick=?", array($row["log_date"], $row["nick"]));
                $m = new AdvertiserRpt();
                $m->setAttributes(array(
                    "nick" => $row["nick"],
                    "logdate" => $row["log_date"],
                    "effectType" => "click",
                    "effect" => 3,
                    "data" => \CJSON::encode($rpt3)
                ));
                if (!$m->save()) {
                    print_r($m->getErrors());
                }

                $m2 = new AdvertiserRpt();
                $m2->setAttributes(array(
                    "nick" => $row["nick"],
                    "logdate" => $row["log_date"],
                    "effectType" => "click",
                    "effect" => 7,
                    "data" => \CJSON::encode($rpt7)
                ));
                if (!$m2->save()) {
                    print_r($m2->getErrors());
                }

                $m3 = new AdvertiserRpt();
                $m3->setAttributes(array(
                    "nick" => $row["nick"],
                    "logdate" => $row["log_date"],
                    "effectType" => "click",
                    "effect" => 15,
                    "data" => \CJSON::encode($rpt15)
                ));
                if (!$m3->save()) {
                    print_r($m3->getErrors());
                }
            }

        }
    }

    public function actionMonth(){

        for($i=1;$i<=7;$i++){
            $firstday = date('Y-m-01', strtotime("2016-0$i-05"));
            $lastday = date('Y-m-d', strtotime("$firstday +1 month -1 day"));
            $year = date("Y",strtotime($lastday));
            $month = date("m",strtotime($lastday));

            $criteria = new \CDbCriteria();
            $criteria->addCondition("status='0'");
            $shops = Shop::model()->fetchAll($criteria);
            foreach($shops as $shop){
                $total = AccountRpt::summaryByNick($firstday,$lastday,$shop["nick"]);
                if(empty($total) || empty($total["ad_pv"]))
                    continue;

                AdvertiserMonthRpt::model()->deleteAll("logyear=? AND nick=? AND logmonth=?",array($year,$shop["nick"],$month));

                $data = array(
                    "adPv"=>$total["ad_pv"],
                    "charge"=>$total["charge"],
                    "click"=>$total["click"],
                    "alipayInshopAmt"=>$total["pay"],
                    "alipayInshopAmt7"=>$total["pay7"],
                );
                $model = new AdvertiserMonthRpt();
                $model->setAttributes(
                    array(
                        "logyear"=>$year,
                        "nick"=>$shop["nick"],
                        "logmonth"=>$month,
                        "data"=>\CJSON::encode($data),
                        "logdate"=>date("Y-m-d")
                    )
                );
                if(!$model->save()){
                    print_r($model->getErrors());
                }
            }
        }

    }

}