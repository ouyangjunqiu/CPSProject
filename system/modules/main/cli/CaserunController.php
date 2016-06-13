<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015-12-16
 * Time: 14:39
 */

namespace application\modules\main\cli;

use cloud\core\cli\Controller;
use application\modules\main\model\Shop;
use application\modules\main\model\ShopCaseRunLog;


class CaserunController extends Controller
{
    public function actionIndex(){
        $list = Shop::model()->fetchAll("status='0'");
        foreach($list as $shop) {
            $exists = ShopCaseRunLog::model()->exists("log_date=? AND nick=?",array(date("Y-m-d"),$shop["nick"]));
            if($exists)
                continue;
            $rows = ShopCaseRunLog::fetchBaseInfoByNick($shop["nick"]);
            foreach ($rows as $row) {
                if (!empty($row["runid"])) {
                    $row["log_date"] = date("Y-m-d");

                    print_r($row);
                    $model = new ShopCaseRunLog();
                    $model->setAttributes($row);
                    if (!$model->save()){
                       print_r($model->getErrors());
                    }
                }
            }
        }
    }


}