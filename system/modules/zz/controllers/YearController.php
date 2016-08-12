<?php
/**
 * @file YearController.php
 * @author ouyangjunqiu
 * @version Created by 16/8/11 16:06
 */

namespace application\modules\zz\controllers;


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

        $this->render("month",array("data"=>$data,"query"=>array("nick"=>$nick,"year"=>$year)));
    }

}