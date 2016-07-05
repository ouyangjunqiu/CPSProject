<?php

/**
 * main模块的默认控制器
 * 
 * @version $Id: DefaultController.php oShine $
 * @package application.modules.main.controllers
 */

namespace application\modules\main\controllers;

use cloud\core\controllers\Controller;
use cloud\core\utils\Env;
use application\modules\main\model\Shop;

class DefaultController extends Controller
{

	/**
	 * 布局类型
	 * @var string
	 */
	public $layout = 'application.theme.default.views.layouts.main';

	/**
	 * 店铺列表
	 * @return void
	 */
	public function actionIndex()
	{
		$page = Env::getRequestWithSessionDefault("page",1,"main.default.index.page");
		$pageSize = Env::getRequestWithSessionDefault("page_size",PAGE_SIZE,"main.default.index.pagesize");
		$q = Env::getRequestWithSessionDefault("q","","main.default.index.q");
		$q = addslashes($q);
		$pic = Env::getRequestWithSessionDefault("pic","","main.default.index.pic");
		$pic = addslashes($pic);
		$shoptype = Env::getQuery("shoptype");
		$page = (int)$page;
		$pageSize = (int)$pageSize;

		$criteria = new \CDbCriteria();
		$criteria->addCondition("status='0'");
		if(!empty($pic)) {
			$criteria->addCondition("(pic LIKE '%{$pic}%' OR zuanshi_pic LIKE '%{$pic}%' OR bigdata_pic LIKE '%{$pic}%' OR ztc_pic  LIKE '%{$pic}%')");
		}
		if(!empty($q)) {
			$criteria->addCondition("(shopcatname LIKE '%{$q}%' OR shoptype LIKE '%{$q}%' OR nick LIKE '%{$q}%' OR pic LIKE '%{$q}%' OR zuanshi_pic LIKE '%{$q}%' OR bigdata_pic LIKE '%{$q}%' OR ztc_pic  LIKE '%{$q}%')");
		}
		if(!empty($shoptype)) {
			$criteria->addCondition("shoptype = '{$shoptype}'");
		}

		$count = Shop::model()->count($criteria);

		$criteria->offset = ($page-1)*$pageSize;
		$criteria->limit = $pageSize;

		$list = Shop::model()->fetchAll($criteria);

		$this->render("index",array("list"=>$list,"pager"=>array("count"=>$count,"page"=>$page,"page_size"=>$pageSize),"query"=>array("q"=>$q,"pic"=>$pic)));
	}

	/**
	 * 暂停的店铺列表
	 */
	public function actionStoplist(){
		$page = Env::getRequestWithSessionDefault("page",1,"main.default.index.page");
		$pageSize = Env::getRequestWithSessionDefault("page_size",PAGE_SIZE,"main.default.index.pagesize");
		$q = Env::getRequestWithSessionDefault("q","","main.default.index.q");
		$q = addslashes($q);
		$pic = Env::getRequestWithSessionDefault("pic","","main.default.index.pic");
		$pic = addslashes($pic);
		$page = (int)$page;
		$pageSize = (int)$pageSize;
		$shoptype = Env::getRequest("shoptype");

		$criteria = new \CDbCriteria();
		$criteria->addInCondition("status",array(1,2));
		if(!empty($pic)) {
			$criteria->addCondition("(pic LIKE '%{$pic}%' OR zuanshi_pic LIKE '%{$pic}%' OR bigdata_pic LIKE '%{$pic}%' OR ztc_pic  LIKE '%{$pic}%')");
		}
		if(!empty($q)) {
			$criteria->addCondition("(shopcatname LIKE '%{$q}%' OR shoptype LIKE '%{$q}%' OR nick LIKE '%{$q}%' OR pic LIKE '%{$q}%' OR zuanshi_pic LIKE '%{$q}%' OR bigdata_pic LIKE '%{$q}%' OR ztc_pic  LIKE '%{$q}%')");
		}
		if(!empty($shoptype)) {
			$criteria->addCondition("shoptype = '{$shoptype}'");
		}

		$count = Shop::model()->count($criteria);

		$criteria->offset = ($page-1)*$pageSize;
		$criteria->limit = $pageSize;

		$list = Shop::model()->fetchAll($criteria);

		$this->render("stoplist",array("list"=>$list,"pager"=>array("count"=>$count,"page"=>$page,"page_size"=>$pageSize),"query"=>array("q"=>$q,"pic"=>$pic)));
	}


}
