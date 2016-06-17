<?php
/**
 * Class CaserunController
 * 推广工具(方案)管理
 * @author oshine
 */
namespace application\modules\main\controllers;

use cloud\core\controllers\Controller;
use cloud\core\utils\Env;
use application\modules\main\model\ShopCaseRun;

class CaserunController extends Controller
{

    /**
     * 添加推广方案
     */
    public function actionAdd(){

        $caseid = Env::getRequest("caseid");
        $dept = Env::getRequest("runtype");
        $budget = Env::getRequest("budget");
        $remark = Env::getRequest("remark");

       // list($dept,$runtype) = explode(":",$runtype);
        if(empty($dept) || empty($caseid)){
            $this->renderJson(array("isSuccess" => false, "msg" => "请输入正确的参数"));
        }

        $run["caseid"] = $caseid;
        $run["dept"] = $dept;
      //  $run["runtype"] = $runtype;
        $run["budget"] = $budget;
        $run["remark"] = $remark;

        $model = new ShopCaseRun();
        $model->setIsNewRecord(true);
        $model->setAttributes($run);
        if($model->save()){
            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }else{
            $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
        }

    }

    /**
     * 修改推广方案
     */
    public function actionModify(){

        $runid = Env::getRequest("runid");

        $budget = Env::getRequest("budget");
        $remark = Env::getRequest("remark");
        $run = array();
        if(isset($budget) && $budget !== null)
            $run["budget"] = $budget;
        if(isset($remark) && $remark !== null)
            $run["remark"] = $remark;

        $model = ShopCaseRun::model()->findByPk($runid);
        $model->setAttributes($run);
        if($model->save()){

            ShopCaseRun::updateCaseBudget($model->caseid);

            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }else{
            $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
        }

    }


}