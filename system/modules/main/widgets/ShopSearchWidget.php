<?php
/**
 * @file ShopSearchWidget.php
 * @author ouyangjunqiu
 * @version Created by 16/5/18 10:44
 */

namespace application\modules\main\widgets;


use cloud\core\utils\Env;
use CWidget;

class ShopSearchWidget extends CWidget
{
    public $url;

    public $query;

    public function run(){
        $user = Env::getUser();
        return $this->render("application.modules.main.widgets.views.search",array("url"=>$this->url,"query"=>$this->query,"user"=>$user));
    }

}