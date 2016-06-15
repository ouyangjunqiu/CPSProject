<?php
namespace application\modules\file\controllers;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;
use cloud\core\utils\File;

/**
 * @file DefaultController.php
 * @author ouyangjunqiu
 * @version Created by 16/5/25 17:26
 */
class DefaultController extends Controller
{
    public function actionIndex(){
        $this->render("index");
    }

    public function actionUpload(){
        $upload = File::getUpload("file","file");
        if($upload->save()){
            $this->renderJson(array("isSuccess"=>true,"data"=>$upload->getAttach()));
        }else{
            $this->renderJson(array("isSuccess"=>false,"data"=>$upload->getError()));
        }
    }

}