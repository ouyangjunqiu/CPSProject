<?php
namespace application\modules\zuanshi\controllers;

use cloud\core\controllers\Controller;
use cloud\core\utils\Env;
use cloud\core\utils\ExtRangeDate;
use application\modules\zuanshi\model\ShopVie;

class VieController extends Controller
{
    public function actionIndex(){
        $nick = Env::getRequest("nick");

        if(empty($nick)){
            $this->showMessage("未找到该店铺的信息!",$this->createUrl("/main/default/index"));
            return;
        }

        $days = Env::getRequestWithSessionDefault("days",365,"zuanshi.vie.index.days");
        if(empty($days) || (int)$days >0){
            $rangeDate = ExtRangeDate::rangeNow(365);
        }else{
            $rangeDate = ExtRangeDate::rangeNow($days);
        }

        $keyword = Env::getRequestWithSessionDefault("keyword","","zuanshi.vie.index.keyword");
        $low_cnt = Env::getRequestWithSessionDefault("low_cnt","","zuanshi.vie.index.low_cnt");
        $max_cnt = Env::getRequestWithSessionDefault("max_cnt","","zuanshi.vie.index.max_cnt");

        $is_use = Env::getRequestWithSessionDefault("is_use","","zuanshi.vie.index.is_use");
        $orderby = Env::getRequestWithSessionDefault("orderby","","zuanshi.vie.index.orderby");

        $begin_date = $rangeDate->startDate;
        $end_date = $rangeDate->endDate;

        $criteria = new \CDbCriteria();

        $nick = addslashes($nick);
        $criteria->addCondition("nick='$nick'");
        if(isset($is_use) && $is_use>=1 ){
            $criteria->addCondition("is_use='1'");
        }else if(isset($is_use) && $is_use<0){
            $criteria->addCondition("is_use='0'");
        }
        if(!empty($begin_date)){
            $begin_date = date("Y-m-d",strtotime($begin_date));
            $criteria->addCondition("log_date>='{$begin_date}'");
        }
        if(!empty($keyword)){
            $keyword = addslashes($keyword);
            $criteria->addSearchCondition("keyword",$keyword);
        }
        if(!empty($end_date)){
            $end_date = date("Y-m-d",strtotime($end_date));
            $criteria->addCondition("log_date<='{$end_date}'");
        }

        if(!empty($low_cnt)){
            $low_cnt = (int)$low_cnt;
            $criteria->addCondition("cnt>='{$low_cnt}'");
        }

        if(!empty($max_cnt)){
            $max_cnt = (int)$max_cnt;
            $criteria->addCondition("cnt<='{$max_cnt}'");
        }

        $criteria->addCondition("isdeleted='0'");

        if(!empty($orderby) && in_array($orderby,array("cnt","log_date"))){
            $orderby = addslashes($orderby);
            $criteria->order = "{$orderby} DESC";
        }

        $view = Env::getRequest("view");
        $list = ShopVie::model()->fetchAll($criteria);
        if(strtolower($view) == "json") {
            $shops = array();
            foreach($list as $row){
                $shops[$row["shopnick"]] = $row["cnt"];
            }
            echo json_encode($shops);
        }else{
            $this->render("index", array("list" => $list,  "query" => array(
                "nick" => $nick,
                "low_cnt"=>$low_cnt,
                "max_cnt"=>$max_cnt,
                "begin_date"=>$begin_date,
                "end_date"=>$end_date,
                "is_use"=>$is_use,
                "orderby"=>$orderby,
                "keyword"=>$keyword,
                "days"=>$days
            )));
        }
    }

    public function actionTrash(){
        $nick = Env::getRequest("nick");
        if(empty($nick)){
            $this->showMessage("未找到该店铺的信息!",$this->createUrl("/main/default/index"));
            return;
        }
        $criteria = new \CDbCriteria();
        $criteria->addCondition("nick='$nick'");

        $criteria->addCondition("isdeleted='1'");

        $list = ShopVie::model()->fetchAll($criteria);
        $this->render("trash", array("list" => $list,  "query" => array(
            "nick" => $nick,

        )));

    }

    public function actionAddcustom(){
        $nick = Env::getRequest("nick");
        if(empty($nick)){
            $this->showMessage("未找到该店铺的信息!",$this->createUrl("/main/default/index"));
            return;
        }
        $this->render("add",array("query"=>array("nick"=>$nick)));
    }

    public function actionAdd(){
        $nick = Env::getRequest("nick");
        $keyword = Env::getRequest("keyword");
        $logdate = date("Y-m-d");
        $nick = trim($nick);
        $shops = Env::getRequest("shops");
        $shops = json_decode($shops,true);
        $src = Env::getRequest("src");

        $src = empty($src)?"未知来源":$src;

        $rangeDate = ExtRangeDate::range(30);
        foreach($shops as $shop){
            if(!empty($shop["shopnick"])) {
                $model = ShopVie::model()->find("log_date>=? AND nick=? AND shopnick=? AND keyword=?", array($rangeDate->startDate,$nick, $shop["shopnick"],$keyword));
                if ($model == null) {
                    $model = new ShopVie();
                    $model->setAttributes(array(
                        "nick" => $nick,
                        "keyword" => $keyword,
                        "log_date" => $logdate,
                        "shopnick" => $shop["shopnick"],
                        "cnt" => $shop["cnt"],
                        "isdeleted"=>0,
                        "src" => $src,
                    ));
                    $model->save();
                }else{
                    $model->setAttributes(array(
                        "log_date" => $logdate,
                        "cnt" => $shop["cnt"],
                        "src" => $src,
                    ));
                    $model->save();
                }
            }
        }
        $this->renderJson(array("isSuccess"=>true));
    }

    public function actionSet(){
        $shops = Env::getRequest("shops");
        $shops = json_decode($shops,true);

        $rangeDate = ExtRangeDate::range(30);

        foreach($shops as $shop){

            $model = ShopVie::model()->find("log_date>=? AND nick=? AND shopnick=? AND keyword=?", array($rangeDate->startDate,$shop["nick"], $shop["shopnick"],$shop["keyword"]));
            if ($model == null) {
                $model = new ShopVie();
                $model->setAttributes(
                    array(
                        "nick" => $shop["nick"],
                        "keyword" => $shop["keyword"],
                        "log_date" => date("Y-m-d"),
                        "shopnick" => $shop["shopnick"],
                        "cnt" => $shop["cnt"],
                        "src" => $shop["src"],
                        "shoptext" => json_encode($shop["shop"]),
                        "itemtext" => json_encode($shop["item"]),
                        "shopid" => $shop["shop"]["userid"],
                        "isdeleted"=>0
                    )
                );
                $model->save();
            }else{
                if($shop["cnt"] > $model->cnt){
                    $model->setAttributes(array(
                        "log_date" => date("Y-m-d"),
                        "cnt" => $shop["cnt"],
                        "src" => $shop["src"],
                        "shoptext" => json_encode($shop["shop"]),
                        "itemtext" => json_encode($shop["item"]),
                    ));
                    $model->save();
                }

            }
        }
    }

    public function actionDel(){
        $ids = Env::getRequest("ids");

        if(!empty($ids) && is_array($ids) && count($ids)>=1){

            foreach($ids as $id){
                $model = ShopVie::model()->findByPk($id);
                if($model!=null){
                    $model->isdeleted = 1;
                    $model->save();
                }
            }

            $this->renderJson(array("isSuccess" => true));

        }else {

            $this->renderJson(array("isSuccess" => true));
        }


    }

    public function actionClean(){
        $nick = Env::getRequest("nick");
        if(empty($nick)){
            $this->renderJson(array("isSuccess" => false));
            return;
        }
        $criteria = new \CDbCriteria();
        $criteria->addCondition("nick='$nick'");
        $criteria->addCondition("isdeleted='1'");

        ShopVie::model()->deleteAll($criteria);

        $this->renderJson(array("isSuccess" => true));
    }

    public function actionUse(){
        $id = Env::getRequest("id");
        $campaignId = Env::getRequest("campaignid");
        $model = ShopVie::model()->findByPk($id);
        if($model === null){
            $this->renderJson(array("isSuccess"=>true));
        }else{
            $model->campaignid = $campaignId;
            $model->is_use = 1;
            $model->save();
            $this->renderJson(array("isSuccess"=>true));
        }
    }

    public function actionRenew(){

        $ids = Env::getRequest("ids");

        if(!empty($ids) && is_array($ids) && count($ids)>=1){

            foreach($ids as $id){
                $model = ShopVie::model()->findByPk($id);
                if($model!=null){
                    $model->isdeleted = 0;
                    $model->save();
                }
            }

            $this->renderJson(array("isSuccess" => true));

        }else {

            $this->renderJson(array("isSuccess" => true));
        }

    }

}