<?php
namespace application\modules\main\controllers;

use cloud\core\controllers\Controller;
use cloud\core\utils\Cache;
use cloud\core\utils\Env;
use cloud\core\utils\ExtRangeDate;
use application\modules\main\model\ShopCase;
use application\modules\main\model\ShopCaseLog;
use application\modules\main\model\ShopCaseRun;
use application\modules\main\model\ShopCaseType;
use application\modules\main\model\ShopSure;

/**
 * Class CaseController
 * @package application\modules\main\controllers
 * @author oshine
 */
class CaseController extends Controller
{

    /**
     * 布局类型
     * @var string
     */
    public $layout = 'application.theme.default.views.layouts.main';

    /**
     * 推广需求首页
     * @return void
     */
    public function actionIndex()
    {
        $criteria = new \CDbCriteria();
        $nick = Env::getRequestWithSessionDefault("nick","","main.case.index.nick");
        $casetype = Env::getRequestWithSessionDefault("casetype","","main.case.index.casetype");
        $page = Env::getRequestWithSessionDefault("page",1,"main.case.index.page");
        $pageSize = Env::getRequestWithSessionDefault("page_size",20,"main.case.index.pagesize");


        $criteria->addCondition("isstop='0'");
        if(!empty($casetype)){
            $criteria->addCondition("casetype='$casetype'");
        }
        if(!empty($nick)){
            $criteria->addSearchCondition("nick",$nick);
        }

        $count = ShopCase::model()->count($criteria);

        $criteria->offset = ($page-1)*$pageSize;
        $criteria->limit = $pageSize;
        $cases = ShopCase::model()->fetchAll($criteria);
        foreach($cases as &$case){
            $case["run"] = ShopCaseRun::model()->fetchAllByOrder("caseid=?",array($case["caseid"]));
        }

        $casetypes = array(""=>"");
        $list = ShopCaseType::model()->fetchAll();
        foreach($list as $row){
            $casetypes[$row["value"]] = $row["value"];
        }
        $this->render("index",array("cases"=>$cases,"casetypes"=>$casetypes,"pager"=>array("count"=>$count,"page"=>$page,"page_size"=>$pageSize),"query"=>array("casetype"=>$casetype,"nick"=>$nick)));
    }

    /**
     * 获取case id
     */
    public function actionCaseid(){
        $nick = Env::getRequest("nick");
        if(empty($nick)) {
            $this->renderJson(array("isSuccess" => false, "msg" => "请输入正确的参数"));
        }

        $key = md5($nick)."".date("Ymd");
        $autoIndex = 1;
        while($autoIndex<20) {
            $caseId = $key.$autoIndex;
            $criteria = new \CDbCriteria();
            $criteria->addCondition("caseid='$caseId'");
            $exists = ShopCase::model()->exists($criteria);
            if($exists == false) {
                $this->renderJson(array("isSuccess"=>true,"data"=>array("caseid"=>$caseId)));
            }
            $autoIndex++;
        }
        $this->renderJson(array("isSuccess"=>false,"msg"=>"获取需求编号失败"));

    }

    /**
     * 添加推广case
     */
    public function actionAdd(){
        $nick = Env::getRequest("nick");
        $caseid = Env::getRequest("caseid");
        if(empty($caseid)){
            $this->renderJson(array("isSuccess"=>false,"msg"=>"需求编号不能为空"));
        }
        $budget = Env::getRequest("budget");
        $luodiye = Env::getRequest("luodiye");
        $luodiye_alias = Env::getRequest("luodiye_alias");
        $luodiye_type = Env::getRequest("luodiye_type");

        if(empty($luodiye) && $luodiye_type != "低价引流"){
            $this->renderJson(array("isSuccess"=>false,"msg"=>"落地页URL不能为空"));
        }

        if(empty($luodiye_alias) && $luodiye_type == "详情页"){
            preg_match("/id=(\\d+)/",$luodiye,$mathes);
            $luodiye_alias = "宝贝：".(isset($mathes[1])?$mathes[1]:"未知编号");
        }else if(empty($luodiye_alias) && $luodiye_type == "首页"){
            $luodiye_alias = "店铺首页";
        }


        $casetype = Env::getRequest("casetype");
        $planid = Env::getRequest("planid");

        $user = \Yii::app()->session->get("user");

        $case["nick"] = $nick;
        $case["caseid"] = $caseid;
        $case["luodiye"] = $luodiye;
        $case["casetype"] = $casetype;
        $case["budget"] = $budget;
        $case["planid"] = $planid;
        $case["luodiye_alias"] = $luodiye_alias;
        $case["luodiye_type"] = $luodiye_type;
        $case["submituser"] = empty($user)?"system":$user["username"];
        $case["submitdate"] = date("Y-m-d");
        $model = new ShopCase();
        $model->setIsNewRecord(true);
        $model->setAttributes($case);
        if($model->save()){
            Cache::rm("sys.cache.".md5($nick));
            foreach(array("钻展","直通车") as $dept){
                $m = new ShopCaseRun();
                $m->setAttributes(array(
                    "caseid" => $caseid,
                    "dept"=> $dept,
                    "budget" => 0,
                    "remark" =>""
                ));
                $m->save();
            }
            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }else{
            $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
        }
    }

    /**
     * 修改推广case
     */
    public function actionModify(){
        $id = Env::getRequest("id");
        $budget = Env::getRequest("budget");
        $casetype = Env::getRequest("casetype");

        $case["casetype"] = $casetype;
        $case["budget"] = $budget;

        $model = ShopCase::model()->findByPk($id);
        if(empty($model->luodiye_alias) && $model->luodiye_type == "详情页"){
            preg_match("/id=(\\d+)/",$model->luodiye,$mathes);
            $luodiye_alias = "宝贝：".(isset($mathes[1])?$mathes[1]:"未知编号");
            $case["luodiye_alias"] = $luodiye_alias;
        }
        $model->setAttributes($case);
        if($model->save()){
            Cache::rm("sys.cache.".md5($model->nick));
            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }else{
            $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
        }
    }

    /**
     * 废除推广case
     */
    public function actionDelete(){
        $id = Env::getRequest("id");
        $model = ShopCase::model()->findByPk($id);
        if($model == null){
            $this->renderJson(array("isSuccess"=>false));
        }

        //ShopCaseRun::model()->deleteAll("caseid=?",array($model->caseid));
        $model->setAttributes(array("isstop"=>1,"stopdate"=>date("Y-m-d")));
        if($model->save()){
            Cache::rm("sys.cache.".md5($model->nick));
            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }else{
            $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
        }
    }

    /**
     * 推广case历史记录
     */
    public function actionLog(){
        $nick = Env::getRequest("nick");

        $rangeDate = ExtRangeDate::range(7);

        $logs = array();

        $date = $rangeDate->endDate;
        for($i=1;$i<=7;$i++){
            $logs[$date] = ShopCaseLog::model()->fetchAll("log_date=? AND nick=?",array($date,$nick));
            $date = date("Y-m-d",strtotime($date." -1 days"));
        }

        $this->render("log",array("logs"=>$logs,"query"=>array("nick"=>$nick)));
    }

    /**
     * 确认推广case
     */
    public function actionSure(){
        $data["nick"] = Env::getRequest("nick");
        $data["year"] = date("Y");
        $data["week"] = date("W");
        $data["log_date"] = date("Y-m-d");
        $user = \Yii::app()->session->get("user");
        $data["username"] = empty($user)?"system":$user["username"];

        $model = new ShopSure();
        $model->setAttributes($data);
        if($model->save()){
            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }else{
            $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
        }
    }


}