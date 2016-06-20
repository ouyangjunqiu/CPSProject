<?php
/**
 * @file PloyController.php
 * @author ouyangjunqiu
 * @version Created by 16/6/20 10:02
 */

namespace application\modules\main\controllers;


use application\modules\main\model\ShopPloy;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;

class PloyController extends Controller
{
    public function actionAdd(){
        $nick = Env::getRequest("nick");
        $name = Env::getRequest("name");
        $begindate = Env::getRequest("begindate");
        $enddate = Env::getRequest("enddate");
        $sale_goal = Env::getRequest("sale_goal");
        $budget = Env::getRequest("budget");
        $context = Env::getRequest("context");
        $logdate = date("Y-m-d");

        $attr = array(
            "nick"=>$nick,
            "name"=>$name,
            "begindate"=>$begindate,
            "enddate" => $enddate,
            "sale_goal"=>$sale_goal,
            "budget"=>$budget,
            "context"=>$context,
            "logdate"=>$logdate
        );

        $model = new ShopPloy();
        $model->setAttributes($attr);
        if($model->save()){
            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }else{
            $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
        }

    }

    public function actionModify(){
        $id = Env::getRequest("id");
        $nick = Env::getRequest("nick");
        $name = Env::getRequest("name");
        $begindate = Env::getRequest("begindate");
        $enddate = Env::getRequest("enddate");
        $sale_goal = Env::getRequest("sale_goal");
        $budget = Env::getRequest("budget");
        $content = Env::getRequest("content");
        $logdate = date("Y-m-d");

        $attr = array(
            "nick"=>$nick,
            "name"=>$name,
            "begindate"=>$begindate,
            "enddate" => $enddate,
            "sale_goal"=>$sale_goal,
            "budget"=>$budget,
            "content"=>$content,
            "logdate"=>$logdate
        );

        $model = ShopPloy::model()->findByPk($id);
        if($model == null){
            $this->renderJson(array("isSuccess"=>false));
        }

        $model->setAttributes($attr);
        if($model->save()){
            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }else{
            $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
        }

    }

    public function actionGetbynick(){
        $nick = Env::getRequest("nick");
        $list = ShopPloy::model()->fetchAll("nick=? AND enddate>=?",array($nick,date("Y-m-d")));
        foreach($list as &$row){
            $row["budget_rate"] = round(@( $row["budget"]/$row["sale_goal"] )*100)."%";
        }
        $this->renderJson(array("isSuccess"=>true,"data"=>array("list"=>$list)));
    }

}