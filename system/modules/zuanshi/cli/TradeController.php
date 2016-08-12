<?php
namespace application\modules\zuanshi\cli;

use application\modules\main\model\Shop;
use application\modules\zuanshi\model\ShopTradeMonthRpt;
use application\modules\zuanshi\model\ShopTradeRpt;
use cloud\core\cli\Controller;

class TradeController  extends Controller
{

    public function actionMonth(){

        for($i=1;$i<=7;$i++){
            $firstday = date('Y-m-01', strtotime("2016-0$i-05"));
            $lastday = date('Y-m-d', strtotime("$firstday +1 month -1 day"));
            $year = date("Y",strtotime($lastday));
            $month = date("m",strtotime($lastday));

            $criteria = new \CDbCriteria();
            $criteria->addCondition("status='0'");
            $shops = Shop::model()->fetchAll($criteria);
            foreach($shops as $shop){
                $total = ShopTradeRpt::summaryByNick($firstday,$lastday,$shop["shopname"]);
                if(empty($total) || empty($total["total_pay_amt"]))
                    continue;

                ShopTradeMonthRpt::model()->deleteAll("logyear=? AND nick=? AND logmonth=?",array($year,$shop["nick"],$month));

                $model = new ShopTradeMonthRpt();
                $model->setAttributes(
                    array(
                        "logyear"=>$year,
                        "nick"=>$shop["nick"],
                        "shopname"=>$shop["shopname"],
                        "logmonth"=>$month,
                        "amt"=>$total["total_pay_amt"],
                        "logdate"=>date("Y-m-d")
                    )
                );
                if(!$model->save()){
                    print_r($model->getErrors());
                }
            }
        }

    }

}