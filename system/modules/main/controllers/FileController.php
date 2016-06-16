<?php
namespace application\modules\main\controllers;

use application\modules\main\model\ShopFile;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;

/**
 * Class FileController
 * @package application\modules\main\controllers
 * @author oshine
 */
class FileController extends Controller
{

    /**
     * 添加推广case
     */
    public function actionAdd(){
        $nick = Env::getRequest("nick");
        $filemd5 = Env::getRequest("file_md5");
        $filename = Env::getRequest("file_name");
        $creator = Env::getRequestWithDefault("creator","游客");
        $logdate = date("Y-m-d");
        $logtime = date("H:i:s");

        $attr = array(
            "nick"=>$nick,
            "file_md5"=>$filemd5,
            "file_name"=>$filename,
            "creator"=>$creator,
            "logdate"=>$logdate,
            "logtime"=>$logtime
        );

        $model = new ShopFile();
        $model->setAttributes($attr);

        if($model->save()){

            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }else{
            $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
        }
    }

    public function actionGetbynick(){
        $nick = Env::getRequest("nick");
        $list = ShopFile::model()->fetchAll("nick=? ORDER BY id DESC",array($nick));
        $this->renderJson(array("isSuccess"=>true,"data"=>array("list"=>$list)));
    }


}