<?php
namespace application\modules\main\utils;

use application\modules\main\model\ShopCaseRun;

class RunBudgetEditor
{

    public $rpts;

    public function __construct($rpts){
        $this->rpts = $rpts;
    }

    public function render(){

        $header = $this->renderHeader();
        $rows = "";
        foreach($this->rpts as $rpt) {

            $rows = $rows.$this->renderRow($rpt);

        }
        return $header.$rows;
    }

    public function renderRow($rpt){

        $run = ShopCaseRun::model()->fetchByPk($rpt["runid"]);
        if($run == null){
            $nowBudget = 0;
        }else {
            $nowBudget = $run["budget"];
        }

        $cost = round($rpt["cost"],2);
        $totalcost = round($cost * 7);
        $budget = round($rpt["run_budget"]);
        $view = <<<EOT
<div class="row" editor="run" style="padding-bottom: 5px"  data-rpt-id="{$rpt["id"]}">
    <form>
        <div class="col-md-2">
                <strong>{$rpt["rundept"]}</strong>
        </div>
          <div class="col-md-2">
               <small><i class="glyphicon glyphicon-yen"></i>{$budget}</small>
        </div>
        <div class="col-md-2">
               <small><input type="text" value="{$totalcost}" class="name_writer" name="cost"></small>
               <span style='font-size:8px;color:#fa6e50'>({$cost})</span>
        </div>
         <div class="col-md-2">
               <small><input type="text" value="{$rpt["roi"]}" class="name_writer" name="roi"></small>
        </div>
        <div class="col-md-2">
            <input data-run-id="{$rpt["runid"]}" type="text" value="{$nowBudget}" class="name_writer" name="budget">
        </div>
        <div class="col-md-2">
            <textarea class="s" data-run-id="{$rpt["runid"]}" name="remark">{$run["remark"]}</textarea>
        </div>
    </form>
</div>

EOT;
        return $view;
    }

    public function renderHeader(){
        $view = <<<EOT
        <div class="row" style="padding-bottom: 5px">
                                <div class="col-md-2">
                                    <small>推广渠道</small>
                                </div>
                                 <div class="col-md-2">
                                    <small>预算</small>
                                </div>
                                <div class="col-md-2">
                                    <small>总花费 </small><span style='font-size:8px;color:#fa6e50'>(日均花费)</span>
                                </div>
                                 <div class="col-md-2">
                                    <small>3天ROI</small>
                                </div>
                                <div class="col-md-2">
                                    <small>本周预算</small>
                                </div>
                                 <div class="col-md-2">
                                    <small>调整原因</small>
                                </div>
                            </div>
EOT;
        return $view;
    }

}