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
                        <small>(CASE历史记录)</small>
                    </div>
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-3">

                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-1">
                    <input type="button" class="btn-orange" value="返回" id="searchBtn">
                </div>
            </div>
        </div>
    </div>
    <div style="padding: 15px">
        <?php foreach($logs as $date=>$log): ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-3"><small>记录日期:</small> <strong><?php echo $date;?></strong></div>
                </div>
            </div>
            <div class="panel-body">

                <?php if(empty($log)):?>
                    <div class="row" style="padding-bottom: 5px">
                        <div class="col-md-12">
                           暂无历史记录
                        </div>
                    </div>
                <?php else:?>
                    <div class="row" style="padding-bottom: 5px">
                        <div class="col-md-3">
                            <small>CASE类型</small>
                        </div>
                        <div class="col-md-3">
                            <small>落地页</small>
                        </div>
                        <div class="col-md-3">
                            <small>预算(元/天)</small>
                        </div>
                        <div class="col-md-3">
                            <small>实际预算(元/天)</small>
                        </div>
                    </div>
                    <?php foreach($log as $case):?>
                        <div class="row" style="padding-bottom: 5px">
                            <div class="col-md-3">
                                 <span class="type">
                                     <?php echo $case["casetype"];?>
                                 </span>
                            </div>
                            <div class="col-md-3">
                                <a href="<?php echo $case["luodiye"];?>" target="_blank">
                                    <small>[<?php echo $case["luodiye_type"];?>]</small>

                                    <?php echo !empty($case["luodiye_alias"])?$case["luodiye_alias"]:(strlen($case["luodiye"])>100?substr($case["luodiye"],0,100)."...":$case["luodiye"]);?>
                                </a>

                            </div>
                            <div class="col-md-3">
                                <span class="bud-span"> <?php echo round($case["budget"]);?></span>
                            </div>
                            <div class="col-md-3">
                                <span class="bud-span"  > <?php echo round($case["actual_budget"]);?></span>
                            </div>

                        </div>
                    <?php endforeach;?>
                <?php endif;?>

            </div>
        </div>
        <?php endforeach;?>
    </div>


</div>


<script type="application/javascript">

    $(document).ready(function(){

        $(".sidebar-menu>li").eq(1).addClass("active");

        $("#searchBtn").click(function(){
            window.location.href='<?php echo $this->createUrl("/main/default/index");?>';
        });


    });
</script>