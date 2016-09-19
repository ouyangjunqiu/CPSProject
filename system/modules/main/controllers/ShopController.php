<?php
/**
 * Class ShopController
 * 店铺管理
 * @package application\modules\main\controllers
 * @author oshine
 *
 */
namespace application\modules\main\controllers;

use application\modules\main\utils\StringUtil;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;
use application\modules\main\model\Shop;
use cloud\core\utils\String;

class ShopController extends Controller
{

    public function actionIndex(){
        $this->render("index");
    }

    /**
     * 店铺基本信息修改
     */
    public function actionPic(){
        $nick = Env::getRequest("nick");
        if(empty($nick)) {
            $this->renderJson(array("isSuccess" => false, "msg" => "店铺名不能为空!"));
        }
        $pic = Env::getRequest("pic");
        $pic = StringUtil::tagFormat($pic);

        $ztc_pic = Env::getRequest("ztc_pic");
        $ztc_pic = StringUtil::tagFormat($ztc_pic);
        $zuanshi_pic = Env::getRequest("zuanshi_pic");
        $zuanshi_pic = StringUtil::tagFormat($zuanshi_pic);
        $bigdata_pic = Env::getRequest("bigdata_pic");
        $bigdata_pic = StringUtil::tagFormat($bigdata_pic);
        $sub_pic = Env::getRequest("sub_pic");
        $sub_pic = \CJSON::encode($sub_pic);

        $model = Shop::model()->find("nick=?",array($nick));
        if(empty($model)){
            $this->renderJson(array("isSuccess"=>false));
            return;
        }

        $model->setAttributes(array(
            "pic"=>$pic,
            "zuanshi_pic"=>$zuanshi_pic,
            "ztc_pic"=>$ztc_pic,
            "bigdata_pic"=>$bigdata_pic,
            "sub_pic"=>$sub_pic
        ));

        if($model->save()){
            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }else{
            $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
        }
    }

    /**
     * 店铺帐号信息修改
     */
    public function actionModify(){
        $nick = Env::getRequest("nick");
        if(empty($nick)) {
            $this->renderJson(array("isSuccess" => false, "msg" => "店铺名不能为空!"));
        }
        $shopname = Env::getRequest("shopname");
        $loginNick = Env::getRequest("login_nick");
        $loginPassword = Env::getRequest("login_password");
        $shoptype = Env::getRequest("shoptype");
        $shopurl = Env::getRequest("shopurl");
        $shopcatname = Env::getRequest("shopcatname");
        $startdate = Env::getRequest("startdate");
        $enddate = Env::getRequest("enddate");
        $model = Shop::model()->find("nick=?",array($nick));
        if(empty($model)){
            $this->renderJson(array("isSuccess"=>false));
            return;
        }

        $model->setAttributes(
            array(
                "shopname"=>trim($shopname),
                "shopcatname"=>trim($shopcatname),
                "login_nick"=>$loginNick,
                "login_password"=>$loginPassword,
                "shopurl"=>$shopurl,
                "shoptype"=>$shoptype,
                "startdate"=>$startdate,
                "enddate"=>$enddate
            )
        );

        if($model->save()){
            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }else{
            $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
        }
    }


    /**
     * 暂停合作
     */
    public function actionStop(){
        $nick = Env::getRequest("nick");

        $model = Shop::model()->find("nick=?",array($nick));
        if(empty($model)){
            $this->renderJson(array("isSuccess"=>false));
            return;
        }
        $model->setAttributes(array("status"=>1,"stop_date"=>date("Y-m-d")));

        if($model->save()){
            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }else{
            $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
        }
    }

    /**
     * 恢复合作
     */
    public function actionRestart(){
        $nick = Env::getRequest("nick");

        $model = Shop::model()->find("nick=?",array($nick));
        if(empty($model)){
            $this->renderJson(array("isSuccess"=>false));
            return;
        }
        $model->setAttributes(array("status"=>0,"open_date"=>date("Y-m-d")));

        if($model->save()){
            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }else{
            $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
        }
    }

    public function actionOff(){
        $nick = Env::getRequest("nick");

        $model = Shop::model()->find("nick=?",array($nick));
        if(empty($model)){
            $this->renderJson(array("isSuccess"=>false));
            return;
        }
        $model->setAttributes(array("status"=>2,"off_date"=>date("Y-m-d")));

        if($model->save()){
            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }else{
            $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
        }
    }

    /**
     * 店铺同步
     */
    public function actionSync(){
        $nick = Env::getRequest("nick");

        if(String::isEmpty($nick))
            $this->renderJson(array("isSuccess"=>false,"msg"=>"店铺名不能为空!"));

        $arr = array();
        $nick = trim($nick);
        $arr["nick"] = $nick;
        $shoptype = Env::getRequest("shoptype");
        if(!String::isEmpty($shoptype)){
            $arr["shoptype"] = trim($shoptype);
        }

        $op = Env::getRequest("op");
        if(isset($op)){
            switch($op){

                case "open":
                    $arr["status"] = 0;
                    $arr["open_date"] = date("Y-m-d");
                    break;
                case "stop":
                    $arr["status"] = 1;
                    $arr["stop_date"] = date("Y-m-d");
                    break;
                case "restart":
                    $arr["status"] = 0;
                    $arr["open_date"] = date("Y-m-d");
                    break;
                case "off":
                    $arr["status"] = 1;
                    $arr["stop_date"] = date("Y-m-d");
                    break;
            }
        }


        $model = Shop::model()->find("nick=?",array($nick));
        if($model === null) {
            $model = new Shop();
            $model->setIsNewRecord(true);
            if(empty($arr["shopname"])){
                $arr["shopname"] = $arr["nick"];
            }
            if(!isset($arr["status"])){
                $arr["status"] = 0;
                $arr["open_date"] = date("Y-m-d");
            }
            if(empty($arr["shoptype"])){
                $arr["shoptype"] = "其它业务";
            }


            $loginnick = Env::getRequest("login_nick");
            if(!String::isEmpty($loginnick)){
                $arr["login_nick"] = trim($loginnick);
            }
            $loginpassword = Env::getRequest("login_password");
            if(!String::isEmpty($loginpassword)){
                $arr["login_password"] = trim($loginpassword);
            }
            $pic = Env::getRequest("pic");
            if(!String::isEmpty($pic)){
                $arr["pic"] = StringUtil::tagFormat($pic);
            }

            $zuanshipic = Env::getRequest("zuanshi_pic");
            $bigdatapic = Env::getRequest("bigdata_pic");
            $ztcpic = Env::getRequest("ztc_pic");
            if(!String::isEmpty($zuanshipic)){
                $arr["zuanshi_pic"] = StringUtil::tagFormat($zuanshipic);
            }

            if(!String::isEmpty($bigdatapic)){
                $arr["bigdata_pic"] = StringUtil::tagFormat($bigdatapic);
            }

            if(!String::isEmpty($ztcpic)){
                $arr["ztc_pic"] = StringUtil::tagFormat($ztcpic);
            }

            $arr["create_date"] = date("Y-m-d");
            $model->setAttributes($arr);
            if($model->save()){
                $this->renderJson(array("isSuccess"=>true,"data"=>$model));
            }else{
                $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
            }
        }else{

            $model->setAttributes($arr);
            if($model->save()){
                $this->renderJson(array("isSuccess"=>true,"data"=>$model));
            }else{
                $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
            }
        }

    }

    /**
     * 新增店铺
     */
    public function actionAdd(){
        $nick = Env::getRequest("nick");
        $shopname = Env::getRequest("shopname");
        if(empty($nick) || empty($shopname))
            $this->renderJson(array("isSuccess"=>false,"msg"=>"店铺名不能为空!"));
        $nick = trim($nick);
        $shopname = trim($shopname);
        $shopurl = Env::getRequest("shopurl");
        $loginnick = Env::getRequest("login_nick");
        $loginpassword = Env::getRequest("login_password");
        $pic = Env::getRequest("pic");
        $zuanshipic = Env::getRequest("zuanshi_pic");
        $bigdatapic = Env::getRequest("bigdata_pic");
        $ztcpic = Env::getRequest("ztc_pic");

        $shoptype = Env::getRequest("shoptype");

        $model = Shop::model()->find("nick='$nick'");
        if($model === null){
            $model = new Shop();
            $model->setIsNewRecord(true);
            $model->setAttributes(array(
                "nick"=>$nick,
                "shopname"=>$shopname,
                "shopurl"=>$shopurl,
                "login_nick"=>$loginnick,
                "login_password"=>$loginpassword,
                "pic"=>StringUtil::tagFormat($pic),
                "zuanshi_pic"=>StringUtil::tagFormat($zuanshipic),
                "bigdata_pic"=>StringUtil::tagFormat($bigdatapic),
                "ztc_pic"=>StringUtil::tagFormat($ztcpic),
                "shoptype"=>$shoptype,
                "status"=>0,
                "create_date"=>date("Y-m-d"),
                "open_date"=>date("Y-m-d")
            ));
        }else{
            $model->setAttributes(array(
                "nick"=>$nick,
                "shopname"=>$shopname,
                "shopurl"=>$shopurl,
                "login_nick"=>$loginnick,
                "login_password"=>$loginpassword,
                "pic"=>StringUtil::tagFormat($pic),
                "zuanshi_pic"=>StringUtil::tagFormat($zuanshipic),
                "bigdata_pic"=>StringUtil::tagFormat($bigdatapic),
                "ztc_pic"=>StringUtil::tagFormat($ztcpic),
                "shoptype"=>$shoptype,
                "status"=>0
            ));
        }

        if($model->save()){
            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }else{
            $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
        }

    }

    public function actionCloudupdate(){
        $nick = Env::getRequest("nick");

        $arr = array();
        if(!empty($nick)) {
            $arr["nick"] = trim($nick);
        }

        $shopname = Env::getRequest("shopname");
        if(!empty($shopname)) {
            $arr["shopname"] = trim($shopname);
        }

        $userid = Env::getRequest("userid");
        if(!empty($userid)) {
            $arr["userid"] = $userid;
        }

        $usernumid = Env::getRequest("usernumid");
        if(!empty($usernumid)) {
            $arr["usernumid"] = $usernumid;
        }

        $shopid = Env::getRequest("shopid");
        if(!empty($shopid)) {
            $arr["shopid"] = $shopid;
        }

        $shopcatname = Env::getRequest("shopcatname");
        if(!empty($shopcatname)) {
            $arr["shopcatname"] = $shopcatname;
        }
        if(!empty($arr["nick"])){
            $model = Shop::model()->find("nick=?", array($arr["nick"]));
        }
        else if(!empty($arr["userid"])) {
            $model = Shop::model()->find("userid=?", array($arr["userid"]));
        }
        else if(!empty($arr["usernumid"])) {
            $model = Shop::model()->find("usernumid=?", array($arr["usernumid"]));
        }
        else{
            $model = null;
        }
        if($model === null){
            $this->renderJson(array("isSuccess"=>false,"msg"=>"店铺不存在!"));
        }else{
            $model->setAttributes($arr);
            if($model->save()){
                $this->renderJson(array("isSuccess"=>true,"data"=>$model));
            }else{
                $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
            }
        }


    }

}