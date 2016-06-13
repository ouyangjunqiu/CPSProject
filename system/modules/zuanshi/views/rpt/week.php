<link rel="stylesheet" href="<?php echo STATICURL.'/base/css/index.css'; ?>">
<link rel="stylesheet" href="<?php echo STATICURL.'/main/css/index.css'; ?>">
<script src='<?php echo STATICURL."/main/js/shop.js"; ?>'></script>

<div class="index-table-div">

    <div class="search-box">
        <div class="shop-list-cont" id="shop-search">
            <div class="search-log" style="display: none;"> </div>
            <div class="search-left com-list-tit" style="display: block;">
                <span class="shop-list-icon"></span>
                <span class="shop-list-txt">展示网络报表</span><small>
                    | <a href="<?php echo $this->createUrl("/zuanshi/rpt/index2");?>"><i class="fa fa-signal"></i> 明星店铺报表</a>
                    | <a href="<?php echo $this->createUrl("/main/default/index");?>"><i class="fa fa-home"></i>店铺列表</a>
                    | <a href="<?php echo $this->createUrl("/main/case/index");?>"><i class="fa fa-home"></i>CASE列表</a>
                </small>

            </div>
            <div class="search-right">
                <form>
                    <input placeholder="店铺名称" type="text" class="input-text search-shop-name" data-name="店铺名称" name="nick" value="<?php echo $query['nick'];?>">
                    <input placeholder="钻展、大数据、直通车负责人" type="text" class="input-text search-manager" data-name="钻展、大数据、直通车负责人" name="pic" style="width: 180px;" value="<?php echo $query['pic'];?>">
                    <?php echo CHtml::dropDownList("shoptype",$query['shoptype'],array(""=>"请选择合作业务","直钻业务"=>"直钻业务","直通车业务"=>"直通车业务","钻展业务"=>"钻展业务"));?>
                    <input type="button" class="btn-orange" value="搜索" id="searchBtn">
                </form>
            </div>
        </div>
    </div>
    <table class="table-frame">
        <tbody id="babyInforTb">
        <?php foreach($list as $row):?>
            <tr>
                <td class="babyInforTb-td-left">
                    <?php $this->widget("application\\modules\\main\\widgets\\ShopManagerWidget",array("shop"=>$row));?>
                </td>
                <td class="check-infor-td">
                    <div class="baby-box">
                        <div class="baby-trusteeship baby-frame-box" data-nick="<?php echo $row["nick"];?>">

                            <div class="row">
                                <div class="col-md-4">
                                    <h3 class="baby-frame-h3">
                                        <i class="tit-frame-icon"></i>
                                        近7天<small>(<?php $week = \cloud\core\utils\ExtRangeDate::week() ;echo $week->startDate."~".$week->endDate;?>)</small>

                                    </h3>
                                </div>
                                <div class="col-md-4">

                                </div>
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-2">

                                </div>
                            </div>
                            <div class="baby-frame-cont">

                                        <table data-role="list" class="baby-frame-table">
                                            <thead>
                                            <tr><td>展现</td><td>点击</td><td>消耗</td><td>三天转化金额</td><td>三天转化ROI</td><td>七天转化金额</td><td>七天转化ROI</td></tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><?php echo $row["weekRpt"]["ad_pv"];?></td>
                                                    <td><?php echo $row["weekRpt"]["click"];?></td>
                                                    <td><?php echo $row["weekRpt"]["charge"];?></td>
                                                    <td><?php echo $row["weekRpt"]["pay"];?></td>
                                                    <td><?php echo round(@($row["weekRpt"]["pay"]/$row["weekRpt"]["charge"]),2);?></td>
                                                    <td><?php echo $row["weekRpt"]["pay7"];?></td>
                                                    <td><?php echo round(@($row["weekRpt"]["pay7"]/$row["weekRpt"]["charge"]),2);?></td>
                                                </tr>
                                            </tbody>
                                        </table>

                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <h3 class="baby-frame-h3">
                                        <i class="tit-frame-icon"></i>
                                        上周同期近7天<small>(<?php $week = \cloud\core\utils\ExtRangeDate::lastWeek() ;echo $week->startDate."~".$week->endDate;?>)</small>

                                    </h3>
                                </div>
                                <div class="col-md-4">

                                </div>
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-2">

                                </div>
                            </div>
                            <div class="baby-frame-cont">
                                <table data-role="list" class="baby-frame-table">
                                    <thead>
                                    <tr><td>展现</td><td>点击</td><td>消耗</td><td>三天转化金额</td><td>三天转化ROI</td><td>七天转化金额</td><td>七天转化ROI</td></tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><?php echo $row["lastWeekRpt"]["ad_pv"];?></td>
                                        <td><?php echo $row["lastWeekRpt"]["click"];?></td>
                                        <td><?php echo $row["lastWeekRpt"]["charge"];?></td>
                                        <td><?php echo $row["lastWeekRpt"]["pay"];?></td>
                                        <td><?php echo round(@($row["lastWeekRpt"]["pay"]/$row["lastWeekRpt"]["charge"]),2);?></td>
                                        <td><?php echo $row["lastWeekRpt"]["pay7"];?></td>
                                        <td><?php echo round(@($row["lastWeekRpt"]["pay7"]/$row["lastWeekRpt"]["charge"]),2);?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
    <div class="c-pager">
    </div>
</div>


<script type="application/javascript">

    $(document).ready(function(){

        $(".top-ul>li").eq(1).addClass("top-li-hover");

        $("#shop-search").keydown(function(event){
            if(event.which == 13){
                $("#searchBtn").trigger("click");
            }
        });

        $("#searchBtn").click(function(){
            var form = $(this).parent();
            var data = {};
            data.nick = form.find("input[name=nick]").val();
            data.pic = form.find("input[name=pic]").val();
            data.shoptype = form.find("select[name=shoptype]").val();
            data.page = 1;
            location.href = app.url("<?php echo $this->createUrl('/zuanshi/rpt/week');?>",data)
        });


        $(".c-pager").jPager({currentPage: <?php echo $pager["page"]-1;?>, total: <?php echo $pager["count"];?>, pageSize: <?php echo $pager["page_size"];?>,events: function(dp){

            location.href = app.url("<?php echo $this->createUrl('/zuanshi/rpt/week');?>",{page:dp.index+1})
        }});

    });

</script>

