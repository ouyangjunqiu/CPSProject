<?php
namespace application\modules\main\utils;
use application\modules\main\model\ShopCaseRunRptWeek;

class CaseBudgetEditor
{
    public $nick;
    public $year;
    public $w;
    public function __construct($year,$w,$nick){
        $this->year = $year;
        $this->w = $w;
        $this->nick = $nick;
    }

    public function getData(){
        $rpts = ShopCaseRunRptWeek::model()->fetchAll("year=? AND w=? AND nick=?",array($this->year,$this->w,$this->nick));
        $result = array();
        foreach($rpts as $rpt){
            $result[$rpt["caseid"]]["case"] = array(
                "casetype"=>$rpt["casetype"],
                "case_budget"=>$rpt["case_budget"],
                "luodiye"=>$rpt["luodiye"],
                "luodiye_alias"=>$rpt["luodiye_alias"],
                "luodiye_type"=>$rpt["luodiye_type"],
            );
            $result[$rpt["caseid"]]["total"] = array(
                "cost"=>  @($result[$rpt["caseid"]]["total"]["cost"]+$rpt["cost"]),
                "pay"=> @($result[$rpt["caseid"]]["total"]["pay"]+$rpt["cost"]*$rpt["roi"]),
            );
            $result[$rpt["caseid"]]["rpts"][] = $rpt;
        }

        return $result;
    }

    public function getTotalData(){
        $rpts = ShopCaseRunRptWeek::model()->fetchAll("year=? AND w=? AND nick=?",array($this->year,$this->w,$this->nick));
        $result = array("cost"=>0,"pay"=>0);
        foreach($rpts as $rpt){
            $result["cost"] = @($result["cost"]+$rpt["cost"]);
            $result["pay"] = @($result["pay"]+$rpt["cost"]*$rpt["roi"]);
        }
        $result["roi"] = @round( $result["pay"]/$result["cost"] ,2);
        return $result;
    }

    public function render(){
        return $this->renderHeader().$this->rendRow()."</div></div>";

    }

    public function renderHeader(){
        $total = $this->getTotalData();
        $year = $this->year;

     //   $beginDate = date('Y-m-d', strtotime("$year-W{$this->w}-6"));

        if($this->w<=9)
            $endDate =  date('Y-m-d', strtotime("$year-W0{$this->w}-5"));
        else
            $endDate =  date('Y-m-d', strtotime("$year-W{$this->w}-5"));
        $beginDate = date('Y-m-d', strtotime("-6 days",strtotime($endDate)));

        $view = <<<EOT
<div class="panel panel-info">
  <div class="panel-heading">
    <div class="row">
         <div class="col-md-3"><small>投放时间:</small> <strong>{$this->year}第{$this->w}周</strong><small>({$beginDate} ~ {$endDate})</small></div>
         <div class="col-md-3"><small>总花费:</small><span class="type"><i class="glyphicon glyphicon-yen"></i> {$total["cost"]}</span></div>
         <div class="col-md-6"><small>总ROI:</small> <span class="type"> {$total["roi"]}</span></div>
    </div>
  </div>
  <div class="panel-body">
EOT;

        return $view;
    }

    public function rendRow(){
        $rpts = $this->getData();
        if(empty($rpts))
            return $this->emptyText();

        $view = array();
        foreach($rpts as $rpt){
            $viewer = new RunBudgetEditor($rpt["rpts"]);
            $subView = $viewer->render();
            $cost = round($rpt["total"]["cost"]);
            $roi = @round($rpt["total"]["pay"]/$rpt["total"]["cost"],2);
            $luodiye = empty($rpt["case"]["luodiye"])?"":$rpt["case"]["luodiye"];
            $luodiyeAlias = empty($rpt["case"]["luodiye_alias"])?$luodiye:$rpt["case"]["luodiye_alias"];
            $luodiyeType = $rpt["case"]["luodiye_type"];
            $budget = round($rpt["case"]["case_budget"]);
            $view[] = <<<EOT

    <div class="row">
         <div class="col-md-2">
                  <div class="row" style="text-align: center;min-height: 55px;">
                  <p class="bl">{$rpt["case"]["casetype"]}</p>
                  <p style="font-size: 12px;"><a href="{$luodiye}" target="_blank"><small>[{$luodiyeType}]</small>{$luodiyeAlias}</a></p>
               </div>
                     <div class="row">
                        <div class="col-md-4">
                          <p><small>预算</small></p>
                           <p><o class="tit">{$budget}</o></p>
                          </div>
                          <div class="col-md-4">
                          <p><small>日均花费</small></p>
                           <p class="type">{$cost}</p>
                          </div>
                           <div class="col-md-4">
                            <p><small>3天ROI</small></p>
                            <p  class="type">{$roi}</p>
                          </div>
                   </div>
         </div>

        <div class="col-md-10">
          $subView
         </div>
    </div>

EOT;

        }
        return implode("<p class='clear'></p>",$view);

    }

    public function emptyText(){
        return '<div class="row"><div class="col-md-12">无历史记录</div></div>';
    }

}