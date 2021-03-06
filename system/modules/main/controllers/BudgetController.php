<?php
/**
 * @file BudgetController.php
 * @author ouyangjunqiu
 * @version Created by 16/6/20 10:05
 */

namespace application\modules\main\controllers;


use application\modules\main\model\ShopBudget;
use application\modules\main\model\ShopTodoToptic;
use application\modules\main\utils\StringUtil;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;

/**
 * Class BudgetController
 * @package application\modules\main\controllers
 */
class BudgetController extends Controller
{

    /**
     * 修改推广预算
     */
    public function actionSet(){
        $nick = Env::getRequest("nick");
        $attr["nick"] = trim($nick);
        $ztc_budget = Env::getRequest("ztc_budget");
        if(isset($ztc_budget) && $ztc_budget>=0){
            $attr["ztc_budget"] = $ztc_budget;
        }
        $zuanshi_budget = Env::getRequest("zuanshi_budget");
        if(isset($zuanshi_budget) && $ztc_budget>=0){
            $attr["zuanshi_budget"] = $zuanshi_budget;
        }

        $tags = Env::getRequest("tags");
        if(isset($tags)){
            $attr["tags"] = StringUtil::tagFormat($tags);
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


    /**
     *
     */
    public function actionGetbynick(){
        $nick = Env::getRequest("nick");

        $budget = ShopBudget::model()->fetch("nick=?",array($nick));
        $toptic = ShopTodoToptic::model()->fetch("logdate=? AND nick=?",array(date("Y-m-d",strtotime("-1 days")),$nick));
        if(!empty($budget)){
            $budget["tag_list"] = empty($budget["tags"])?array():explode(",",$budget["tags"]);
        }
        if(!empty($toptic)){
            $data = \CJSON::decode($toptic["data"]);
            foreach($data as $row){
                $budget["tag_list"][] = $row["word"];
            }
        }
        $this->renderJson(array("isSuccess"=>true,"data"=>$budget));

    }
}