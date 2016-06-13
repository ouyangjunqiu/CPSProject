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
use application\modules\main\model\ShopCaseRunRpt;
use application\modules\main\model\ShopCaseRunRptWeek;

class CaserunrptController extends Controller
{
    public function actionDay(){
        $list = Shop::model()->fetchAll("status='0'");
        foreach($list as $shop) {
            $exists = ShopCaseRunRpt::model()->exists("log_date=? AND nick=?",array(date("Y-m-d"),$shop["nick"]));
            if($exists)
                continue;
            $rows = ShopCaseRunRpt::fetchBaseInfoByNick($shop["nick"]);
            foreach ($rows as $row) {
                if (!empty($row["runid"])) {
                    $data = array(
                        "nick" => $row["nick"],
                        "log_date" => date("Y-m-d"),
                        "planid" => $row["planid"],
                        "plan_budget" => $row["plan_budget"],
                        "caseid" => $row["caseid"],
                        "casetype" => $row["casetype"],
                        "luodiye" => $row["luodiye"],
                        "luodiye_alias" => $row["luodiye_alias"],
                        "case_budget" => $row["case_budget"],
                        "runid" => $row["runid"],
                        "rundept" => $row["rundept"],
                        "run_budget" => $row["run_budget"],
                        "remark" =>  $row["remark"],
                        "cost" => 0,
                        "roi" => 0,
                        "budget_ok" => 0,
                        "rpt_ok" => 0
                    );
                    $model = new ShopCaseRunRpt();
                    $model->setAttributes($data);
                    if (!$model->save()){
                        print_r($model->getErrors());
                    }
                }
            }
        }
    }

    public function actionIndex(){

        $endDate = date("Y-m-d",strtotime("-1 week Friday"));

        $year = date("Y",strtotime($endDate));
        $month = date("Ym",strtotime($endDate));

        $startDate = date("Y-m-d",strtotime("-6 days",strtotime($endDate)));
        $w = date("W",strtotime($endDate));
        $w = (int)$w;

        $shops = Shop::model()->fetchAll("status='0'");
        foreach($shops as $shop) {
            $exists = ShopCaseRunRptWeek::model()->exists("year=? AND w=? AND nick=?",array($year,$w,$shop["nick"]));
            if($exists)
                continue;
            $rows = ShopCaseRunRptWeek::fetchBaseInfoByNick($shop["nick"]);
            foreach ($rows as $row) {
                if (!empty($row["runid"])) {

                    $model = ShopCaseRunRptWeek::model()->find("year=? AND w=? AND runid=?",array($year,$w,$row["runid"]));
                    if($model === null){
                        $data = array(
                            "nick" => $row["nick"],
                            "year" => $year,
                            "month" => $month,
                            "w" => $w,
                            "log_date" => date("Y-m-d"),
                            "planid" => $row["planid"],
                            "plan_budget" => $row["plan_budget"],
                            "caseid" => $row["caseid"],
                            "casetype" => $row["casetype"],
                            "luodiye" => $row["luodiye"],
                            "luodiye_alias" => $row["luodiye_alias"],
                            "luodiye_type" => $row["luodiye_type"],
                            "case_budget" => $row["case_budget"],
                            "case_actual_budget" => $row["case_actual_budget"],
                            "runid" => $row["runid"],
                            "rundept" => $row["rundept"],
                            "run_budget" => $row["run_budget"],
                            "remark" =>  $row["remark"],
                            "cost" => 0,
                            "roi" => 0,
                            "budget_ok" => 0,
                            "begin_date"=>$startDate,
                            "end_date"=>$endDate,
                            "rpt_ok" => 0
                        );
                        $model1 = new ShopCaseRunRptWeek();
                        $model1->setAttributes($data);
                        if (!$model1->save()){
                            print_r($model1->getErrors());
                        }
                    }else{
                        $data = array(
                            "nick" => $row["nick"],
                            "year" => $year,
                            "month" => $month,
                            "w" => $w,
                            "log_date" => date("Y-m-d"),
                            "planid" => $row["planid"],
                            "plan_budget" => $row["plan_budget"],
                            "caseid" => $row["caseid"],
                            "casetype" => $row["casetype"],
                            "luodiye" => $row["luodiye"],
                            "luodiye_alias" => $row["luodiye_alias"],
                            "luodiye_type" => $row["luodiye_type"],
                            "case_budget" => $row["case_budget"],
                            "case_actual_budget" => $row["case_actual_budget"],
                            "runid" => $row["runid"],
                            "rundept" => $row["rundept"],
                            "run_budget" => $row["run_budget"],
                            "remark" =>  $row["remark"],
                            "budget_ok" => 0,
                            "begin_date"=>$startDate,
                            "end_date"=>$endDate,
                            "rpt_ok" => 0
                        );
                        $model->setAttributes($data);
                        if (!$model->save()){
                            print_r($model->getErrors());
                        }
                    }

                }
            }

//            $rows = ShopCaseRunRptWeek::fetchStopListByNick($shop["nick"]);
//            foreach ($rows as $row) {
//                ShopCaseRunRptWeek::model()->deleteAll("month=? AND w=? AND runid=?", array($date, $w, $row["runid"]));
//            }

        }
    }


}