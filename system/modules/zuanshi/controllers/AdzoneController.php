<?php
namespace application\modules\zuanshi\controllers;

use cloud\core\controllers\Controller;
use cloud\core\utils\Env;
use application\modules\zuanshi\model\Adzone;
use application\modules\zuanshi\model\AdzoneTag;

class AdzoneController extends Controller {

    public function actionIndex(){
        $criteria = new \CDbCriteria();
        $criteria->order = "adzoneId ASC";
        $list = Adzone::model()->fetchAll($criteria);
        foreach($list as &$row){
            $row["tag"] = AdzoneTag::model()->fetch("adzoneId=?",array($row["adzoneId"]));
        }

        $this->render("index",array("list"=>$list));
    }

    public function actionUpdate(){
        $adzoneStr = Env::getRequest("adzone");
        $adzone = json_decode($adzoneStr,true);
        Adzone::model()->deleteAll("adzoneId=?",array($adzone["adzoneId"]));
        $model = new Adzone();
        $model->setAttributes(array(
            "adzoneId"=>$adzone["adzoneId"],
            "adzoneLevel"=>$adzone["adzoneLevel"],
            "adzoneName"=>$adzone["adzoneName"],
            "adzoneSize"=>$adzone["adzoneSize"],
            "adzoneSizeList"=>json_encode($adzone["adzoneSizeList"]),
            "adzoneUrl"=>$adzone["adzoneUrl"],
            "type"=>$adzone["type"],
            "log_date"=>date("Y-m-d")
        ));
        $model->save();
        $this->renderJson(array("isSuccess"=>true,"data"=>$model));
    }

    public function actionList(){
        $criteria = new \CDbCriteria();
        $criteria->order = "adzoneId ASC";
        $list = Adzone::model()->fetchAll($criteria);
        $this->renderJson(array("isSuccess"=>true,"data"=>$list));
    }

    public function actionDel(){
        $id = Env::getRequest("id");
        Adzone::model()->deleteByPk($id);
        $this->renderJson(array("isSuccess"=>true));
    }

    public function actionTagset(){
        $adzoneId = Env::getRequest("adzoneId");
        $tags = Env::getRequest("tags");

        $tagstr = implode(",",$tags);

        $model = AdzoneTag::model()->find("adzoneId=?",array($adzoneId));
        if($model == null){
            $model = new AdzoneTag();
            $model->setAttributes(array(
                "adzoneId" => $adzoneId,
                "tags" => $tagstr
            ));
            $model->save();
        }else{
            $model->setAttributes(array(
                "tags" => $tagstr
            ));
            $model->save();
        }

        $this->renderJson(array("isSuccess"=>true));
    }




}