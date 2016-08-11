<?php
namespace application\modules\zuanshi\cli;

use application\modules\main\model\Shop;
use application\modules\zuanshi\model\AccountRpt;
use application\modules\zz\model\AdvertiserMonthRpt;
use cloud\core\cli\Controller;

class RptController  extends Controller
{

    public function actionMonth(){

        $firstday = date('Y-m-01', strtotime("2016-07-05"));
        $lastday = date('Y-m-d', strtotime("$firstday +1 month -1 day"));
        $year = date("Y",$lastday);
        $month = date("m",$lastday);

        $criteria = new \CDbCriteria();
        $criteria->addCondition("status='0'");
        $shops = Shop::model()->fetchAll($criteria);
        foreach($shops as $shop){
            $total = AccountRpt::summaryByNick($firstday,$lastday,$shop["nick"]);
            if(empty($total) || empty($total["ad_pv"]))
                continue;

            AdvertiserMonthRpt::model()->deleteAll("logyear=? AND nick=? AND logmonth=?",array($year,$shop["nick"],$month));

            $model = new AdvertiserMonthRpt();
            $model->setAttributes(
                array(
                    "logyear"=>$year,
                    "nick"=>$shop["nick"],
                    "logmonth"=>$month,
                    "data"=>\CJSON::encode($total),
                    "logdate"=>date("Y-m-d")
                )
            );
            if(!$model->save()){
                print_r($model->getErrors());
            }
        }

    }

}