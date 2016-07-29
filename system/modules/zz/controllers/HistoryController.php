<?php
/**
 * @file HistoryController.php
 * @author ouyangjunqiu
 * @version Created by 16/7/29 15:33
 */

namespace application\modules\zz\controllers;

use application\modules\zz\model\AdboardRptHistory;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;

class HistoryController extends Controller
{
    public function actionAdboard(){
        $nick = Env::getRequest("nick");
        $offset = Env::getRequest("offset");
        $data = Env::getRequest("data");
        $logdate = Env::getRequest("logdate");
        $effectType = Env::getRequest("effectType");
        $effect = Env::getRequest("effect");
        $effectType = ($effectType=="click"?"click":"impression");
        $nick = trim($nick);

        AdboardRptHistory::model()->deleteAll("logdate=? AND nick=? AND effectType=? AND effect=? AND offset=?",array($logdate,$nick,$effectType,$effect,$offset));
        $model = new AdboardRptHistory();
        $model->setAttributes(array(
            "nick"=>$nick,
            "offset"=>$offset,
            "effectType"=>$effectType,
            "effect"=>$effect,
            "logdate"=>$logdate,
            "data"=>$data
        ));

        if($model->save()){
            $this->renderJson(array(
                "isSuccess"=>true,
                "data"=>$model
            ));
        }else{
            $this->renderJson(array(
                "isSuccess"=>false,
                "data"=>$model->getErrors()
            ));
        }
    }
}