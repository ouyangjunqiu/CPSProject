<?php

namespace application\modules\tool\cli;


use application\modules\main\model\Shop;
use application\modules\main\model\ShopTodoList;
use application\modules\main\model\ShopTodoToptic;
use application\modules\sycm\model\ShopTradeRpt;
use application\modules\zz\model\AdvertiserRpt;
use cloud\core\cli\Controller;
use cloud\core\utils\ExtRangeDate;

class TodoController extends Controller
{
    public function actionTradetip(){

        $criteria = new \CDbCriteria();
        $criteria->addCondition("status='0'");
        $shops = Shop::model()->fetchAll($criteria);
        foreach($shops as $shop){

            $exist = ShopTradeRpt::model()->exists("log_date>=? AND log_date<? AND nick=?",array(date("Y-m-d",strtotime("-15 days")),date("Y-m-d",strtotime("-7 days")),$shop["nick"]));

            if(!$exist){
               continue;
            }

            $exist = ShopTradeRpt::model()->exists("log_date>=? AND log_date<? AND nick=?",array(date("Y-m-d",strtotime("-7 days")),date("Y-m-d",strtotime("-1 days")),$shop["nick"]));

            if(!$exist){
                $message = "温馨提示：你已很长一段时间未关注店铺经营状况！";

                $model = new ShopTodoList();
                $model->setAttributes(array(
                    "logdate"=>date("Y-m-d",strtotime("+1 days")),
                    "nick"=>$shop["nick"],
                    "priority"=>"紧急",
                    "pic"=>"",
                    "content"=>$message,
                    "status"=>0,
                    "creator"=>"小蜜",
                    "create_time"=>date("Y-m-d H:i:s")
                ));
            }



        }
    }

    public function actionZztip(){

        $criteria = new \CDbCriteria();
        $criteria->addCondition("status='0'");
        $shops = Shop::model()->fetchAll($criteria);
        foreach($shops as $shop){

            $exist = AdvertiserRpt::model()->exists("logdate>=? AND logdate<? AND nick=?",array(date("Y-m-d",strtotime("-15 days")),date("Y-m-d",strtotime("-7 days")),$shop["nick"]));

            if(!$exist){
                continue;
            }

            $exist = AdvertiserRpt::model()->exists("logdate>=? AND logdate<? AND nick=?",array(date("Y-m-d",strtotime("-7 days")),date("Y-m-d",strtotime("-1 days")),$shop["nick"]));

            if(!$exist){
                $message = "温馨提示：你已很长一段时间未关注智钻推广状况！";

                $model = new ShopTodoList();
                $model->setAttributes(array(
                    "logdate"=>date("Y-m-d",strtotime("+1 days")),
                    "nick"=>$shop["nick"],
                    "priority"=>"紧急",
                    "pic"=>"",
                    "content"=>$message,
                    "status"=>0,
                    "creator"=>"小蜜",
                    "create_time"=>date("Y-m-d H:i:s")
                ));
            }



        }
    }

}