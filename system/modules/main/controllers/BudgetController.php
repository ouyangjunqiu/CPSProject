<?php
/**
 * @file BudgetController.php
 * @author ouyangjunqiu
 * @version Created by 16/6/20 10:05
 */

namespace application\modules\main\controllers;


use application\modules\main\model\ShopBudget;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;

class BudgetController extends Controller
{

    /**
     * 修改推广预算
     */
    public function actionSet(){
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

        $model = ShopBudget::model()->find("nick=?",array($nick));
        if($model == null){
            $model = new ShopBudget();
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

        $plan = ShopBudget::model()->fetch("nick=?",array($nick));
        $this->renderJson(array("isSuccess"=>true,"data"=>array("plan"=>$plan)));
    }
}