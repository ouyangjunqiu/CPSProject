<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-01-18
 * Time: 15:20
 */

namespace application\modules\dmp\controllers;


use cloud\core\controllers\Controller;
use application\modules\dmp\model\Tag;

class TagController extends Controller
{
    public function actionIndex(){

        $list = Tag::model()->fetchAll();
        $this->render("index",array("list"=>$list));

    }

}