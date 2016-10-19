<?php
/**
 * @file TodoController.php
 * @author ouyangjunqiu
 * @version Created by 2016/10/19 11:45
 */

namespace application\modules\main\cli;


use application\modules\main\model\Shop;
use application\modules\main\model\ShopTodoList;
use application\modules\main\model\ShopTodoToptic;
use cloud\core\cli\Controller;

class TodoController extends Controller
{
    public function actionScws(){
        $criteria = new \CDbCriteria();
        $criteria->addCondition("status='0'");
        $shops = Shop::model()->fetchAll($criteria);
        $logdate = date("Y-m-d");
        foreach($shops as $shop){
            $todos = ShopTodoList::fetchRangeListByNick($shop["nick"],date("Y-m-d",strtotime("-7 days")),date("Y-m-d",strtotime("7 days")));
            if(empty($todos)){
                continue;
            }

            $text = "";
            foreach($todos as $todo){
                $text.=str_replace("<small>[链接]</small>","",$todo["title"]).".\n";
            }

            $so = scws_new();

            $so->send_text($text);
            $result = $so->get_tops(5);
            $so->close();

            $data = array();
            $result = \CJSON::decode(\CJSON::encode($result),true);
            foreach($result as $row){
                if($row["times"]>=5){
                    $data[] = $row;
                }
            }

            if(empty($data)){
                continue;
            }


            $attrs = array("nick"=>$shop["nick"],"logdate"=>$logdate,"data"=>\CJSON::encode($data));
            ShopTodoToptic::model()->deleteAll("logdate=? AND nick=?",array($logdate,$shop["nick"]));
            $model = new ShopTodoToptic();
            $model->setAttributes($attrs);
            if(!$model->save()){
                print_r($model->getErrors());
            }
        }
    }

}