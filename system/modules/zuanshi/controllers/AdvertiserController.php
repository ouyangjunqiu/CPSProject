<?php
/**
 * Created by PhpStorm.
 * User: ouyangjunqiu
 * Date: 16/3/31
 * Time: 下午2:12
 */

namespace application\modules\zuanshi\controllers;


use cloud\core\controllers\Controller;
use cloud\core\utils\Env;
use application\modules\zuanshi\model\AdvertiserHourRptSource;
use application\modules\zuanshi\utils\HourUtil;

class AdvertiserController extends Controller
{

    public function actionSource(){
        $date = date("Y-m-d");
        $nick = Env::getRequest("nick");
        $hour = date("H",time());
        $hour = (int)$hour;
        $logsection = HourUtil::format();
        if($logsection<=0){
            $this->renderJson(array("isSuccess"=>false));
        }

        $nick = trim($nick);
        $accountJSON = Env::getRequest("accountdata");
        $yesterdayJSON = Env::getRequest("yesterdaydata");
        $todayJSON = Env::getRequest("todaydata");

        AdvertiserHourRptSource::model()->deleteAll("logdate=? AND logsection=? AND nick=?",array($date,$logsection,$nick));

        $model = new AdvertiserHourRptSource();
        $model->setIsNewRecord(true);
        $model->setAttributes(array(
            "logdate" => $date,
            "logsection" => $logsection,
            "loghour" => $hour,
            "nick" => $nick,
            "accountdata" => $accountJSON,
            "yesterdaydata" => $yesterdayJSON,
            "todaydata" => $todayJSON
        ));

        if($model->save()){
            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }else{
            $this->renderJson(array("isSuccess"=>false,"data"=>$model->getErrors()));
        }
    }

    public function actionMore(){
        $nick = Env::getRequest("nick");


        $rpt = AdvertiserHourRptSource::fetchListByNick($nick);

        if(!empty($rpt)){

            $this->render('more',array("data"=>$rpt,"query"=>array(
                "nick"=>$nick
            )));
        }else{
            $this->render('more',array("data"=>array(

            ),"query"=>array(
                "nick"=>$nick
            )));

        }


    }

}