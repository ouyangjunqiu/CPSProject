<?php
/**
 * @file ShopPlanWidget.php
 * @author ouyangjunqiu
 * @version Created by 16/5/23 11:20
 */

namespace application\modules\main\widgets;

use cloud\Cloud;
use CWidget;

class ShopPlanWidget extends CWidget
{
    public $nick;

    public function run(){
        $shopPlanGetUrl = Cloud::app()->getUrlManager()->createUrl("/main/plan/getbynick",array("nick"=>$this->nick));
        $shopPlanSetUrl = Cloud::app()->getUrlManager()->createUrl("/main/plan/budgetset");

        return $this->render("application.modules.main.widgets.views.plan",array(
            "urls"=>array(
                "shop_plan_get"=>$shopPlanGetUrl,
                "shop_plan_set"=>$shopPlanSetUrl
            ),
            "nick"=>$this->nick,
            "id"=>"shopplan-".md5($this->nick)
        ));

    }

}