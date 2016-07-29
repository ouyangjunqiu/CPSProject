<?php
namespace application\modules\main\utils;
use application\modules\main\model\Shop;
use cloud\core\utils\Env;

/**
 * @file ShopSearch.php
 * @author ouyangjunqiu
 * @version Created by 16/7/29 10:37
 */
class ShopSearch {
    /**
     * @return array
     */
    public static function openlist(){

        $page = Env::getSession("page",1,"main.default.index");
        $pageSize = Env::getSession("page_size",PAGE_SIZE,"main.default.index");
        $q = Env::getSession("q","","main.default.index");

        $pic = Env::getSession("pic","","main.default.index");

        $criteria = new \CDbCriteria();
        $criteria->addCondition("status='0'");
        if(!empty($pic)) {
            $criteria->addCondition("(pic LIKE '%{$pic}%' OR zuanshi_pic LIKE '%{$pic}%' OR bigdata_pic LIKE '%{$pic}%' OR ztc_pic  LIKE '%{$pic}%')");
        }
        if(!empty($q)) {
            $criteria->addCondition("(shopcatname LIKE '%{$q}%' OR shoptype LIKE '%{$q}%' OR nick LIKE '%{$q}%' OR pic LIKE '%{$q}%' OR zuanshi_pic LIKE '%{$q}%' OR bigdata_pic LIKE '%{$q}%' OR ztc_pic  LIKE '%{$q}%')");
        }

        $count = Shop::model()->count($criteria);

        $criteria->offset = ($page-1)*$pageSize;
        $criteria->limit = $pageSize;

        $list = Shop::model()->fetchAll($criteria);

        return array(
            "list"=>$list,
            "pager"=>array(
                "count"=>$count,
                "page"=>$page,
                "page_size"=>$pageSize
            ),
            "query"=>array("q"=>$q,"pic"=>$pic)
        );
    }
}