<?php
/**
 * @file CampaignController.php
 * @author ouyangjunqiu
 * @version Created by 16/5/10 12:14
 */

namespace application\modules\zuanshi\controllers;


use cloud\core\controllers\Controller;
use cloud\core\utils\Env;
use application\modules\zuanshi\model\CampaignHourRptSource;
use application\modules\zuanshi\utils\HourUtil;

class CampaignController extends Controller
{
    public function actionSource(){
        $date = date("Y-m-d");
        $nick = Env::getRequest("nick");
        $hour = date("H",time());
        $hour = (int)$hour;
        $logsection = HourUtil::format();
        if($logsection<=0){
            $this->renderJson(array("isSuccess"=>false));
        }

        $nick = trim($nick);
        $data = Env::getRequest("data");
        $rptdata = Env::getRequest("rptdata");
        CampaignHourRptSource::model()->deleteAll("logdate=? AND logsection=? AND nick=?",array($date,$logsection,$nick));
        $model = new CampaignHourRptSource();
        $model->setIsNewRecord(true);
        $model->setAttributes(array(
            "logdate" => $date,
            "logsection" => $logsection,
            "loghour" => $hour,
            "nick" => $nick,
            "data" => $data,
            "rptdata" => $rptdata
        ));

        if($model->save()){
            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }else{
            $this->renderJson(array("isSuccess"=>false,"data"=>$model->getErrors()));
        }
    }

    public function actionGetbynick(){
        $nick = Env::getRequest("nick");
        $rpt = CampaignHourRptSource::fetchBudgetWarningCount($nick);
        $this->renderJson(array("isSuccess"=>true,"data"=>$rpt));
    }

}