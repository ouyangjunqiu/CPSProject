<?php
/**
 * @file RptController.php
 * @author ouyangjunqiu
 * @version Created by 2016/9/22 09:57
 */

namespace application\modules\tool\controllers;

use application\modules\tool\model\DataRptTask;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;

class DataController extends Controller
{
    public function actionIndex(){

        $this->render("index",array("query"=>array("beginDate"=>date("Y-m-d",strtotime("-18 days")),"endDate"=>date("Y-m-d",strtotime("-3 days")),"dataType"=>DataRptTask::$dataType)));
    }

    public function actionDown(){
        $param["TableType"] = Env::getRequest("datatype");
        $param["Begin_Time"] = Env::getRequest("begin_time");
        $param["End_Time"] = Env::getRequest("end_time");
        $categoryname = Env::getRequest("categoryname");
        if(!empty($categoryname)){
            $param["Categoryname"] = explode(",",$categoryname);
        }else{
            $param["Categoryname"] = array();
        }
        $shopname = Env::getRequest("Shopname");
        if(!empty($shopname)) {
            $param["Shopname"] = explode(",",$shopname);
        }else{
            $param["Shopname"] = array();
        }

        $param["TaskId"] = time().rand(1,999999);
        $param["TableTypeName"] = DataRptTask::$dataType[$param["TableType"]];

        $pakage[] = $param;

        $model = new DataRptTask();
        $model->setAttributes(array(
            "logdate"=>date("Y-m-d"),
            "taskid"=>$param["TaskId"],
            "params"=>json_encode($pakage),
            "code"=>0,
            "result"=>"",
            "createtime"=>date("Y-m-d H:i:s")
        ));

        if(!$model->save()){
            $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
        }else{
            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }

    }

    public function actionGetfile(){
        $id = Env::getRequest("id");
        $task = DataRptTask::model()->fetchByPk($id);
        if(!empty($task)){
            $result = \CJSON::decode($task["result"]);
            if(empty($result) || $result["Status"] !== "Success"){
                $this->error("任务还未完成，请稍等！",$this->createUrl("/tool/data/index"));
                return;
            }

            if(empty($result["Back_message"]) || empty($result["Back_message"]["FileAddress"])){
                $this->error("你请求的文件名为空！",$this->createUrl("/tool/data/index"));
                return;
            }

            $filename = $result["Back_message"]["FileAddress"];

            if(empty($filename) || !is_file($filename)){
                $this->error("你请求的{$filename}文件不存在，请重新请求！",$this->createUrl("/tool/data/index"));
                return;
            }

            $size = filesize($filename);

            $file = file_get_contents($filename);
            header("Content-Type: application/octet-stream");//告诉浏览器输出内容类型，必须
            header('Content-Encoding: none');//内容不加密，gzip等，可选
            header("Content-Transfer-Encoding: binary" );//文件传输方式是二进制，可选
            header("Content-Length: ".$size);//告诉浏览器文件大小，可选


            header('Content-Disposition: attachment; filename="' . $task["taskid"] . '.xlsx"');
            echo $file;
        }




    }

    public function actionGetlist(){

        $logdate = date("Y-m-d",strtotime("-2 days"));
        $list = DataRptTask::model()->fetchAll("logdate>=? ORDER BY id DESC LIMIT 0,20",array($logdate));
        foreach($list as &$row){
            $row["params_obj"] = \CJSON::decode($row["params"]);
            $row["result_obj"] = \CJSON::decode($row["result"]);
        }
        $this->renderJson(array("isSuccess"=>true,"data"=>array("list"=>$list)));
    }

}