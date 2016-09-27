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
                <span class="shop-list-txt">直通车</span><small>
                    <a href="<?php echo $this->createUrl("/ztc/default/index");?>"><span class="label label-default">全店报表</span></a>
<!--                    <a href="--><?php //echo $this->createUrl("/zuanshi/rpt/index2");?><!--"><span class="label label-default">明星店铺报表</span></a>-->
                    <a href="<?php echo $this->createUrl("/ztc/summary/index");?>"><span class="label label-info">店铺统计报表</span></a>
                    <a href="<?php echo $this->createUrl("/ztc/summary/pic");?>"><span class="label label-default">人员统计报表</span></a>

                </small>

            </div>
            <div class="search-right">
                <?php $this->widget("application\\modules\\main\\widgets\\ShopSearchWidget",array("url"=>$this->createUrl("/zz/summary/index",array("page"=>1)),"query"=>$query));?>
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
        <thead>
        <tr class="small">
            <th>店铺名</th>
            <th>主营行业</th>
            <th>运营顾问</th>
            <th>直通车顾问</th>
            <th>智钻顾问</th>
            <th>数据顾问</th>
            <th class="b2">展现</th>
            <th class="b2">点击</th>
            <th class="b2">消耗</th>
            <th class="b2">转化金额</th>
            <th class="b2">转化ROI</th>
            <th class="b2">全店营业额</th>
            <th class="b2">消耗占比(%)</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach($list as $row):?>
            <tr class="small">
                <td><?php echo $row["nick"];?></td>
                <td><?php echo $row["shopcatname"];?></td>
                <td><?php echo $row["pic"];?></td>
                <td><?php echo $row["ztc_pic"];?></td>
                <td><?php echo $row["zuanshi_pic"];?></td>
                <td><?php echo $row["bigdata_pic"];?></td>
                <!-- 近七天 -->
                <td class="b2"><?php echo empty($row["rpt"]["total"])?"-":@$row["rpt"]["total"]["impressions"];?></td>
                <td class="b2"><?php echo empty($row["rpt"]["total"])?"-":@$row["rpt"]["total"]["click"];?></td>
                <td class="b2"><?php echo empty($row["rpt"]["total"])?"-":@\cloud\core\utils\String::nFormat($row["rpt"]["total"]["cost"]);?></td>
                <td class="b2"><?php echo empty($row["rpt"]["total"])?"-":@\cloud\core\utils\String::nFormat($row["rpt"]["total"]["pay"]);?></td>
                <td class="b2"><?php echo empty($row["rpt"]["total"])?"-":@$row["rpt"]["total"]["roi"];?></td>
                <td class="b2"><?php echo \cloud\core\utils\String::nFormat($row["tradeRpt"]["total_pay_amt"]);?></td>
                <td class="b2"><?php echo round(@($row["rpt"]["total"]["cost"]/$row["tradeRpt"]["total_pay_amt"]*100),2);?></td>
            </tr>

        <?php endforeach;?>

        </tbody>
    </table>

    <div class="c-pager"></div>
</div>


<script type="application/javascript">

    $(document).ready(function(){
        var self = $(this);

        $(".top-ul>li").eq(2).addClass("top-li-hover");

        $("#dateSetting").daterangepicker({
            "startDate": "<?php echo $query['startdate'];?>",
            "endDate": "<?php echo $query['enddate'];?>",
            "format":"YYYY-MM-DD"
        },function (start,end){

            location.href = app.url("<?php echo $this->createUrl('/ztc/summary/index');?>",{startdate:start.format('YYYY-MM-DD'),enddate:end.format('YYYY-MM-DD')})

        });


        $(".c-pager").jPager({currentPage: <?php echo $pager["page"]-1;?>, total: <?php echo $pager["count"];?>, pageSize: <?php echo $pager["page_size"];?>,events: function(dp){

            location.href = app.url("<?php echo $this->createUrl('/ztc/summary/index');?>",{page:dp.index+1})
        }});

        $("#table-fixed").freezeHeader();

        $("#down-excel").click(function(){
            location.href = "<?php echo $this->createUrl('/ztc/down/summary');?>"
        });

    });
</script>

