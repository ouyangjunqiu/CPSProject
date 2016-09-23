<?php
/**
 * @file UvController.php
 * @author ouyangjunqiu
 * @version Created by 2016/9/23 11:25
 */

namespace application\modules\sycm\controllers;


use application\modules\sycm\model\ShopUvRpt;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;

class UvController extends Controller
{
    public function actionSource(){
        $data = Env::getRequest("uv");
        $nick = Env::getRequest("nick");
        $userid = Env::getRequest("userid");
        $shopid = Env::getRequest("shopid");
        $usernumid = Env::getRequest("usernumid");
        $shopname = Env::getRequest("shopname");
        if(empty($shopname)){
            $shopname = $nick;
        }
        $list = json_decode($data,true);
        $i = 1;
        krsort($list);

        foreach($list as $v){
            $logdate = date("Y-m-d",strtotime("-{$i} day"));
            ShopUvRpt::model()->deleteAll("log_date=? AND shopname=?",array($logdate,$shopname));
            $model = new ShopUvRpt();
            $model->setAttributes(array(
                "log_date" => $logdate,
                "nick" => $nick,
                "shopname" => $shopname,
                "userid" => $userid,
                "shopid" => $shopid,
                "usernumid" => $usernumid,
                "uv" => $v,
                "create_date" => date("Y-m-d H:i:s")
            ));
            $model->save();
            $i++;
        }

        $this->renderJson(array("isSuccess" => true));
    }

    public function actionHasget(){
        $nick = Env::getRequest("nick");
        $hasget =  ShopUvRpt::model()->exists("log_date=? AND shopname=?",array(date("Y-m-d",strtotime("-1 day")),$nick));
        $this->renderJson(array("isSuccess" => true,"hasget"=>$hasget>0?true:false));
    }


}