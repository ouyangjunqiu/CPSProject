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

class TodoController extends Controller
{
    public function actionAdd(){
        $logdate = Env::getRequest("logdate");
        $nick = Env::getRequest("nick");
        $content = Env::getRequest("content");
        $priority = Env::getRequestWithDefault("priority","普通");
        $pic = Env::getRequest("pic");
        $creator = Env::getRequestWithDefault("creator","游客");
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

    public function actionDone(){
        $id = Env::getRequest("id");
        $updator = Env::getRequestWithDefault("updator","游客");

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
        $id = Env::getRequest("id");
        $updator = Env::getRequestWithDefault("updator","游客");
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
        $nick = Env::getRequest("nick");

        $history = ShopTodoList::fetchHistoryListByNick($nick);
        $list = ShopTodoList::fetchCurrentListByNick($nick);

        $this->renderJson(array(
            "isSuccess"=>true,
            "data"=>array(
                "history"=>$history,
                "list"=>$list
            ),
            "query"=>array(
                "nick"=>$nick,
                "md5"=>md5($nick)
            )
        ));

    }

    public function actionMy(){
        $pic = Env::getRequest("pic");
        $list = ShopTodoList::fetchListByPic($pic);
        $this->renderJson(array(
            "isSuccess"=>true,
            "data"=>array(
                "list"=>$list
            ),
        ));
    }

    public function actionMytips(){
        $pic = Env::getRequest("pic");
        $startDate = date("Y-m-d",strtotime("-15 days"));
        $endDate =  date("Y-m-d");
        $count = ShopTodoList::model()->count("logdate>=? AND logdate<=? AND pic=? AND status=?",array($startDate,$endDate,$pic,0));
        $this->renderJson(array("isSuccess"=>true,"data"=>array(

            "count"=>$count

        )));
    }

    public function actionMore(){
        $nick = Env::getRequest("nick");
        $logdate = Env::getRequestWithDefault("logdate",date("Y-m-d"));
        $list = ShopTodoList::fetchRangeListByNick($nick,$logdate);
        $this->render('more',array("list"=>$list,"query"=>array("nick"=>$nick,"logdate"=>$logdate)));
    }

}