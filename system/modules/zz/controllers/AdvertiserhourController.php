<?php
/**
 * Created by PhpStorm.
 * User: ouyangjunqiu
 * Date: 16/3/31
 * Time: 下午2:12
 */

namespace application\modules\zz\controllers;


use cloud\core\controllers\Controller;
use cloud\core\utils\Env;
use application\modules\zz\model\AdvertiserHourRptSource;

class AdvertiserhourController extends Controller
{

    public function actionSource(){
        $logdate = date("Y-m-d");
        $nick = Env::getRequest("nick");
        $hour = date("H",time());
        $loghour = (int)$hour;

        $nick = trim($nick);
        $accountJSON = Env::getRequest("account");
        $yesterdayJSON = Env::getRequest("yesterday");
        $todayJSON = Env::getRequest("data");

        AdvertiserHourRptSource::model()->deleteAll("logdate=? AND nick=?",array($logdate,$nick));

        $model = new AdvertiserHourRptSource();
        $model->setIsNewRecord(true);
        $model->setAttributes(array(
            "logdate" => $logdate,
            "loghour" => $loghour,
            "nick" => $nick,
            "account_data" => $accountJSON,
            "yesterday_data" => $yesterdayJSON,
            "data" => $todayJSON
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