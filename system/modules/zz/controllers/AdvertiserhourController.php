<?php
/**
 * Created by PhpStorm.
 * User: ouyangjunqiu
 * Date: 16/3/31
 * Time: 下午2:12
 */

namespace application\modules\zz\controllers;


use application\modules\main\utils\ShopSearch;
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


    public function actionGetbynick(){
        $nick = Env::getQueryDefault("nick","");
        $rpt = AdvertiserHourRptSource::fetchSummaryByNick($nick);
        if(empty($rpt)){
            $this->renderJson(array("isSuccess"=>false,"data"=>array("list"=>array())));
            return;
        }

        $this->renderJson(array("isSuccess"=>true,"data"=>$rpt));
        return;
    }

    public function actionGetlist(){
        $nick = Env::getRequest("nick");
        $logdate = Env::getRequest("logdate");
        if(empty($nick) || empty($logdate) || !is_array($nick) || count($nick)>200){
            $this->renderJson(array("isSuccess"=>false,"msg"=>"请提供正确的参数！"));
            return;
        }
        $c = new \CDbCriteria();
        $c->addCondition("logdate='{$logdate}'");
        $c->addInCondition("nick",$nick);
        $source = AdvertiserHourRptSource::model()->fetchAll($c);
        $result = array();
        foreach($source as $row){
            $rpt = \CJSON::decode($row["data"]);
            $rpt["nick"] = $row["nick"];
            $result[] = $rpt;
        }
        $this->renderJson(array("isSuccess"=>true,"data"=>$result));
        return;

    }

    public function actionIndex(){
        $data = ShopSearch::openlist();
        $this->render("index",$data);
    }


}