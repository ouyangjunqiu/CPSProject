<?php
/**
 * @file DefaultController.php
 * @author ouyangjunqiu
 * @version Created by 16/5/31 09:18
 */

namespace application\modules\tool\controllers;


use application\modules\tool\model\Category;
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
        $config = new \TopLinker_Config("21115760","f07253aa9f3d494fb7b01c85bec1fc0f");
        $toplinker = new \TopLinker($config);
        $resp = $toplinker->load("taobao.item.get",array("num_iid"=>$num_iid,"fields"=>"detail_url,num_iid,title,pic_url,price,approve_status,nick,cid,created,list_time,delist_time,modified,props_name"));
        if($resp->hasError()){
            $this->renderJson(array("isSuccess"=>false,"msg"=>$resp->getError()));
        }

        $item = $resp->getData("item");
        $item = \CJSON::decode(\CJSON::encode($item));
        $item["category_tree"] = Category::getTreeText($item["cid"]);
        $props = explode(";",$item["props_name"]);
        if(!empty($props)){
            foreach($props as $prop){
                $item["props"][] = explode(":",$prop);
            }
        }
        $this->renderJson(array("isSuccess"=>true,"data"=>$item));

    }

}