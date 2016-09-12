<?php
/**
 * @file DefaultController.php
 * @author ouyangjunqiu
 * @version Created by 16/5/31 09:18
 */

namespace application\modules\tool\controllers;


use cloud\core\controllers\Controller;
use cloud\core\utils\Env;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionGetitem(){
        $num_iid = Env::getQuery("num_iid");
        if(empty($num_iid)){
            $this->renderJson(array("isSuccess"=>false));
            return;
        }
        $config = new \TopLinker_Config("12608680","1bf29de6e10ab7f90d2857a5c901fff2");
        $toplinker = new \TopLinker($config);
        $resp = $toplinker->load("taobao.item.get",array("num_iid"=>$num_iid,"fields"=>"detail_url,num_iid,title,pic_url,price,approve_status,nick,cid,created,list_time,delist_time,modified,props_name"));
        if($resp->hasError()){
            $this->renderJson(array("isSuccess"=>false,"msg"=>$resp->getError()));
        }
        $this->renderJson(array("isSuccess"=>true,"data"=>$resp->getData()));

    }

}