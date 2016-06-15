<?php
namespace application\modules\file\controllers;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;

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

}