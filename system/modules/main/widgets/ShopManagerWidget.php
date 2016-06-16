<?php
namespace application\modules\main\widgets;
use application\modules\main\model\ShopContact;
use application\modules\main\model\ShopPlan;
use CWidget;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015-12-19
 * Time: 11:01
 */
class ShopManagerWidget extends CWidget
{
    public $shop;

    public function run(){
        $contact = ShopContact::fetchByNick($this->shop["nick"]);
        $row = array_merge($this->shop,$contact);
        $budget = ShopPlan::model()->fetch("nick=?",array($this->shop["nick"]));
        if(empty($budget)){
            $budget = array(
                "ztc_budget"=>0,
                "zuanshi_budget"=>0
            );
        }
        $row = array_merge($row,$budget);
        return $this->render("application.modules.main.widgets.views.shop",array("row"=>$row));
    }

}