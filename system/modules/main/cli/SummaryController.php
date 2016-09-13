<?php

namespace application\modules\main\cli;

use application\modules\main\model\Shop;
use application\modules\main\model\ShopMonthRpt;
use cloud\core\cli\Controller;

class SummaryController extends Controller
{
    public function actionMonth(){
        $year = date("Y");
        $month = date("n");

        $opentotal = Shop::model()->count("status=0");
        $stoptotal = Shop::model()->count("status=1");
        $overtotal = Shop::model()->count("status=2");

        $data = array("total"=>array(
            "open"=>$opentotal,
            "stop"=>$stoptotal,
            "over"=>$overtotal
        ));

        $data["shop"] = array();
        $shops = Shop::model()->fetchAll("status!=2");
        foreach($shops as $shop){
            $data["shop"][] = $shop["nick"];
        }

        ShopMonthRpt::model()->deleteAll("year=? AND month=?",array($year,$month));
        $model = new ShopMonthRpt();
        $model->setAttributes(array(
            "year" => $year,
            "month" => $month,
            "data" => \CJSON::encode($data)
        ));

        if(!$model->save()){
            print_r($model->getErrors());
        }
    }


}