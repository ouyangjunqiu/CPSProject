<?php
/**
 * @file YearController.php
 * @author ouyangjunqiu
 * @version Created by 16/8/11 16:06
 */

namespace application\modules\zz\controllers;


use application\modules\zuanshi\model\ShopTradeMonthRpt;
use application\modules\zz\model\AdvertiserMonthRpt;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;

class YearController extends Controller
{
    public function actionMonth(){
        $nick = Env::getQuery("nick");
        $year = date("Y");

        $source = AdvertiserMonthRpt::model()->fetchAll("logyear=? AND nick=?",array($year,$nick));
        $data = array();
        foreach($source as $row){
           $data[$row["logmonth"]] = \CJSON::decode($row["data"]);
        }

        $tradeSource = ShopTradeMonthRpt::model()->fetchAll("logyear=? AND nick=?",array($year,$nick));
        $tradeData = array();
        foreach($tradeSource as $row){
            $tradeData[$row["logmonth"]] = $row["amt"];
        }


        $this->render("month",array("data"=>$data,"trade"=>$tradeData,"query"=>array("nick"=>$nick,"year"=>$year)));
    }

}