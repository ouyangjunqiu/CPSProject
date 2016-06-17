<?php
namespace application\modules\ztc\controllers;
use application\modules\main\model\Shop;
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
        $page = Env::getRequestWithSessionDefault("page",1,"main.default.index.page");
        $pageSize = Env::getRequestWithSessionDefault("page_size",PAGE_SIZE,"main.default.index.pagesize");
        $q = Env::getRequestWithSessionDefault("q","","main.default.index.q");
        $q = addslashes($q);
        $view = Env::getRequest("view");

        $page = (int)$page;
        $pageSize = (int)$pageSize;

        $pic = Env::getRequestWithSessionDefault("pic","","main.default.index.pic");
        $pic = addslashes($pic);

        $criteria = new \CDbCriteria();
        $criteria->addCondition("status='0'");
        if(!empty($q)) {
            $criteria->addCondition("(nick LIKE '%{$q}%' OR pic LIKE '%{$q}%' OR zuanshi_pic LIKE '%{$q}%' OR bigdata_pic LIKE '%{$q}%' OR ztc_pic  LIKE '%{$q}%')");
        }

        if(!empty($pic)) {
            $criteria->addCondition("(pic LIKE '%{$pic}%' OR zuanshi_pic LIKE '%{$pic}%' OR bigdata_pic LIKE '%{$pic}%' OR ztc_pic  LIKE '%{$pic}%')");
        }

        $count = Shop::model()->count($criteria);

        $criteria->offset = ($page-1)*$pageSize;
        $criteria->limit = $pageSize;

        $list = Shop::model()->fetchAll($criteria);

        if(strtolower($view) == "charts"){
            $this->render("chart", array("list" => $list, "pager" => array("count" => $count, "page" => $page, "page_size" => $pageSize), "query" => array("q" => $q,"pic"=>$pic)));
        }else {
            $this->render("index", array("list" => $list, "pager" => array("count" => $count, "page" => $page, "page_size" => $pageSize), "query" => array("q" => $q,"pic"=>$pic)));
        }
    }

}