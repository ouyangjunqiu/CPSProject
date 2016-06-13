<?php
namespace application\modules\main\utils;

class RunBudgetView
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

        $cost = round($rpt["cost"]);
        $budget = round($rpt["run_budget"]);
        $view = <<<EOT
<div class="row" style="padding-bottom: 5px"  data-rpt-id="{$rpt["id"]}">
    <form>
        <div class="col-md-3">
                <strong>{$rpt["rundept"]}</strong>
        </div>
           <div class="col-md-3">
                  <small><i class="glyphicon glyphicon-yen"></i>{$budget}</small>
           </div>
        <div class="col-md-3">
               <small><i class="glyphicon glyphicon-yen"></i>{$cost}</small>
        </div>
         <div class="col-md-3">
               <small>{$rpt["roi"]}</small>
        </div>

    </form>
</div>

EOT;
        return $view;
    }

    public function renderHeader(){
        $view = <<<EOT
        <div class="row" style="padding-bottom: 5px">
                                <div class="col-md-3">
                                    <small>推广渠道</small>
                                </div>
                                 <div class="col-md-3">
                                    <small>预算(元/天)</small>
                                </div>
                                <div class="col-md-3">
                                    <small>花费(元/天)</small>
                                </div>
                                 <div class="col-md-3">
                                    <small>3天ROI</small>
                                </div>
                            </div>
EOT;
        return $view;
    }

}