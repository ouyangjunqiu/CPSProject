<link rel="stylesheet" href="<?php echo STATICURL.'/base/css/index.css'; ?>">
<link rel="stylesheet" href="<?php echo STATICURL.'/main/css/index.css'; ?>">

<div class="index-table-div">

    <div class="search-box">
        <div class="shop-list-cont" id="plan-fixed-header">
            <div class="row">
                <div class="col-md-4">
                    <div class="com-list-tit" style="display: block;">
                        <span class="shop-list-icon"></span>
                        <span class="shop-list-txt"><?php echo $query["nick"];?></span>
                        <small>(<?php echo date("Y.m.d",strtotime($plan["begindate"]));?>-<?php echo date("Y.m.d",strtotime($plan["enddate"]));?>)</small>
                    </div>
                </div>
                <div class="col-md-2">
                    <small>预算：</small><span class="type"><span class="glyphicon glyphicon-yen"></span> <?php echo round($plan["budget"]);?></span>
                </div>
                <div class="col-md-3">
                    <form class="case-run" id="plan-roi-editor-form">
                        <input type="hidden" name="planid" value="<?php echo $plan["planid"];?>">
                        <small>花费/三天转化：</small>
                        <strong><span class="type"> <input type="text"  value="<?php echo round($plan["cost"]);?>" name="plan-cost"/></span></strong>
                        <small> / <span class="type"><input type="text"  value="<?php echo round($plan["pay"]);?>" name="plan-pay"></small>
                    </form>
                </div>
                <div class="col-md-2">
                    <small>ROI： </small> <span class="type"><?php echo $plan["roi"];?></span>
                </div>
                <div class="col-md-1">
                    <input type="button" class="btn-orange" value="返回" id="searchBtn">
                </div>
        </div>
    </div>
    <table class="table-frame">
        <tbody id="babyInforTb">
        <?php foreach($cases as $row):?>
            <tr>
                <td class="check-infor-td">
                    <div class="baby-box">
                        <div class="baby-trusteeship baby-frame-box">

                            <div class="row">
                                <div class="col-md-4">
                                    <h3 class="baby-frame-h3">
                                        <i class="tit-frame-icon"></i>
                                        <?php echo $row["casetype"];?>
                                        <small>(<?php echo $row["luodiye"];?>)</small>
                                    </h3>
                                </div>
                                <div class="col-md-2">
                                    <small>预算：</small><span class="type"> <span class="glyphicon glyphicon-yen"></span><?php echo round($row["budget"]);?></span>
                                </div>
                                <div class="col-md-3">

                                    <small>花费/三天转化：</small>
                                    <strong><span class="type"><?php echo round($row["data"]["cost"]);?></span></strong>
                                    <small> / <span class="type"><?php echo round($row["data"]["pay"]);?></span></small>

                                </div>
                                <div class="col-md-1">
                                    <small>ROI： </small><span class="type"><span class="glyphicon glyphicon-flag"></span> <?php echo $row["data"]["roi"];?></span>
                                </div>
                                <div class="col-md-2">
                                    <p style="margin: 25px 10px;" >
                                        <a class="cz" data-toggle="modal" data-backdrop="false" data-target="#ShopCaseRunAddModal" data-caseid="<?php echo $row["caseid"];?>">
                                            <i class="glyphicon glyphicon-plus"></i>新增推广
                                        </a>
                                    </p>
                                </div>
                            </div>
                            <div class="baby-frame-cont">
                                <?php if(empty($row["run"])):?>
                                    <p>暂实施方案，赶紧创建一个吧！</p>
                                <?php else:?>

                                        <?php foreach($row["run"]["list"] as $dept=>$runs):?>
                                        <div class="panel panel-warning">
                                            <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <span><?php echo $dept;?></span>
                                                </div>
                                                <div class="col-md-2">
                                                    <small>预算：</small>
                                                    <span class="glyphicon glyphicon-yen"></span>  <?php echo round($row["run"]["total"][$dept]["budget"]);?>
                                                </div>
                                                <div class="col-md-2">
                                                    <small>花费：</small>
                                                    <span class="glyphicon glyphicon-yen"></span>  <?php echo round($row["run"]["total"][$dept]["cost"]);?>
                                                </div>
                                                <div class="col-md-2">
                                                    <small>三天转化：</small>
                                                    <span class="glyphicon glyphicon-yen"></span>  <?php echo round($row["run"]["total"][$dept]["pay"]);?>
                                                </div>
                                                <div class="col-md-2">
                                                    <small>ROI：</small>
                                                    <span class="glyphicon glyphicon-flag"></span>   <?php echo @round($row["run"]["total"][$dept]["pay"]/$row["run"]["total"][$dept]["cost"],2);?>
                                                </div>
                                            </div>
                                                </div>
                                            <div class="panel-body">
                                            <?php foreach($runs as $run):?>
                                                <form class="readonly">
                                                    <input type="hidden" name="runid" value="<?php echo $run["id"];?>"/>
                                            <div class="row" editor="run">
                                                <div class="col-md-2">
                                                </div>
                                                <div class="col-md-2">
                                                    <span><?php echo $run["runtype"];?></span>
                                                </div>
                                                <div class="col-md-2">
                                                     <span class="bud-span">
                                                        <input type="text"  readonly="readonly" value="<?php echo round($run["budget"]);?>" name="budget"/>
                                                    </span>
                                                </div>
                                                <div class="col-md-2">
                                                     <span class="bud-span">
                                                       <input type="text"  readonly="readonly" value="<?php echo round($run["cost"]);?>"  name="cost"/>
                                                    </span>
                                                </div>
                                                <div class="col-md-2">
                                                     <span class="bud-span">
                                                        <input type="text"  readonly="readonly" value="<?php echo round($run["pay"]);?>"  name="pay"/>
                                                    </span>
                                                </div>
                                                <div class="col-md-2">
                                                    <small></small>
                                                       <span class="bud-span">
                                                        <?php echo $run["roi"];?>
                                                    </span>
                                                </div>
                                            </div>
                                                </form>
                                            <?php endforeach;?>
                                                </div>
                                        </div>
                                        <?php endforeach;?>

                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>


<script type="application/javascript">

    $(".row[editor=run]").delegate("input","keypress",function(event){
        if(event.which == 13){
            var data = $(this).parent().parent().parent().parent().serialize();
            $.ajax({
                url:"<?php echo $this->createUrl('/main/caserun/data');?>",
                type:"post",
                data:data,
                dataType:"json",
                success:function(resp){
                    if(resp.isSuccess) {
                        location.reload();
                    }
                }
            });
        }
    });

    $(document).ready(function(){
        var self = $(this);
        self.find("#shopcase-runtype").select2({allowClear: true,width:400,placeholder: "请选择方案类型",data:[{id:"直通车",text:"直通车"},{id:"钻展",text:"钻展"}]});

        $("#searchBtn").click(function(){
            window.location.href='<?php echo $this->createUrl("/main/default/index");?>';
        })

        $(".row[editor=run]").dblclick(function(){
            $(".row[editor=run][status=editing]").parent().removeClass("case-run");
            $(".row[editor=run][status=editing]").parent().addClass("readonly");
            $(".row[editor=run][status=editing]").find("input").attr("readonly","readonly");

            $(this).attr("status","editing");
            $(this).find("input").removeAttr("readonly");
            $(this).parent().removeClass("readonly");
            $(this).parent().addClass("case-run");
        });

        $("#plan-roi-editor-form").keydown(function(event){
            if(event.which == 13){
                var data = $(this).serialize();
                $.ajax({
                    url:"<?php echo $this->createUrl('/main/plan/data');?>",
                    type:"post",
                    data:data,
                    dataType:"json",
                    success:function(resp){
                        if(resp.isSuccess) {
                            location.reload();
                        }
                    }
                });
            }
        });

        var t = $("#plan-fixed-header").offset().top+$("#plan-fixed-header").height();
        $(window).scroll(function(event){

            var top = $(window).scrollTop();
            if(top>t){
                $("#plan-fixed-header").addClass("header-fixed");
            }else{
                $("#plan-fixed-header").removeClass("header-fixed");
            }
        });

    });
</script>

