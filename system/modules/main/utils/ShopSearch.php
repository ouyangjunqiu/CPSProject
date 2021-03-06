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
        $order = Env::getSession("order","","main.default.index");

        $criteria = new \CDbCriteria();
        $criteria->addCondition("status='0'");
        if(!empty($pic)) {
            $criteria->addCondition("(pic LIKE '%{$pic}%' OR zuanshi_pic LIKE '%{$pic}%' OR bigdata_pic LIKE '%{$pic}%' OR ztc_pic  LIKE '%{$pic}%' OR sub_pic  LIKE '%{$pic}%')");
        }
        if(!empty($q)) {

            $q = StringUtil::tagFormat($q);
            $arr = explode(",",$q);

            foreach($arr as $o){

                $condition = "(shopname LIKE '%{$o}%' OR shopcatname LIKE '%{$o}%' OR nick LIKE '%{$o}%' OR pic LIKE '%{$o}%' OR zuanshi_pic LIKE '%{$o}%' OR bigdata_pic LIKE '%{$o}%' OR ztc_pic  LIKE '%{$o}%' OR sub_pic  LIKE '%{$o}%')";
                $criteria->addCondition($condition);
            }
        }

        $count = Shop::model()->count($criteria);

        if(!empty($order)){
            $criteria->order = " enddate ASC ";
        }

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
            "query"=>array("q"=>$q,"pic"=>$pic,"order"=>$order)
        );
    }

    public static function openAll(){

        $q = Env::getSession("q","","main.default.index");

        $pic = Env::getSession("pic","","main.default.index");

        $criteria = new \CDbCriteria();
        $criteria->addCondition("status='0'");
        if(!empty($pic)) {
            $criteria->addCondition("(pic LIKE '%{$pic}%' OR zuanshi_pic LIKE '%{$pic}%' OR bigdata_pic LIKE '%{$pic}%' OR ztc_pic  LIKE '%{$pic}%' OR sub_pic  LIKE '%{$pic}%')");
        }
        if(!empty($q)) {
            $q = StringUtil::tagFormat($q);
            $arr = explode(",",$q);

            foreach($arr as $o){
                $condition = "(shopname LIKE '%{$o}%' OR shopcatname LIKE '%{$o}%' OR nick LIKE '%{$o}%' OR pic LIKE '%{$o}%' OR zuanshi_pic LIKE '%{$o}%' OR bigdata_pic LIKE '%{$o}%' OR ztc_pic  LIKE '%{$o}%' OR sub_pic  LIKE '%{$o}%')";
                $criteria->addCondition($condition);
            }
        }

        $list = Shop::model()->fetchAll($criteria);

        return $list;
    }


    /**
     * @return array
     */
    public static function hidelist(){

        $page = Env::getSession("page",1,"main.default.index");
        $pageSize = Env::getSession("page_size",PAGE_SIZE,"main.default.index");
        $q = Env::getSession("q","","main.default.index");

        $pic = Env::getSession("pic","","main.default.index");
        $order = Env::getSession("order","","main.default.index");

        $criteria = new \CDbCriteria();
        $criteria->addCondition("status='0'");
        $criteria->addCondition("ishide='1'");
        if(!empty($pic)) {
            $criteria->addCondition("(pic LIKE '%{$pic}%' OR zuanshi_pic LIKE '%{$pic}%' OR bigdata_pic LIKE '%{$pic}%' OR ztc_pic  LIKE '%{$pic}%' OR sub_pic  LIKE '%{$pic}%')");
        }
        if(!empty($q)) {

            $q = StringUtil::tagFormat($q);
            $arr = explode(",",$q);

            foreach($arr as $o){

                $condition = "(shopname LIKE '%{$o}%' OR shopcatname LIKE '%{$o}%' OR nick LIKE '%{$o}%' OR pic LIKE '%{$o}%' OR zuanshi_pic LIKE '%{$o}%' OR bigdata_pic LIKE '%{$o}%' OR ztc_pic  LIKE '%{$o}%' OR sub_pic  LIKE '%{$o}%')";
                $criteria->addCondition($condition);
            }
        }

        $count = Shop::model()->count($criteria);

        if(!empty($order)){
            $criteria->order = " enddate ASC ";
        }

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
            "query"=>array("q"=>$q,"pic"=>$pic,"order"=>$order)
        );
    }
}