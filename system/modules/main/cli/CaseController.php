<?php

namespace application\modules\main\cli;

use cloud\core\cli\Controller;
use application\modules\main\model\ShopCase;
use application\modules\main\model\ShopCaseLog;

class CaseController extends Controller
{
    public function actionLog(){

        $cases = ShopCase::model()->fetchAll("isstop=?",array(0));
        foreach($cases as $log){
            $data = array(
                "log_date" => date("Y-m-d"),
                "caseid"=> $log["caseid"],
                "planid"=> $log["planid"],
                "nick"=> $log["nick"],
                "luodiye_type"=> $log["luodiye_type"],
                "luodiye"=> $log["luodiye"],
                "luodiye_alias"=> $log["luodiye_alias"],
                "casetype"=> $log["casetype"],
                "budget"=> $log["budget"],
                "actual_budget"=> $log["actual_budget"],
                "submituser"=> $log["submituser"],
                "submitdate"=> $log["submitdate"]
            );

            print_r($data);

            ShopCaseLog::model()->deleteAll("log_date=? AND caseid=?",array(date("Y-m-d"),$log["caseid"]));

            $model = new ShopCaseLog();
            $model->setIsNewRecord(true);
            $model->setAttributes($data);
            if(!$model->save()){
                print_r( $model->getErrors() );
            }

        }
    }

}