<?php
namespace application\modules\ztc\controllers;
use application\modules\main\model\Shop;
use application\modules\main\utils\ShopSearch;
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

        $data = ShopSearch::openlist();

        $this->render("index", $data);
    }

}