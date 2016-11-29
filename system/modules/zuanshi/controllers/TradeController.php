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
use application\modules\sycm\model\ShopTradeRpt;
use cloud\core\utils\ExtRangeDate;

class TradeController extends Controller
{

    public function actionSource(){
        $data = Env::getRequest("payAmt");
        $nick = Env::getRequest("nick");
        $userid = Env::getRequest("userid");
        $shopid = Env::getRequest("shopid");
        $usernumid = Env::getRequest("usernumid");
        $shopname = Env::getRequest("shopname");
        if(empty($shopname)){
            $shopname = $nick;
        }
        $trades = json_decode($data,true);
        $i = 1;
        krsort($trades);

        foreach($trades as $trade){
            $logdate = date("Y-m-d",strtotime("-{$i} day"));
//            if($i>=3){
//                $exits = ShopTradeRpt::model()->exists("log_date=? AND shopname=?",array($logdate,$shopname));
//                if($exits)
//                    continue;
//            }

            ShopTradeRpt::model()->deleteAll("log_date=? AND shopname=?",array($logdate,$shopname));
            $model = new ShopTradeRpt();
            $model->setAttributes(array(
                "log_date" => $logdate,
                "nick" => $nick,
                "shopname" => $shopname,
                "userid" => $userid,
                "shopid" => $shopid,
                "usernumid" => $usernumid,
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
        $rpt =  ShopTradeRpt::model()->fetch("log_date=? AND shopname=?",array(date("Y-m-d",strtotime("-1 day")),$nick));
        if(empty($rpt)){
            $this->renderJson(array("isSuccess" => true,"hasget"=>false));
        }else{
            $createtime = strtotime($rpt["create_date"]);
            if((time() - $createtime) >= 7200){
                $this->renderJson(array("isSuccess" => true,"hasget"=>false));
            }else{
                $this->renderJson(array("isSuccess" => true,"hasget"=>true));
            }
        }

    }

    public function actionGetbynick(){

        $nick = Env::getQueryDefault("nick","");
        $rangeDate = ExtRangeDate::range(30);
        $beginDate = Env::getQueryDefault("begin_date",$rangeDate->startDate);
        $endDate = Env::getQueryDefault("end_date",$rangeDate->endDate);


        $data = ShopTradeRpt::fetchAllByNickV2($beginDate,$endDate,$nick);
        $this->renderJson(array("isSuccess"=>true,"data"=>$data));

    }


}