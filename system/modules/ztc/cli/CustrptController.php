<?php
/**
 * @file CustrptController.php
 * @author ouyangjunqiu
 * @version Created by 16/9/20 17:50
 */

namespace application\modules\ztc\cli;


use application\modules\main\model\Shop;
use application\modules\ztc\model\CustRpt;
use application\modules\ztc\model\CustRptSource;
use application\modules\ztc\model\CustWeekRpt;
use cloud\core\cli\Controller;
use cloud\core\utils\Curl;
use cloud\core\utils\ExtRangeDate;
use cloud\core\utils\Math;

class CustrptController extends Controller
{

    public function actionIndex(){

       $rangeDate = ExtRangeDate::range(30);

       $criteria = new \CDbCriteria();
       $criteria->addCondition("status='0'");
       $shops = Shop::model()->fetchAll($criteria);
       foreach($shops as $shop){
           $nick = $shop["nick"];

           $hasget = CustRptSource::model()->exists("logdate=? AND nick=?",array(date("Y-m-d"),$nick));
           if($hasget) continue;

           $url = "http://cps.da-mai.com/ztc/custrpt/getbyapi.html";
           $curl = new Curl();
           $resp = $curl->getJson($url,array("nick"=>$shop["nick"],"start_date"=>$rangeDate->startDate,"end_date"=>$rangeDate->endDate));
           if($curl->hasError()){
               print_r($curl->getError());
               continue;
           }

           if(!isset($resp["isSuccess"]) || !$resp["isSuccess"]){
               print_r($resp);
               continue;
           }

           $data = $resp["data"];
           if(empty($data) || !is_array($data)){
               print_r($resp);
               continue;
           }

           $url2 = "http://cps.da-mai.com/ztc/custrpt/source.html";
           $curl2 = new Curl();
           $curl2->post($url2,array(
               "nick"=>$nick,
               "effectType"=>"click",
               "effect"=>15,
               "data"=>\CJSON::encode($data)
           ));

           if($curl2->hasError()){
               print_r($curl2->getError());
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

            $lastbegindate = date('Y-m-d',strtotime("$now_start - ".(7*($i+1))." days"));
            $lastenddate = date('Y-m-d',strtotime("$lastbegindate + 6 days"));  //上周结束日期

            $criteria = new \CDbCriteria();
            $criteria->addCondition("status='0'");
            $shops = Shop::model()->fetchAll($criteria);
            foreach($shops as $shop){
                $data =  CustRpt::fetchByNick($shop["nick"],$begindate,$enddate,'click',15);
                if(empty($data) || empty($data["total"]) || $data["total"]["impressions"]<=0)
                    continue;

                $lastWeekSource = CustWeekRpt::model()->fetch("begindate=? AND enddate=? AND nick=?",array($lastbegindate,$lastenddate,$shop["nick"]));
                if(!empty($lastWeekSource)){
                    $lastWeekRpt = \CJSON::decode($lastWeekSource["data"]);
                    if(!empty($lastWeekRpt) && !empty($lastWeekRpt["total"]) && $lastWeekRpt["total"]["impressions"]>0){
                        $data["total"]["lastWeekCost"] = $lastWeekRpt["total"]["cost"];
                        $data["total"]["costRate"] = Math::growth($data["total"]["lastWeekCost"],$data["total"]["cost"]);
                    }
                }
                CustWeekRpt::model()->deleteAll("begindate=? AND enddate=? AND nick=?",array($begindate,$enddate,$shop["nick"]));
                $model = new CustWeekRpt();
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