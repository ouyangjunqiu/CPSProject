<?php
namespace application\modules\zuanshi\controllers;

use application\modules\zuanshi\model\Dmp;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;
use cloud\core\utils\ExtRangeDate;
use application\modules\zuanshi\model\Adzone;
use application\modules\zuanshi\model\AdzoneTag;
use application\modules\zuanshi\model\Setting;
use application\modules\zuanshi\model\ShopVie;

class SettingController extends Controller
{
    public function actionIndex(){
        $nick = Env::getRequest("nick");
        $setting = Setting::model()->fetch("nick=?",array($nick));
        if(empty($setting)){
            $setting["adzone"] = array();
        }else{
            $setting["adzone"]  = json_decode($setting["adzone"],true);
        }
        $this->render("index",array("setting"=>$setting,"query"=>array("nick"=>$nick)));
    }

    public function actionIndex2(){
        $nick = Env::getRequest("nick");
        $setting = Setting::model()->fetch("nick=?",array($nick));

        $this->render("index2",array("setting"=>$setting,"query"=>array("nick"=>$nick)));
    }

    public function actionGet(){
        $nick = Env::getRequest("nick");

        $data = Setting::model()->fetch("nick=?",array(trim($nick)));
        if($data == null){
            $this->renderJson(array("isSuccess" => false));
        }else {
            $data["adzone"] = json_decode($data["adzone"], true);
            $data["shops"] = json_decode($data["shops"], true);
            $data["dmps"] = json_decode($data["dmps"], true);
            $this->renderJson(array("isSuccess" => true, "data" => $data));
        }
    }

    public function actionUpdate(){
        $nick = Env::getRequest("nick");
        $campaignid = Env::getRequest("campaignid");
        $adzoneReq = Env::getRequest("adzone");

        $creatives = Env::getRequest("creatives");
        $adzone = array();
        foreach($adzoneReq as $row){
            $p = explode(",",$row);
            if(count($p)>=3) {
                $adzone[] = array(
                    "adzoneId" =>$p[0],
                    "type" =>$p[1],
                    "bidPrice" =>$p[2],
                );
            }
        }

        $model = Setting::model()->find("nick=?",array($nick));
        if($model === null){
            $model = new Setting();
            $model->setAttributes(array(
                "nick"=>$nick,
                "campaignid" => $campaignid,
                "adzone"=>json_encode($adzone),
                "creatives"=>$creatives
            ));
            if($model->save()){
                $this->renderJson(array("isSuccess"=>true,"data"=>$model));
            }else{
                $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
            }
        }else{
            $model->setAttributes(array(
                "nick"=>$nick,
                "campaignid" => $campaignid,
                "adzone"=>json_encode($adzone),
                "creatives"=>$creatives
            ));
            if($model->save()){
                $this->renderJson(array("isSuccess"=>true,"data"=>$model));
            }else{
                $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
            }
        }

    }

    public function actionUpdate2(){
        $nick = Env::getRequest("nick");
        $campaignid = Env::getRequest("campaignid");

        $creatives = Env::getRequest("creatives");

        $model = Setting::model()->find("nick=?",array($nick));
        if($model === null){
            $model = new Setting();
            $model->setAttributes(array(
                "nick"=>$nick,
                "campaignid" => $campaignid,
                "creatives"=>$creatives
            ));
            if($model->save()){
                $this->renderJson(array("isSuccess"=>true,"data"=>$model));
            }else{
                $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
            }
        }else{
            $model->setAttributes(array(
                "nick"=>$nick,
                "campaignid" => $campaignid,
                "creatives"=>$creatives
            ));
            if($model->save()){
                $this->renderJson(array("isSuccess"=>true,"data"=>$model));
            }else{
                $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
            }
        }

    }

    public function actionBindadzone(){
        $nick = Env::getRequest("nick");
        $adzoneReq = Env::getRequest("adzone");
        $price = Env::getRequest("price");
        if(empty($price))
            $price = 1;

        $adzone = array();
        foreach($adzoneReq as $row){
            $p = explode(",",$row);
            if(count($p)>=2) {
                $adzone[] = array(
                    "adzoneId" =>$p[0],
                    "type" =>$p[1],
                    "bidPrice" =>$price,
                );
            }
        }

        $model = Setting::model()->find("nick=?",array($nick));
        if($model === null){
            $model = new Setting();
            $model->setAttributes(array(
                "nick"=>$nick,
                "adzone"=>json_encode($adzone),
            ));
            if($model->save()){
                $this->renderJson(array("isSuccess"=>true,"data"=>$model));
            }else{
                $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
            }
        }else{
            $model->setAttributes(array(
                "nick"=>$nick,
                "adzone"=>json_encode($adzone),
            ));
            if($model->save()){
                $this->renderJson(array("isSuccess"=>true,"data"=>$model));
            }else{
                $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
            }
        }

    }

    public function actionVie(){

        $nick = Env::getRequest("nick");
        $nick = addslashes($nick);

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
        $criteria->addCondition("nick='$nick'");
        if(isset($is_use) && $is_use>=1 ){
            $criteria->addCondition("is_use='1'");
        }else if(isset($is_use) && $is_use<0){
            $criteria->addCondition("is_use='0'");
        }
        if(!empty($begin_date)){
            $criteria->addCondition("log_date>='{$begin_date}'");
        }
        if(!empty($keyword)){
            $criteria->addSearchCondition("keyword",$keyword);
        }
        if(!empty($end_date)){
            $criteria->addCondition("log_date<='{$end_date}'");
        }

        if(!empty($low_cnt)){
            $criteria->addCondition("cnt>='{$low_cnt}'");
        }

        if(!empty($max_cnt)){
            $criteria->addCondition("cnt<='{$max_cnt}'");
        }

        $criteria->addCondition("isdeleted='0'");

        if(!empty($orderby)){
            $criteria->order = "{$orderby} DESC";
        }

        $model = Setting::model()->fetch("nick=?",array($nick));
        $list = ShopVie::model()->fetchAll($criteria);
        if(!empty($model)){
            $shops = json_decode($model["shops"],true);
            foreach($list as &$row){
                if(isset($shops[$row["shopnick"]])){
                    $row["isSelect"] = true;
                }
            }
        }
        $this->render("vie", array("list" => $list, "query" => array(
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

    public function actionBindvie(){
        $nick = Env::getRequest("nick");
        $shopsReq = Env::getRequest("shops");
        $shops = array();
        $select_shops = array();

        $model = Setting::model()->find("nick=?",array($nick));
        if($model === null){
            $this->renderJson(array("isSuccess"=>false));
        }else{

            foreach($shopsReq as $row){
                $p = explode(",",$row);
                if(count($p)>=3) {
                    $vie = ShopVie::model()->findByPk($p[0]);
                    if($vie!==null) {
                        $vie->campaignid = $model->campaignid;
                        $vie->is_use = 1;
                        $vie->save();
                    }
                    $select_shops[] = array("id"=>$p[0],"shop"=>$p[1],"cnt"=>$p[2]);
                    $shops[$p[1]] = $p[2];
                }
            }


            $model->setAttributes(array(
                "shops" => json_encode($shops),
                "select_shops" => json_encode($select_shops),
                "type"=>0
            ));
            if($model->save()){
                $this->renderJson(array("isSuccess"=>true,"data"=>$model));
            }else{
                $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
            }
        }
    }

    public function actionAdzone(){

        $nick = Env::getRequest("nick");
        $tags = Env::getRequest("tags");
        $sizes = Env::getRequest("size");
        if(empty($tags))$tags = array();
        $setting = Setting::model()->fetch("nick=?",array($nick));

        $setting["price"] = 1;
        if(empty($setting)){
            $setting["adzone"] = array();
        }else{
            if(isset($setting["adzone"])) {
                $ads = json_decode($setting["adzone"], true);
            }else{
                $ads = array();
            }
            $adzonelist = array();
            foreach($ads as $ad){
                $adzonelist[] = $ad["adzoneId"];
                $setting["price"] = $ad["bidPrice"];
            }
            $setting["adzone"] = $adzonelist;
        }
        $keyword = Env::getRequest("keyword");
        $criteria = new \CDbCriteria();
        if(!empty($keyword)){
            $criteria->addSearchCondition("adzoneName",$keyword);
        }

        if(!empty($sizes) && count($sizes)>=1){
            $condition = array();
            foreach($sizes as $size){
                $condition[] = "adzoneSize LIKE '%$size%'";
            }

            $criteria->addCondition("(".implode(" OR ",$condition).")");
        }

        $list = array();
        $adzones = Adzone::model()->fetchAll($criteria);
        foreach($adzones as &$row){
            if(in_array($row["adzoneId"],$setting["adzone"] )){
                $row["isSelect"] = true;
            }else{
                $row["isSelect"] = false;
            }

            $row["tag"] = AdzoneTag::model()->fetch("adzoneId=?",array($row["adzoneId"]));

            if(!empty($tags)){
                if(!empty($row["tag"]["tags"])) {
                    $adzoneTags = explode(",", $row["tag"]["tags"]);
                    $flag = true;
                    foreach ($tags as $tag) {
                        if (!in_array($tag, $adzoneTags)) {
                            $flag = false;
                            break;
                        }
                    }

                    if($flag){
                        $list[] = $row;
                    }
                }
            }else{
                $list[] = $row;
            }
        }



        $this->render("adzone", array("list" => $list,"setting"=>$setting, "query" => array(
            "nick" => $nick,
            "keyword"=>$keyword,
            "tags"=>$tags,
            "sizes"=>$sizes
        )));
    }

    public function actionDmp(){
        $nick = Env::getRequest("nick");
        $setting = Setting::fetchDmpSettingByNick($nick);
        $keyword = Env::getRequest("keyword");
        $result = Dmp::fetchByNick($nick);
        if(!empty($keyword)) {
            $list = array();
            foreach ($result as $r) {

                if (preg_match("/$keyword/",$r["dmpCrowdName"])){
                    $list[] = $r;
                }

            }
        }else{
            $list = $result;
        }

        foreach($list as &$row){
            if(in_array($row["dmpCrowdId"],$setting)){
                $row["isSelect"] = true;
            }else{
                $row["isSelect"] = false;
            }
        }

        $this->render("dmp", array("list" => $list, "setting"=>$setting, "query" => array(
            "nick" => $nick,
        )));

    }

    public function actionBinddmp(){
        $nick = Env::getRequest("nick");
        $dmps = Env::getRequest("dmps");

        $select_dmps = array();
        $model = Setting::model()->find("nick=?",array($nick));
        if($model === null){
            $this->renderJson(array("isSuccess"=>false));
        }else{

            foreach($dmps as $row){
                $p = explode(",",$row);
                if(count($p)>=2) {

                    $select_dmps[] = array("targetValue"=>$p[0],"targetName"=>$p[1]);
                }
            }


            $model->setAttributes(array(
                "dmps" => json_encode($select_dmps),
                "type"=>1
            ));
            if($model->save()){
                $this->renderJson(array("isSuccess"=>true,"data"=>$model));
            }else{
                $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
            }
        }

    }


}