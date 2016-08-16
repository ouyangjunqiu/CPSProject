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

        for($i=2;$i<=1;$i++){
            $begindate = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-date("w")+1-(7*$i),date("Y")));
            $enddate = date("Y-m-d",mktime(23,59,59,date("m"),date("d")-date("w")+7-(7*$i),date("Y")));
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