<?php
namespace application\modules\zz\cli;
use application\modules\main\model\Shop;
use application\modules\zz\model\AdboardRptHistory;
use application\modules\zz\model\AdboardWeekRpt;
use cloud\core\cli\Controller;

/**
 * @file AdboardrptController.php
 * @author ouyangjunqiu
 * @version Created by 16/8/16 09:41
 */
class AdboardrptController extends Controller
{
    public function actionWeek(){

        for($i=2;$i>=1;$i--){
            $date = date('Y-m-d');
            $w  = date('w',strtotime($date));
            $now_start = date('Y-m-d',strtotime("$date -".($w ? $w - 1 : 6).' days')); //获取本周开始日期，如果$w是0，则表示周日，减去 6 天

            $begindate = date('Y-m-d',strtotime("$now_start - ".(7*$i)." days"));  //上周开始日期
            $enddate = date('Y-m-d',strtotime("$begindate + 7 days"));  //上周结束日期
            echo $begindate."~".$enddate."\n";

            $criteria = new \CDbCriteria();
            $criteria->addCondition("status='0'");
            $shops = Shop::model()->fetchAll($criteria);
            foreach($shops as $shop){
                $data =  AdboardRptHistory::fetchAllSummaryByNick($begindate,$enddate,$shop["nick"]);
                if(empty($data))
                    continue;
                AdboardWeekRpt::model()->deleteAll("begindate=? AND enddate=? AND nick=?",array($begindate,$enddate,$shop["nick"]));
                $model = new AdboardWeekRpt();
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