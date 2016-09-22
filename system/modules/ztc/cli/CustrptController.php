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
                   "logdate" => $rpt["date"],
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

}