<?php
/**
 * @file ShopTodoWidget.php
 * @author ouyangjunqiu
 * @version Created by 16/5/19 09:14
 */

namespace application\modules\main\widgets;


use application\modules\user\model\User;
use application\modules\user\model\UserTodoWeekRpt;
use cloud\Cloud;
use cloud\core\utils\Env;
use CWidget;

class ShopTodoWidget extends CWidget
{
    public function run(){

        $users = array();
        $list = UserTodoWeekRpt::model()->fetchAll();
        foreach($list as $v){
            $users[] = array(
                "id"=>$v["username"],
                "text"=>$v["username"]
            );
        }

        $user = Env::getUser();

        $this->render("application.modules.main.widgets.views.todo",array(
            "urls"=>array(
                "todo_add_url"=>Cloud::app()->getUrlManager()->createUrl('/main/todo/add'),
                "todo_done_url"=>Cloud::app()->getUrlManager()->createUrl('/main/todo/done'),
                "todo_del_url"=>Cloud::app()->getUrlManager()->createUrl('/main/todo/del'),
            ),
            "users"=>$users,
            "user"=>$user
        ));
    }

}