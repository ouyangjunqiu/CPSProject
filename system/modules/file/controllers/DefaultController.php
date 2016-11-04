<?php
namespace application\modules\file\controllers;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;
use cloud\core\utils\File;
use application\modules\file\model\File AS FileModel;
use cloud\core\utils\MimeType;

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
            $attach = $upload->getAttach();
            $attr = array(
                "name" => $attach["name"],
                "md5" => $attach["md5"],
                "type" => $attach["type"],
                "size" => $attach["size"],
                "ext" => $attach["ext"],
                "isimage" => $attach["isimage"],
                "attachdir" => $attach["attachdir"],
                "attachname" => $attach["attachname"],
                "attachment" => $attach["attachment"],
                "target" => $attach["target"],
                "log_date" => date("Y-m-d"),
                "log_time" => date("H:i:s"),
            );
            $model = new FileModel();
            $model->setAttributes($attr);
            $model->save();
            $this->renderJson(array("isSuccess"=>true,"data"=>$upload->getAttach()));
        }else{
            $this->renderJson(array("isSuccess"=>false,"data"=>$upload->getError()));
        }
    }

    public function actionDown(){
        $md5 = Env::getQueryDefault("md5","");
        $attach = FileModel::model()->fetch("md5=?",array($md5));
        if(!empty($attach)){
            $file = File::readFile($attach["target"]);
            $mimeType = MimeType::get($attach["ext"]);
            header("Content-Type: $mimeType");//告诉浏览器输出内容类型，必须
            header('Content-Encoding: none');//内容不加密，gzip等，可选
            header("Content-Transfer-Encoding: binary" );//文件传输方式是二进制，可选
            header("Content-Length: ".$attach["size"]);//告诉浏览器文件大小，可选

            header('Content-Disposition: attachment; filename="' . $attach["name"] . '"');
            echo $file;
        }else{
            $this->error("你访问的文件不存在!",$this->createUrl("/main/default/index"));
            return;
        }
    }


}