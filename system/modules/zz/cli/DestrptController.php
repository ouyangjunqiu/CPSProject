<?php
namespace application\modules\zz\cli;
use application\modules\main\model\Shop;
use application\modules\zz\model\DestE15Rpt;
use application\modules\zz\model\DestE3Rpt;
use application\modules\zz\model\DestE7Rpt;
use application\modules\zz\model\DestRptHistory;
use application\modules\zz\model\DestWeekRpt;
use cloud\core\cli\Controller;

/**
 * @file AdboardrptController.php
 * @author ouyangjunqiu
 * @version Created by 16/8/16 09:41
 */
class DestrptController extends Controller
{
    public function actionE3(){
        $fields = array(
            "campaignId",
            "campaignName",
            "transId",
            "transName",
            "targetId",
            "targetName",
            "destType",
            "adPv",
            "alipayInShopNum",
            "alipayInshopAmt",
            "avgAccessPageNum",
            "avgAccessTime",
            "cartNum",
            "charge",
            "click",
            "ctr",
            "cvr",
            "deepInshopUv",
            "dirShopColNum",
            "ecpc",
            "ecpm",
            "gmvInshopAmt",
            "gmvInshopNum",
            "inshopItemColNum",
            "roi",
            "uv"
        );

        for($i=6;$i>3;$i--){
            $logdate = date('Y-m-d',strtotime("-$i days"));
            $criteria = new \CDbCriteria();
            $criteria->addCondition("status='0'");
            $shops = Shop::model()->fetchAll($criteria);
            foreach($shops as $shop){
                $sources = DestRptHistory::model()->fetchAll("logdate=? AND nick=? AND effectType=? AND effect=?",array($logdate,$shop["nick"],"click",3));
                if(empty($sources))
                    continue;
                foreach($sources as $source){
                    $data =  \CJSON::decode($source["data"]);
                    if(!empty($data) && !empty($data["result"])){

                        foreach($data["result"] as $row){
                            $rpt = array(
                                "logdate"=>$logdate,
                                "nick"=>$shop["nick"]
                            );
                            foreach($fields as $f){
                                $rpt[$f] = $row[$f];
                            }

                            DestE3Rpt::model()->deleteAll("logdate=? AND nick=? AND campaignId=? AND transId=? AND targetId=?",array($rpt["logdate"],$rpt["nick"],$rpt["campaignId"],$rpt["transId"],$rpt["targetId"]));
                            $model = new DestE3Rpt();
                            $model->setAttributes($rpt);
                            if(!$model->save()){
                                print_r($model->getErrors());
                            }
                        }

                    }
                }

            }
        }
    }


    public function actionE7(){
        $fields = array(
            "campaignId",
            "campaignName",
            "transId",
            "transName",
            "targetId",
            "targetName",
            "destType",
            "adPv",
            "alipayInShopNum",
            "alipayInshopAmt",
            "avgAccessPageNum",
            "avgAccessTime",
            "cartNum",
            "charge",
            "click",
            "ctr",
            "cvr",
            "deepInshopUv",
            "dirShopColNum",
            "ecpc",
            "ecpm",
            "gmvInshopAmt",
            "gmvInshopNum",
            "inshopItemColNum",
            "roi",
            "uv"
        );

        for($i=9;$i>6;$i--){
            $logdate = date('Y-m-d',strtotime("-$i days"));
            $criteria = new \CDbCriteria();
            $criteria->addCondition("status='0'");
            $shops = Shop::model()->fetchAll($criteria);
            foreach($shops as $shop){
                $sources = DestRptHistory::model()->fetchAll("logdate=? AND nick=? AND effectType=? AND effect=?",array($logdate,$shop["nick"],"click",7));
                if(empty($sources))
                    continue;
                foreach($sources as $source){
                    $data =  \CJSON::decode($source["data"]);
                    if(!empty($data) && !empty($data["result"])){

                        foreach($data["result"] as $row){
                            $rpt = array(
                                "logdate"=>$logdate,
                                "nick"=>$shop["nick"]
                            );
                            foreach($fields as $f){
                                $rpt[$f] = $row[$f];
                            }

                            DestE7Rpt::model()->deleteAll("logdate=? AND nick=? AND campaignId=? AND transId=? AND targetId=?",array($rpt["logdate"],$rpt["nick"],$rpt["campaignId"],$rpt["transId"],$rpt["targetId"]));
                            $model = new DestE7Rpt();
                            $model->setAttributes($rpt);
                            if(!$model->save()){
                                print_r($model->getErrors());
                            }
                        }

                    }
                }

            }
        }
    }

    public function actionE15(){
        $fields = array(
            "campaignId",
            "campaignName",
            "transId",
            "transName",
            "targetId",
            "targetName",
            "destType",
            "adPv",
            "alipayInShopNum",
            "alipayInshopAmt",
            "avgAccessPageNum",
            "avgAccessTime",
            "cartNum",
            "charge",
            "click",
            "ctr",
            "cvr",
            "deepInshopUv",
            "dirShopColNum",
            "ecpc",
            "ecpm",
            "gmvInshopAmt",
            "gmvInshopNum",
            "inshopItemColNum",
            "roi",
            "uv"
        );

        for($i=17;$i>14;$i--){
            $logdate = date('Y-m-d',strtotime("-$i days"));
            $criteria = new \CDbCriteria();
            $criteria->addCondition("status='0'");
            $shops = Shop::model()->fetchAll($criteria);
            foreach($shops as $shop){
                $sources = DestRptHistory::model()->fetchAll("logdate=? AND nick=? AND effectType=? AND effect=?",array($logdate,$shop["nick"],"click",15));
                if(empty($sources))
                    continue;
                foreach($sources as $source){
                    $data =  \CJSON::decode($source["data"]);
                    if(!empty($data) && !empty($data["result"])){

                        foreach($data["result"] as $row){
                            $rpt = array(
                                "logdate"=>$logdate,
                                "nick"=>$shop["nick"]
                            );
                            foreach($fields as $f){
                                $rpt[$f] = $row[$f];
                            }

                            DestE15Rpt::model()->deleteAll("logdate=? AND nick=? AND campaignId=? AND transId=? AND targetId=?",array($rpt["logdate"],$rpt["nick"],$rpt["campaignId"],$rpt["transId"],$rpt["targetId"]));
                            $model = new DestE15Rpt();
                            $model->setAttributes($rpt);
                            if(!$model->save()){
                                print_r($model->getErrors());
                            }
                        }

                    }
                }

            }
        }
    }

    public function actionWeek(){

        for($i=2;$i>=1;$i--){
            $date = date('Y-m-d');
            $w  = date('w',strtotime($date));
            $now_start = date('Y-m-d',strtotime("$date -".($w ? $w - 1 : 6).' days')); //获取本周开始日期，如果$w是0，则表示周日，减去 6 天

            $begindate = date('Y-m-d',strtotime("$now_start - ".(7*$i)." days"));  //上周开始日期
            $enddate = date('Y-m-d',strtotime("$begindate + 6 days"));  //上周结束日期

            $criteria = new \CDbCriteria();
            $criteria->addCondition("status='0'");
            $shops = Shop::model()->fetchAll($criteria);
            foreach($shops as $shop){
                $data =  DestRptHistory::fetchAllSummaryByNick($begindate,$enddate,$shop["nick"]);
                if(empty($data))
                    continue;
                DestWeekRpt::model()->deleteAll("begindate=? AND enddate=? AND nick=?",array($begindate,$enddate,$shop["nick"]));
                $model = new DestWeekRpt();
                $model->setAttributes(array(
                    "begindate"=>$begindate,
                    "enddate"=>$enddate,
                    "nick"=>$shop["nick"],
                    "data"=>\CJSON::encode($data)
                ));
                if(!$model->save()){
                    print_r($model->getErrors());
                }


            }
        }

    }


}