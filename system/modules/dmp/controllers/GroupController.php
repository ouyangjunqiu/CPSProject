<?php
namespace application\modules\dmp\controllers;

use cloud\core\controllers\Controller;
use cloud\core\utils\Env;
use application\modules\dmp\model\Group;
use application\modules\dmp\model\Tag;
use application\modules\main\model\ShopCase;
use application\modules\main\model\ShopCaseRun;

class GroupController extends Controller
{

    public function actionView(){
        $nick = Env::getRequest("nick");
        $caseid = Env::getRequest("caseid");
        $case = ShopCase::model()->fetchByPk($caseid);
        $runs = ShopCaseRun::model()->fetchAllByOrder("caseid='{$case["caseid"]}'");

        $groups = Group::model()->fetchAll("caseid='{$case["id"]}' ORDER BY id DESC");

        $tagsJson = Tag::makeSelectJson();

        $this->render("view",array(
            "case"=>$case,
            "runs"=>$runs,
            "tags"=>$tagsJson,
            "nick"=>$nick,
            "groups"=>$groups
        ));

    }

    public function actionData(){
        $id = Env::getRequest("id");
        $qscore = Env::getRequest("qscore");
        $finishDate = date("Y-m-d");

        $model = Group::model()->findByPk($id);
        if($model === null){
            $this->renderJson(array("isSuccess" => false));
        }

        $model->setAttributes(array(
            "qscore" => $qscore,
            "isfinish" => 1,
            "finish_date" => $finishDate
        ));

        if($model->save()) {
            $this->renderJson(array("isSuccess" => true, "data" => $model));
        }else{
            $this->renderJson(array("isSuccess" => false, "msg" => $model->getErrors()));
        }
    }

    public function actionAdd(){
        $nick = Env::getRequest("nick");
        $caseid = Env::getRequest("caseid");

        $tagIds = Env::getRequest("tag_ids");
        $casetype = Env::getRequest("casetype");
        $t0 = Env::getRequest("t0");
        $t1 = Env::getRequest("t1");
        $qscore = Env::getRequest("qscore");
        $log_date = date("Y-m-d");
        if(!empty($tagIds) && is_array($tagIds)){
            sort($tagIds);
            $tags = implode(",",$tagIds);
        }else{
            $this->renderJson(array("isSuccess" => false, "msg" => "标签不能为空"));
        }

        $tagNames = array();
        $list = Tag::model()->fetchAllByPk($tagIds);
        foreach($list as $row){
            $tagNames[] = $row["t0"].">".$row["t1"].">".$row["t2"].">".$row["name"];
        }

        $group = new Group();
        $group->setIsNewRecord(true);
        $group->setAttributes(array(
            "tag_ids" => $tags,
            "tag_names"=>implode(",",$tagNames),
            "nick" => $nick,
            "caseid" => $caseid,
            "casetype" => $casetype,
            "t0" => $t0,
            "t1" => $t1,
            "qscore" => $qscore,
            "log_date" => $log_date,
            "isfinish" => 0,
        ));
        if($group->save()) {
            $this->renderJson(array("isSuccess" => true, "data" => $group));
        }else{
            $this->renderJson(array("isSuccess" => false, "msg" => $group->getErrors()));
        }

    }

}