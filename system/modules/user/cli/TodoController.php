<?php
namespace application\modules\user\cli;
use application\modules\main\model\ShopTodoList;
use application\modules\user\model\User;
use application\modules\user\model\UserTodoWeekRpt;
use cloud\core\cli\Controller;

class TodoController extends Controller
{
    public function actionIndex(){
        $users = User::model()->fetchAll();
        $begindate = date("Y-m-d",strtotime("-7 days"));
        $enddate = date("Y-m-d");
        foreach($users as $user){
            UserTodoWeekRpt::model()->deleteAll("username=?",array($user["name"]));

            $model = new UserTodoWeekRpt();
            $model->setAttributes(array(
                "username"=>$user["name"],
                "c"=>ShopTodoList::model()->count("logdate>=? AND logdate<=? AND pic=?",array($begindate,$enddate,$user["name"])),
                "c0"=>ShopTodoList::model()->count("logdate>=? AND logdate<=? AND pic=? AND status=?",array($begindate,$enddate,0)),
                "c1"=>ShopTodoList::model()->count("logdate>=? AND logdate<=? AND pic=? AND status=?",array($begindate,$enddate,1)),
                "c2"=>ShopTodoList::model()->count("logdate>=? AND logdate<=? AND pic=? AND status=?",array($begindate,$enddate,2)),
            ));

            if(!$model->save()){
                print_r($model->getErrors());
            }

        }

    }

}