<?php

namespace application\modules\main\cli;
use cloud\core\cli\Controller;
use application\modules\main\model\ShopPlan;
use application\modules\main\model\ShopPlanLog;

class PlanController extends Controller
{

    public function actionIndex(){
        $list = ShopPlan::model()->fetchAll();
        foreach($list as $row){
            ShopPlanLog::model()->deleteAll("log_date=? AND planid=?",array(date("Y-m-d"),$row["planid"]));
            $model = new ShopPlanLog();
            $model->setAttributes(array(
                "planid" => $row["planid"],
                "nick" => $row["nick"],
                "budget" => $row["budget"],
                "ztc_budget"=>$row["ztc_budget"],
                "zuanshi_budget"=>$row["zuanshi_budget"],
                "log_date" => date("Y-m-d"),
            ));
            if(!$model->save()){
                print_r($model->getErrors());
            }

        }
    }

}