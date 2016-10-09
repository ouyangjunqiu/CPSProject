<?php
/**
 * @file TodoController.php
 * @author ouyangjunqiu
 * @version Created by 16/5/16 16:38
 */

namespace application\modules\main\controllers;

use application\modules\main\model\ShopTodoList;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;
use cloud\core\utils\ExtRangeDate;

class TodoController extends Controller
{
    public function actionAdd(){
        $logdate = Env::getRequest("logdate");
        $nick = Env::getRequest("nick");
        $content = Env::getRequest("content");
        $priority = Env::getQueryDefault("priority","普通");
        $pic = Env::getRequest("pic");
        $creator = Env::getQueryDefault("creator","游客");
        $create_time = date("Y-m-d H:i:s");
        $status = 0;

        $model = new ShopTodoList();
        $model->setAttributes(
            array(
                "logdate" => $logdate,
                "nick" => $nick,
                "pic" => $pic,
                "content" => $content,
                "priority" => $priority,
                "status" => $status,
                "creator" => $creator,
                "create_time" => $create_time
            )
        );

        if($model->save()){
            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }else{
            $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
        }
    }

    public function actionBatchadd(){
        $logdate = Env::getRequest("logdate");
        $nick = Env::getRequest("nick");
        $content = Env::getRequest("content");
        $priority = Env::getQueryDefault("priority","普通");
        $pic = Env::getRequest("pic");
        $creator = Env::getQueryDefault("creator","游客");
        $create_time = date("Y-m-d H:i:s");
        $status = 0;

        if(!empty($pic) && count($pic)>=0){

            foreach($pic as $v){

                $model = new ShopTodoList();
                $model->setAttributes(
                    array(
                        "logdate" => $logdate,
                        "nick" => $nick,
                        "pic" => $v,
                        "content" => $content,
                        "priority" => $priority,
                        "status" => $status,
                        "creator" => $creator,
                        "create_time" => $create_time
                    )
                );

                $model->save();
            }
        }
        $this->renderJson(array("isSuccess"=>true));
    }

    public function actionDone(){
        $id = Env::getQuery("id");
        $updator = Env::getQueryDefault("updator","游客");

        $update_time = date("Y-m-d H:i:s");
        $model = ShopTodoList::model()->findByPk($id);
        if($model == null){
            $this->renderJson(array("isSuccess"=>false));
        }
        $model->setAttributes(
            array(
                "status" => 1,
                "updator" => $updator,
                "update_time" => $update_time
            )
        );
        if($model->save()){
            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }else{
            $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
        }
    }

    public function actionDel(){
        $id = Env::getQuery("id");
        $updator = Env::getQueryDefault("updator","游客");
        $update_time = date("Y-m-d H:i:s");
        $model = ShopTodoList::model()->findByPk($id);
        if($model == null){
            $this->renderJson(array("isSuccess"=>false));
        }
        $model->setAttributes(
            array(
                "status" => 2,
                "updator" => $updator,
                "update_time" => $update_time
            )
        );
        if($model->save()){
            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }else{
            $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
        }
    }

    public function actionGetbynick(){
        try{
            $nick = Env::getQuery("nick");

            $history = ShopTodoList::fetchHistoryListByNick($nick);
            $list = ShopTodoList::fetchCurrentListByNick($nick);

            $this->renderJson(array(
                "isSuccess"=>true,
                "data"=>array(
                    "history"=>$history,
                    "list"=>$list
                ),
                "query"=>array(
                    "nick"=>mb_convert_encoding($nick,"utf-8","auto"),
                    "md5"=>md5($nick)
                )
            ));
        }catch(\Exception $e){
            $this->renderJson(array(
                "isSuccess"=>false,
                "msg"=>$e->getMessage(),
                "code"=>$e->getCode()
            ));
        }

    }

    public function actionMy(){
        $pic = Env::getQuery("pic");
        $list = ShopTodoList::fetchListByPic($pic);
        $this->renderJson(array(
            "isSuccess"=>true,
            "data"=>array(
                "list"=>$list
            ),
        ));
    }

    public function actionMycreate(){
        $pic = Env::getQuery("pic");
        $list = ShopTodoList::fetchListByCreator($pic);
        $this->renderJson(array(
            "isSuccess"=>true,
            "data"=>array(
                "list"=>$list
            ),
        ));
    }



    public function actionMytips(){
        $pic = Env::getQuery("pic");
        $startDate = date("Y-m-d",strtotime("-7 days"));
        $endDate =  date("Y-m-d");
        $count = ShopTodoList::model()->count("logdate>=? AND logdate<=? AND pic=? AND status=?",array($startDate,$endDate,$pic,0));
        $this->renderJson(array("isSuccess"=>true,"data"=>array(

            "count"=>$count

        )));
    }

    public function actionMore(){
        $nick = Env::getQuery("nick");
        $rangeDate = ExtRangeDate::rangeNow(15);
        $startdate = Env::getSession("begin_date",$rangeDate->startDate,"main.todo.more");
        $enddate = Env::getSession("end_date",$rangeDate->endDate,"main.todo.more");
        $list = ShopTodoList::fetchRangeListByNick($nick,$startdate,$enddate);
        $this->render('more',array("list"=>$list,"query"=>array("nick"=>$nick,"beginDate"=>$startdate,"endDate"=>$enddate)));
    }

}