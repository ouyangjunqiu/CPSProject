<?php
/**
 * @file WeekrptController.php
 * @author ouyangjunqiu
 * @version Created by 16/8/22 15:22
 */

namespace application\modules\zz\controllers;


use cloud\core\controllers\Controller;
use cloud\core\utils\Env;

class WeekrptController extends Controller
{
    public function actionIndex(){
        $nick = Env::getSession("nick","","zuanshi.weekrpt.index");
        $orderby = Env::getSession("orderby","charge","zuanshi.weekrpt.index");
        $date = Env::getSession("date",date("Y-m-d"),"zuanshi.weekrpt.index");

        $this->render("index",array("query"=>array(
            "nick"=>$nick,
            "orderby"=>$orderby,
            "date"=>$date
        )));

    }

}