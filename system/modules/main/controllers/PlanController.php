<?php
/**
 * Class PlanController
 * 店铺日预算管理
 * @package application\modules\main\controllers
 * @author oshine
 *
 */
namespace application\modules\main\controllers;

use cloud\core\controllers\Controller;
use cloud\core\utils\Cache;
use cloud\core\utils\Env;
use application\modules\main\model\ShopPlan;

class PlanController extends Controller
{
    /**
     * 添加日预算
     */
    public function actionAdd(){
        $nick = Env::getRequest("nick");
        $budget = Env::getRequest("budget");
        $ztc_budget = Env::getRequest("ztc_budget");
        $zuanshi_budget = Env::getRequest("zuanshi_budget");
        $case["budget"] = $budget;
        $case["ztc_budget"] = $ztc_budget;
        $case["zuanshi_budget"] = $zuanshi_budget;
        $case["nick"] = $nick;
        $case["planid"] = md5($nick);
        $model = new ShopPlan();
        $model->setIsNewRecord(true);
        $model->setAttributes($case);
        if($model->save()){
            Cache::rm("sys.cache.".md5($nick));
            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }else{
            $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
        }
    }

    /**
     * 修改日预算
     */
    public function actionBudget(){
        $planid = Env::getRequest("planid");
        $budget = Env::getRequest("budget");
        $ztc_budget = Env::getRequest("ztc_budget");
        $zuanshi_budget = Env::getRequest("zuanshi_budget");

        $model = ShopPlan::model()->find("planid='{$planid}'");
        $model->setAttributes(array(
            "budget"=>$budget,
            "ztc_budget"=>$ztc_budget,
            "zuanshi_budget"=>$zuanshi_budget
        ));
        if($model->save()){
            Cache::rm("sys.cache.".md5($model->nick));
            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }else{
            $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
        }
    }

    /**
     * 修改推广预算
     */
    public function actionBudgetset(){
        $nick = Env::getRequest("nick");
        $attr["nick"] = trim($nick);
        $attr["planid"] = md5($nick);
        $ztc_budget = Env::getRequest("ztc_budget");
        if(isset($ztc_budget) && $ztc_budget>=0){
            $attr["ztc_budget"] = $ztc_budget;
        }
        $zuanshi_budget = Env::getRequest("zuanshi_budget");
        if(isset($zuanshi_budget) && $ztc_budget>=0){
            $attr["zuanshi_budget"] = $zuanshi_budget;
        }

        $count = ShopPlan::model()->count("nick=?",array($nick));
        if($count>=2){
            ShopPlan::model()->deleteAll("nick=?",array($nick));
        }

        $model = ShopPlan::model()->find("nick=?",array($nick));
        if($model == null){
            $model = new ShopPlan();
            $model->setIsNewRecord(true);
            $model->setAttributes($attr);
        }else{
            $model->setAttributes($attr);
        }

        if($model->save()){
            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }else{
            $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
        }

    }


    public function actionGetbynick(){
        $nick = Env::getRequest("nick");

        $plan = ShopPlan::model()->fetch("nick=?",array($nick));
        $this->renderJson(array("isSuccess"=>true,"data"=>array("plan"=>$plan)));
    }

}