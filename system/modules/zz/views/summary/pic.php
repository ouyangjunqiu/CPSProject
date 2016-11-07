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
                    <a href="<?php echo $this->createUrl("/zz/advertiserrpt/index");?>"><span class="label label-default">全店推广</span></a>
<!--                    <a href="--><?php //echo $this->createUrl("/zuanshi/rpt/index2");?><!--"><span class="label label-default">明星店铺报表</span></a>-->
                    <a href="<?php echo $this->createUrl("/zz/summary/index");?>"><span class="label label-default">店铺统计报表</span></a>
                    <a href="<?php echo $this->createUrl("/zz/summary/pic");?>"><span class="label label-info">人员统计报表</span></a>
                </small>

            </div>
            <div class="search-right">

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
                        <span class="input-group-addon"> <i class="glyphicon glyphicon-calendar"></i> </span>
                        <input type="text" class="form-control" value="<?php echo $query['startdate'];?> ~ <?php echo $query['enddate'];?>">
                        <span class="input-group-addon"><b class="caret"></b></span>
                    </div>
                </div>
<!--                <div class="form-group">-->
<!--                    <small><a href="--><?php //echo $this->createUrl("/zuanshi/summary/pic");?><!--">*2016年7月前的数据点击这里</a></small>-->
<!--                </div>-->

            </form>

        </div>
        <div class="col-md-1">
            <!--            <button class="btn btn-warning" id="down-excel">下载</button>-->
        </div>
    </div>

    <table class="baby-frame-table" id="table-fixed" style="table-layout: fixed;">
        <thead>
        <tr class="small">
            <th>智钻顾问</th>
            <th>负责店铺数</th>
            <th class="b2">点击率(%)</th>
            <th class="b2">消耗</th>
            <th class="b2">三天转化金额</th>
            <th class="b2">三天投资回报率</th>
            <th class="b2">七天转化金额</th>
            <th class="b2">七天投资回报率</th>
            <th class="b2">全店营业额</th>
            <th class="b2">消耗占比(%)</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach($list as $k=>$row):?>
            <tr class="small">
                <td><?php echo $k;?></td>
                <td><?php echo $row["shopcount"];?></td>

                <!-- 近七天 -->
                <td class="b2"><?php echo round(@($row["click"]/$row["ad_pv"]*100),2);?></td>
                <td class="b2"><?php echo \cloud\core\utils\String::nFormat($row["charge"]);?></td>
                <td class="b2"><?php echo \cloud\core\utils\String::nFormat($row["pay"]);?></td>
                <td class="b2"><?php echo round(@($row["pay"]/$row["charge"]),2);?></td>
                <td class="b2"><?php echo $row["pay7"];?></td>
                <td class="b2"><?php echo round(@($row["pay7"]/$row["charge"]),2);?></td>
                <td class="b2"><?php echo \cloud\core\utils\String::nFormat($row["tradeRpt"]);?></td>
                <td class="b2"><?php echo round(@($row["charge"]/$row["tradeRpt"]*100),2);?></td>
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

        $("#dateSetting").daterangepicker({
            "startDate": "<?php echo date("m/d/Y",strtotime($query['startdate']));?>",
            "endDate": "<?php echo date("m/d/Y",strtotime($query['enddate']));?>",
            "minDate":"08/01/2016",
            "maxDate":"<?php echo date("m/d/Y",strtotime("-1 days"));?>"
        },function (start,end){

            location.href = app.url("<?php echo $this->createUrl('/zz/summary/pic');?>",{startdate:start.format('YYYY-MM-DD'),enddate:end.format('YYYY-MM-DD')})

        });


        $("#table-fixed").freezeHeader();

    });
</script>

