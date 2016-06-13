<?php
/**
 * Class CaserunController
 * 推广工具(方案)管理
 * @author oshine
 */
namespace application\modules\main\controllers;

use cloud\core\controllers\Controller;
use cloud\core\utils\Env;
use application\modules\main\model\ShopCase;
use application\modules\main\model\ShopCaseRun;
use application\modules\main\model\ShopCaseRunRptWeek;
use application\modules\main\model\ShopPlan;

class CaserunController extends Controller
{
    /**
     * 布局类型
     * @var string
     */
    public $layout = 'application.theme.default.views.layouts.main';

    /**
     * 实施方案首页
     */
    public function actionIndex2(){
        $nick = Env::getRequestWithSessionDefault("nick","","main.caserun.index2.nick");
        if(empty($nick)){
            $this->showMessage("请选择一个店铺进入",$this->createUrl("/main/default/index"));
        }

        $nick = addslashes($nick);

        $criteria = new \CDbCriteria();
        $criteria->addCondition("nick='{$nick}'");
        $plan = ShopPlan::model()->fetch($criteria);
        if(empty($plan)){
            $this->error("未找到该店铺的信息",$this->createUrl("/main/default/index"));
            return;
        }
        $cases = ShopCase::model()->fetchAll("nick=? AND isstop=?",array($nick,0));
        foreach($cases as &$case){
            $case["run"] = ShopCaseRun::model()->fetchAllByOrder("caseid='{$case["caseid"]}'");
            $case["rpt"] = ShopCaseRunRptWeek::fetchLastWeekByCaseId($case["id"]);
        }

        $this->render("index2",array("plan"=>$plan,"cases"=>$cases,"query"=>array("nick"=>$plan["nick"],"planid"=>$plan["planid"])));

    }

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