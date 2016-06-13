<?php
/**
 * Class CaserunrptController
 * 推广工具报表管理
 * @author oshine
 */
namespace application\modules\main\controllers;


use cloud\core\controllers\Controller;
use cloud\core\utils\Cache;
use cloud\core\utils\Env;
use application\modules\main\model\ShopCase;
use application\modules\main\model\ShopCaseRun;
use application\modules\main\model\ShopCaseRunRpt;
use application\modules\main\model\ShopCaseRunRptWeek;
use application\modules\main\model\ShopPlan;

class CaserunrptController extends Controller
{
    public function actionCreate(){
        $planid = Env::getRequest("planid");
        $criteria = new \CDbCriteria();
        $criteria->addCondition("planid='$planid'");
        $plan = ShopPlan::model()->fetch($criteria);
        $cases = ShopCase::model()->fetchAll($criteria);
        foreach($cases as &$case){
            $runs = ShopCaseRun::model()->fetchAll("caseid='{$case["caseid"]}'");
            foreach($runs as $run) {
                $data = array(
                    "nick" => $plan["nick"],
                    "log_date" => date("Y-m-d"),
                    "planid" => $plan["id"],
                    "plan_budget" => $plan["budget"],
                    "caseid" => $case["id"],
                    "casetype" => $case["casetype"],
                    "case_budget" => $case["budget"],
                    "runid" => $run["id"],
                    "runtype" => $run["dept"],
                    "run_budget"=>$run["budget"],
                    "budget_ok" => 0,
                    "rpt_ok" =>0
                );

                $model = new ShopCaseRunRpt();
                $model->setAttributes($data);
                $model->save();
            }
        }
        $this->renderJson(array("isSuccess"=>true));
    }

    public function actionIndex(){
        $yesterday = date("Y-m-d",strtotime("-1 days"));
        $criteria = new \CDbCriteria();
        $criteria->addCondition("log_date>='$yesterday'");
        $rpts = ShopCaseRunRpt::model()->fetchAll($criteria);
        $result = array();
        foreach($rpts as $rpt){
            $result[$rpt["nick"]][$rpt["log_date"]][] = $rpt;
        }

        $this->render("index2",array("rpts"=>$result));
    }

    public function actionModify(){
        $id = Env::getRequest("id");
        $cost = Env::getRequest("cost");
        $roi = Env::getRequest("roi");

        $model = ShopCaseRunRptWeek::model()->findByPk($id);
        $model->setAttributes(array("cost"=>round($cost,2),"roi"=>round($roi,2)));

        if($model->save()){
            Cache::rm("sys.cache.".md5($model->nick));
            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }else{
            $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
        }
    }



}