<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-03-07
 * Time: 17:23
 */

namespace application\modules\zuanshi\controllers;


use cloud\core\controllers\Controller;
use cloud\core\utils\Env;
use application\modules\zuanshi\model\ShopTradeRpt;

class TradeController extends Controller
{

    public function actionSource(){
        $data = Env::getRequest("payAmt");
        $nick = Env::getRequest("nick");
        $userid = Env::getRequest("userid");
        $shopid = Env::getRequest("shopid");
        $shopname = Env::getRequest("shopname");
        if(empty($shopname)){
            $shopname = $nick;
        }
        $trades = json_decode($data,true);
        $i = 1;
        krsort($trades);

        foreach($trades as $trade){
            $logdate = date("Y-m-d",strtotime("-{$i} day"));
            ShopTradeRpt::model()->deleteAll("log_date=? AND nick=?",array($logdate,$nick));
            $model = new ShopTradeRpt();
            $model->setAttributes(array(
                "log_date" => $logdate,
                "nick" => $nick,
                "shopname" => $shopname,
                "userid" => $userid,
                "shopid" => $shopid,
                "payAmt" => $trade,
                "create_date" => date("Y-m-d H:i:s")
            ));
            $model->save();
            $i++;
        }

        $this->renderJson(array("isSuccess" => true));
    }

    public function actionHasget(){
        $nick = Env::getRequest("nick");
        $hasget =  ShopTradeRpt::model()->exists("log_date=? AND nick=?",array(date("Y-m-d",strtotime("-1 day")),$nick));
        $this->renderJson(array("isSuccess" => true,"hasget"=>$hasget>0?true:false));
    }

}