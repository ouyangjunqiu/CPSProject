<?php
/**
 * @file CustrptController.php
 * @author ouyangjunqiu
 * @version Created by 16/9/20 17:50
 */

namespace application\modules\ztc\cli;


use application\modules\main\model\Shop;
use application\modules\ztc\model\CustRpt;
use cloud\core\cli\Controller;
use cloud\core\utils\Curl;
use cloud\core\utils\ExtRangeDate;

class CustrptController extends Controller
{

    public function actionIndex(){

       $rangeDate = ExtRangeDate::range(17);

       $criteria = new \CDbCriteria();
       $criteria->addCondition("status='0'");
       $shops = Shop::model()->fetchAll($criteria);
       foreach($shops as $shop){

           $url = "http://yj.da-mai.com/index.php?r=api/getCustReport";
           $curl = new Curl();
           $resp = $curl->getJson($url,array("nick"=>$shop["nick"],"startDate"=>$rangeDate->startDate,"endDate"=>$rangeDate->endDate));
           if($curl->hasError()){
               print_r($curl->getError());
               continue;
           }

           if($resp["status"]!=1){
               print_r($resp);
               continue;
           }

           $data = $resp["data"];
           if(empty($data) || !is_array($data)){
               print_r($resp);
               continue;
           }


           foreach($data as $k => $row){
               $logdate = date("Y-m-d",strtotime($k));
               $rpt = array_merge($row["base"],$row["effect"]);
               $rpt["paycount"] = $rpt["directpaycount"]+$rpt["indirectpaycount"];
               $rpt["favcount"] = $rpt["favitemcount"]+$rpt["favshopcount"];
               $rpt["pay"] = $rpt["directpay"]+$rpt["indirectpay"];
               $rpt["ppc"] = @round($rpt["charge"]/$rpt["click"],2);
               $rpt["roi"] = @round($rpt["pay"]/$rpt["cost"],2);

               CustRpt::model()->deleteAll("logdate=? AND nick=? AND effectType=? AND effect=?", array($logdate, $shop["nick"], "click", 15));
               $listModel = new CustRpt();
               $listModel->setAttributes(array(
                   "logdate" => $logdate,
                   "nick" => $shop["nick"],
                   "effectType" => "click",
                   "effect" => 15,
                   "data" => \CJSON::encode($rpt)
               ));
               if(!$listModel->save()){
                   print_r($listModel->getErrors());
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
                $data =  CustRpt::fetchByNick($shop["nick"],$begindate,$enddate,'click',15);
                if(empty($data) || empty($data["total"]) || $data["total"]["adPv"]<=0)
                    continue;
                CustRpt::model()->deleteAll("begindate=? AND enddate=? AND nick=?",array($begindate,$enddate,$shop["nick"]));
                $model = new CustRpt();
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