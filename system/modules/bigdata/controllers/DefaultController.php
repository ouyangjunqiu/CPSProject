<?php
/**
 * @file DefaultController.php
 * @author ouyangjunqiu
 * @version Created by 16/5/31 09:18
 */

namespace application\modules\bigdata\controllers;


use cloud\core\controllers\Controller;

class DefaultController extends Controller
{
    public function actionIndex(){
        $this->render('index');
    }

}