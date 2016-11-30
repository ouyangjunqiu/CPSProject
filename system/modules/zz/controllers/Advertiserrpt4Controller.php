<?php
/**
 * @file AdvertiserrptController.php
 * @author ouyangjunqiu
 * @version Created by 16/7/28 15:46
 */

namespace application\modules\zz\controllers;

use application\modules\zz\model\Advertiser4Rpt;
use application\modules\zz\model\Advertiser4RptSource;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;

class Advertiserrpt4Controller extends Controller
{
    public function actionSource(){
        $logdate = date("Y-m-d");
        $nick = Env::getRequest("nick");
        $effectType = Env::getRequest("effectType");
        $effect = Env::getRequest("effect");
        $data = Env::getRequest("data");
        $effectType = ($effectType=="click"?"click":"impression");
        Advertiser4RptSource::model()->deleteAll("logdate=? AND nick=? AND effectType=? AND effect=?",array($logdate,$nick,$effectType,$effect));
        $model = new Advertiser4RptSource();
        $model->setAttributes(array(
            "logdate" => $logdate,
            "nick" => $nick,
            "effectType" => $effectType,
            "effect" => $effect,
            "data" => $data
        ));

        if($model->save()) {

            $rpts = json_decode($data, true);
            foreach($rpts as $rpt){
                if(!empty($rpt["logDate"])){
                    Advertiser4Rpt::model()->deleteAll("logdate=? AND nick=? AND effectType=? AND effect=?",array($rpt["logDate"],$nick,$effectType,$effect));
                    $listModel = new Advertiser4Rpt();
                    $listModel->setAttributes(array(
                        "logdate" => $rpt["logDate"],
                        "nick" => $nick,
                        "effectType" => $effectType,
                        "effect" => $effect,
                        "data" => \CJSON::encode($rpt)
                    ));
                    $listModel->save();
                }

            }
            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }else{
            $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
        }

    }

}