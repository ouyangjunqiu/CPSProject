<?php
/**
 * @file ShopController.php
 * @author ouyangjunqiu
 * @version Created by 16/5/23 15:04
 */

namespace application\modules\main\cli;

use application\modules\main\model\Shop;
use application\modules\main\model\ShopLog;
use cloud\core\cli\Controller;

class ShopController extends Controller
{
    public function actionIndex(){
        $shops = Shop::model()->fetchAll();
        foreach($shops as $shop){
            $attr = $shop;
            unset($attr["id"]);
            $attr["logdate"] = date("Y-m-d");

            $model = new ShopLog();
            $model->setAttributes($attr);
            if(!$model->save()){
                print_r($model);
            }
        }

    }

    public function actionOff(){
        $criteria = new \CDbCriteria();
        $criteria->addCondition("status='1'");
        $shops = Shop::model()->findAll($criteria);
        foreach($shops as $shop){
            $shop->status = 2;

            $shop->off_date = date("Y-m-d");

            if(!$shop->save()){
                print_r($shop);
            }
        }
    }

}