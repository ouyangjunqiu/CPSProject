<?php
namespace application\modules\zuanshi\cli;

use cloud\core\cli\Controller;
use application\modules\zuanshi\model\AccountRpt;
use application\modules\zuanshi\model\AccountRptSource;
use application\modules\zuanshi\model\AccountRptSourceSync;

class RptController  extends Controller
{
    public function actionTest(){
        $date = date("Y-m-d");
        $list = AccountRptSource::model()->fetchAll("date='{$date}'");
        foreach($list as $row){
//            print_r($row);
            $exists = AccountRptSourceSync::model()->exists("source_id='{$row["id"]}'");
            if($exists){
                echo $row["id"]." 已同步";
                continue;
            }
            $rpts = json_decode($row["rpts"],true);

            if(isset($rpts["data"]["rptAdvertiserDayList"]) && !empty($rpts["data"]["rptAdvertiserDayList"])){
                foreach($rpts["data"]["rptAdvertiserDayList"] as $rpt){
                    $date = $rpt["logDate"];
                    AccountRpt::model()->deleteAll("log_date=? AND nick=?",array($date,$rpt["advertiserName"]));

                    $model = new AccountRpt();
                    $model->setAttributes(array(
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
                    if($model->save()){
                        echo "保存成功";
                    }else{
                        print_r($model->getErrors());
                    }
                }
            }
            $sync = new AccountRptSourceSync();
            $sync->setAttributes(array("source_id"=>$row["id"]));
            $sync->save();
        }
    }
    public function actionSync(){


    }

    public function actionCreate(){

    }

}