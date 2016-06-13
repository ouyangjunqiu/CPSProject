<link rel="stylesheet" href="<?php echo STATICURL.'/base/css/index.css'; ?>">
<link rel="stylesheet" href="<?php echo STATICURL.'/main/css/index.css'; ?>">
<style type="text/css">
    .b1{
        background: aliceblue;
    }
    .b2{
        background: antiquewhite;
    }
</style>

<div class="index-table-div">

    <div class="search-box">
        <div class="shop-list-cont" id="shop-search">
            <div class="search-log" style="display: none;"> </div>
            <div class="search-left com-list-tit" style="display: block;">
                <span class="shop-list-icon"></span>
                <span class="shop-list-txt">报表:</span><small>
                    <a href="<?php echo $this->createUrl("/zuanshi/dashboard/index");?>"><span class="label label-default">实时状况</span></a>
                    | <a href="<?php echo $this->createUrl("/zuanshi/rpt/index");?>"><i class="fa fa-signal"></i> 展示网络报表</a>
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

        <table class="baby-frame-table" id="table-fixed">
            <thead class="header">
            <tr>
                <th colspan="2">基本信息</th>
                <th colspan="8" class="b1">上周近7天<small>(<?php $week = \cloud\core\utils\ExtRangeDate::lastWeek() ;echo $week->startDate."~".$week->endDate;?>)</small></th>
                <th colspan="8" class="b2">近七天<small>(<?php $week = \cloud\core\utils\ExtRangeDate::week() ;echo $week->startDate."~".$week->endDate;?>)</small></th>
            </tr>
            <tr>
                <td>店铺名</td><td>钻展负责人</td>
                <td class="b1">展现</td><td class="b1">点击</td><td class="b1">消耗</td><td class="b1">三天转化金额</td><td class="b1">三天转化ROI</td><td class="b1">七天转化金额</td><td class="b1">七天转化ROI</td><td class="b1">营业额</td>
                <td class="b2">展现</td><td class="b2">点击</td><td class="b2">消耗</td><td class="b2">三天转化金额</td><td class="b2">三天转化ROI</td><td class="b2">七天转化金额</td><td class="b2">七天转化ROI</td><td class="b2">营业额</td>
            </tr>
            </thead>
            <tbody>

            <?php foreach($list as $row):?>
                <tr>
                    <td><?php echo $row["nick"];?></td><td><?php echo $row["zuanshi_pic"];?></td>
                    <!-- 上周近7天 -->
                    <td class="b1"><?php echo $row["lastWeekRpt"]["ad_pv"];?></td>
                    <td class="b1"><?php echo $row["lastWeekRpt"]["click"];?></td>
                    <td class="b1"><?php echo $row["lastWeekRpt"]["charge"];?></td>
                    <td class="b1"><?php echo $row["lastWeekRpt"]["pay"];?></td>
                    <td class="b1"><?php echo round(@($row["lastWeekRpt"]["pay"]/$row["lastWeekRpt"]["charge"]),2);?></td>
                    <td class="b1"><?php echo $row["lastWeekRpt"]["pay7"];?></td>
                    <td class="b1"><?php echo round(@($row["lastWeekRpt"]["pay7"]/$row["lastWeekRpt"]["charge"]),2);?></td>
                    <td class="b1"><?php echo $row["lastWeekTradeRpt"]["total_pay_amt"];?></td>

                    <!-- 近七天 -->
                    <td class="b2"><?php echo $row["weekRpt"]["ad_pv"];?></td>
                    <td class="b2"><?php echo $row["weekRpt"]["click"];?></td>
                    <td class="b2"><?php echo $row["weekRpt"]["charge"];?></td>
                    <td class="b2"><?php echo $row["weekRpt"]["pay"];?></td>
                    <td class="b2"><?php echo round(@($row["weekRpt"]["pay"]/$row["weekRpt"]["charge"]),2);?></td>
                    <td class="b2"><?php echo $row["weekRpt"]["pay7"];?></td>
                    <td class="b2"><?php echo round(@($row["weekRpt"]["pay7"]/$row["weekRpt"]["charge"]),2);?></td>
                    <td class="b2"><?php echo $row["weekTradeRpt"]["total_pay_amt"];?></td>
                </tr>

            <?php endforeach;?>

            </tbody>
        </table>

        <div class="c-pager"></div>
    </div>


    <script type="application/javascript">

        $(document).ready(function(){
            var self = $(this);

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

            $("#table-fixed").freezeHeader();

        });
    </script>

