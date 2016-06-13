<?php
namespace application\modules\main\widgets;
use application\modules\main\model\ShopContact;
use CWidget;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015-12-19
 * Time: 11:01
 */
class ShopStopManagerWidget extends CWidget
{
    public $shop;

    public function run(){
        $contact = ShopContact::fetchByNick($this->shop["nick"]);
        $row = array_merge($this->shop,$contact);
        return $this->render("application.modules.main.widgets.views.shopstoplist",array("row"=>$row));
    }

}