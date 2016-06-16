<link rel="stylesheet" href="<?php echo STATICURL.'/base/css/index.css'; ?>">
<link rel="stylesheet" href="<?php echo STATICURL.'/main/css/index.css'; ?>">
<style type="text/css">
    .b1{
        background: antiquewhite;
    }
    .b2{
        background: aliceblue;
    }
</style>

<div class="index-table-div">

    <div class="search-box">
        <div class="shop-list-cont" id="shop-search">
            <div class="search-log" style="display: none;"> </div>
            <div class="search-left com-list-tit" style="display: block;">
                <span class="shop-list-icon"></span>
                <span class="shop-list-txt">智·钻</span><small>
                    <a href="<?php echo $this->createUrl("/zuanshi/dashboard/index");?>"><span class="label label-default">全店推广</span></a>
<!--                    <a href="--><?php //echo $this->createUrl("/zuanshi/rpt/index2");?><!--"><span class="label label-default">明星店铺报表</span></a>-->
                    <a href="<?php echo $this->createUrl("/zuanshi/summary/index");?>"><span class="label label-info">店铺统计报表</span></a>
                    <a href="<?php echo $this->createUrl("/zuanshi/summary/pic");?>"><span class="label label-default">人员统计报表</span></a>

                </small>

            </div>
            <div class="search-right">
                <form class="form-inline">
                    <input placeholder="店铺名称" type="text" class="form-control" data-name="店铺名称" name="nick" value="<?php echo $query['nick'];?>">
                    <input placeholder="钻展、大数据、直通车负责人" type="text" class="form-control" data-name="钻展、大数据、直通车负责人" name="pic" style="width: 180px;" value="<?php echo $query['pic'];?>">
                    <?php echo CHtml::dropDownList("shoptype",$query['shoptype'],array(""=>"请选择合作业务","直钻业务"=>"直钻业务","直通车业务"=>"直通车业务","钻展业务"=>"钻展业务"),array("class"=>"form-control"));?>
                    <input type="button" class="btn btn-warning" value="搜索" id="searchBtn">
                </form>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 10px;margin-bottom: 10px;">
        <div class="col-md-11">
            <form class="form-inline">
                <div class="form-group">
                    <small>统计:</small>
                </div>
                <div class="form-group">
                    <div class="input-group"  id="dateSetting">
                        <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                        <input type="text" class="form-control" value="<?php echo $query['startdate'];?> ~ <?php echo $query['enddate'];?>">
                        <span class="input-group-addon"><b class="caret"></b></span>
                    </div>
                </div>
            </form>

        </div>

        <div class="col-md-1">
            <button class="btn btn-warning" id="down-excel">下载</button>
        </div>
    </div>

    <table class="baby-frame-table" id="table-fixed" style="table-layout: fixed;">
        <thead class="header">
        <tr>
            <th>店铺名</th>
            <th>运营对接人</th>
            <th>直通车负责人</th>
            <th>钻展负责人</th>
            <th>大数据负责人</th>
            <th class="b2">展现</th>
            <th class="b2">点击</th>
            <th class="b2">消耗</th>
            <th class="b2">三天转化金额</th>
            <th class="b2">三天转化ROI</th>
            <th class="b2">七天转化金额</th>
            <th class="b2">七天转化ROI</th>
            <th class="b2">营业额</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach($list as $row):?>
            <tr>
                <td><?php echo $row["nick"];?></td>
                <td><?php echo $row["pic"];?></td>
                <td><?php echo $row["ztc_pic"];?></td>
                <td><?php echo $row["zuanshi_pic"];?></td>
                <td><?php echo $row["bigdata_pic"];?></td>
                <!-- 近七天 -->
                <td class="b2"><?php echo $row["rpt"]["ad_pv"];?></td>
                <td class="b2"><?php echo $row["rpt"]["click"];?></td>
                <td class="b2"><?php echo \cloud\core\utils\String::nFormat($row["rpt"]["charge"]);?></td>
                <td class="b2"><?php echo \cloud\core\utils\String::nFormat($row["rpt"]["pay"]);?></td>
                <td class="b2"><?php echo round(@($row["rpt"]["pay"]/$row["rpt"]["charge"]),2);?></td>
                <td class="b2"><?php echo $row["rpt"]["pay7"];?></td>
                <td class="b2"><?php echo round(@($row["rpt"]["pay7"]/$row["rpt"]["charge"]),2);?></td>
                <td class="b2"><?php echo \cloud\core\utils\String::nFormat($row["tradeRpt"]["total_pay_amt"]);?></td>
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
            location.href = app.url("<?php echo $this->createUrl('/zuanshi/summary/index');?>",data)
        });



        $("#dateSetting").daterangepicker({
            "startDate": "<?php echo $query['startdate'];?>",
            "endDate": "<?php echo $query['enddate'];?>",
            "format":"YYYY-MM-DD"
        },function (start,end){

            location.href = app.url("<?php echo $this->createUrl('/zuanshi/summary/index');?>",{startdate:start.format('YYYY-MM-DD'),enddate:end.format('YYYY-MM-DD')})

        });


        $(".c-pager").jPager({currentPage: <?php echo $pager["page"]-1;?>, total: <?php echo $pager["count"];?>, pageSize: <?php echo $pager["page_size"];?>,events: function(dp){

            location.href = app.url("<?php echo $this->createUrl('/zuanshi/summary/index');?>",{page:dp.index+1})
        }});

        $("#table-fixed").freezeHeader();

        $("#down-excel").click(function(){
            location.href = "<?php echo $this->createUrl('/zuanshi/down/summary');?>"
        });

    });
</script>

