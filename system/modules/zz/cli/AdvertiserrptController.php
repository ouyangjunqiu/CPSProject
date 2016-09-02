<?php
/**
 * @file AdvertiserrptController.php
 * @author ouyangjunqiu
 * @version Created by 16/9/2 08:47
 */

namespace application\modules\zz\cli;

use application\modules\main\model\Shop;
use application\modules\zz\model\AdvertiserMonthRpt;
use application\modules\zz\model\AdvertiserRpt;
use application\modules\zz\model\AdvertiserWeekRpt;
use cloud\core\cli\Controller;

class AdvertiserrptController extends Controller
{
    public function actionMonth(){

            $firstday = date('Y-m-01');
            $lastday = date('Y-m-d', strtotime("$firstday +1 month -1 day"));
            $year = date("Y",strtotime($lastday));
            $month = date("m",strtotime($lastday));

            $criteria = new \CDbCriteria();
            $criteria->addCondition("status='0'");
            $shops = Shop::model()->fetchAll($criteria);
            foreach($shops as $shop){
                $data = AdvertiserRpt::fetchByNick($shop["nick"],$firstday,$lastday,"click",3);
                if(empty($data) || empty($data["total"]) || $data["total"]["adPv"]<=0)
                    continue;

                AdvertiserMonthRpt::model()->deleteAll("logyear=? AND nick=? AND logmonth=?",array($year,$shop["nick"],$month));

                $total = $data["total"];
                $attr = array(
                    "adPv"=>$total["adPv"],
                    "charge"=>$total["charge"],
                    "click"=>$total["click"],
                    "alipayInshopAmt"=>$total["alipayInshopAmt"],
                );
                $model = new AdvertiserMonthRpt();
                $model->setAttributes(
                    array(
                        "logyear"=>$year,
                        "nick"=>$shop["nick"],
                        "logmonth"=>$month,
                        "data"=>\CJSON::encode($attr),
                        "logdate"=>date("Y-m-d")
                    )
                );
                if(!$model->save()){
                    print_r($model->getErrors());
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
                $data =  AdvertiserRpt::fetchByNick($shop["nick"],$begindate,$enddate,'click',3);
                if(empty($data))
                    continue;
                AdvertiserWeekRpt::model()->deleteAll("begindate=? AND enddate=? AND nick=?",array($begindate,$enddate,$shop["nick"]));
                $model = new AdvertiserWeekRpt();
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