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
        <div class="shop-list-cont">
            <div class="row">
                <div class="col-md-11">
                    <div class="com-list-tit" style="display: block;">
                        <span class="shop-list-icon"></span>
                        <span class="shop-list-txt"><?php echo $query["nick"];?></span>
                        <small>
                            <a href="<?php echo $this->createUrl("/zuanshi/advertiser/more",array("nick"=>$query["nick"]));?>"><span class="label label-info">实时状况</span></a>
                            <a href="<?php echo $this->createUrl("/zuanshi/rpt/more",array("nick"=>$query["nick"]));?>"><span class="label label-default">全店推广报表</span></a>
<!--                            <a href="--><?php //echo $this->createUrl("/zuanshi/adboard/index",array("nick"=>$query["nick"]));?><!--"><span class="label label-default">创意优选</span></a>-->
<!--                            <a href="--><?php //echo $this->createUrl("/zuanshi/dest/index",array("nick"=>$query["nick"]));?><!--"><span class="label label-default">定向优选</span></a>-->
<!--                            <a href="--><?php //echo $this->createUrl("/zuanshi/adzonerpt/index",array("nick"=>$query["nick"]));?><!--"><span class="label label-default">资源位优选</span></a>-->

                        </small>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="search-right">
                        <input type="button" class="btn btn-default" value="返回" id="backBtn">
                    </div>
                </div>
            </div>
        </div>
        <?php if(empty($data)):?>
            <div class="row" style="margin-top: 15px;margin-bottom: 15px">
                <p>安装最新版的插件，在10-11点、13-16点左右登录钻石展位即可同步展示</p>
            </div>

        <?php else:?>
        <div class="row" style="margin-top: 15px;margin-bottom: 15px">

            <div id="advertiser_h_rpt_sel_btns">
                <span class="label label-info" data-chart="charge">消耗</span>
                <span class="label label-default" data-chart="click">点击</span>
                <span class="label label-default" data-chart="ctr">点击率</span>
                <span class="label label-default" data-chart="ecpc">点击单价</span>
            </div>
            <div id="advertiser_h_rpt_source" style="display: none">
                <textarea class="advertiser_h_rpt_yesterday">
                    <?php echo CJavaScript::jsonEncode($data["yesterday_rpt_list"]);?>
                </textarea>
                 <textarea class="advertiser_h_rpt_today">
                    <?php echo CJavaScript::jsonEncode($data["today_rpt_list"]);?>
                </textarea>
            </div>
            <div id="advertiser_h_rpt_chart">
            </div>
        </div>


        <table class="baby-frame-table" id="table_fixed" style="table-layout: fixed;">
            <thead class="header">
            <tr>
                <th>时段</th>
                <th>展现</th>
                <th>点击</th>
                <th>点击率(%)</th>
                <th class="b1">消耗(元)</th>
                <th>千次展现价格(元)</th>
                <th>点击单价(元)</th>

            </tr>
            </thead>
            <tbody>

                <?php for($i=0;$i<=23;$i++):?>

                <tr>
                    <?php $todayRpt = empty($data["today_rpt_list"][$i])?array():$data["today_rpt_list"][$i];?>
                    <?php $rpt = empty($data["yesterday_rpt_list"][$i])?array():$data["yesterday_rpt_list"][$i];?>
                    <td><strong><?php echo $i.":00~".($i+1).":00";?></strong></td>
                    <td>
                        <p><?php echo !isset($todayRpt["adPv"])?"-":$todayRpt["adPv"];?></p>
                        <p><small style="color: #999!important"><?php echo isset($rpt["adPv"])?$rpt["adPv"]:"-";?></small></p>
                    </td>
                    <td>
                        <p><?php echo !isset($todayRpt["click"])?"-":$todayRpt["click"];?></p>
                        <p><small style="color: #999!important"><?php echo !isset($rpt["click"])?"-":$rpt["click"];?></small></p>
                    </td>
                    <td>
                        <p><?php echo !isset($todayRpt["ctr"])?"-":$todayRpt["ctr"]*100;?></p>
                        <p><small style="color: #999!important"><?php echo !isset($rpt["ctr"])?"-":$rpt["ctr"]*100;?></small></p>
                    </td>
                    <td class="b1">
                        <p><?php echo !isset($todayRpt["charge"])?"-":$todayRpt["charge"];?></p>
                        <p><small style="color: #999!important"><?php echo !isset($rpt["charge"])?"-":$rpt["charge"];?></small></p>
                    </td>
                    <td>
                        <p><?php echo !isset($todayRpt["ecpm"])?"-":$todayRpt["ecpm"];?></p>
                        <p><small style="color: #999!important"><?php echo !isset($rpt["ecpm"])?"-":$rpt["ecpm"];?></small></p>
                    </td>
                    <td>
                        <p><?php echo !isset($todayRpt["ecpc"])?"-":$todayRpt["ecpc"];?></p>
                        <p><small style="color: #999!important"><?php echo !isset($rpt["ecpc"])?"-":$rpt["ecpc"];?></small></p>
                    </td>
               </tr>

            <?php endfor;?>
            <tr>
                <td><strong>总计</strong></td>
                <td>
                    <p><?php echo @$data["today"]["totalAdPv"];?></p>
                    <p><small style="color: #999!important"><?php echo @$data["yesterday"]["totalAdPv"];?></small></p>
                </td>
                <td>
                    <p><?php echo @$data["today"]["totalClick"];?></p>
                    <p><small style="color: #999!important"><?php echo @$data["yesterday"]["totalClick"];?></small></p>
                </td>
                <td>
                    <p><?php echo @$data["today"]["ctr"]*100;?></p>
                    <p><small style="color: #999!important"><?php echo @$data["yesterday"]["ctr"]*100;?></small></p>
                </td>
                <td class="b1">
                    <p><?php echo @$data["today"]["totalCharge"];?></p>
                    <p><small style="color: #999!important"><?php echo @$data["yesterday"]["totalCharge"];?></small></p>
                </td>
                <td>
                    <p><?php echo @$data["today"]["cpm"];?></p>
                    <p><small style="color: #999!important"><?php echo @$data["yesterday"]["cpm"];?></small></p>
                </td>
                <td>
                    <p><?php echo @$data["today"]["cpc"];?></p>
                    <p><small style="color: #999!important"><?php echo @$data["yesterday"]["cpc"];?></small></p>
                </td>
            </tr>

            </tbody>
        </table>
        <?php endif;?>
    </div>


</div>



<script type="application/javascript">

    $(document).ready(function(){

        $(".top-ul>li").eq(1).addClass("top-li-hover");

        var rptYesterday = JSON.parse($("#advertiser_h_rpt_source .advertiser_h_rpt_yesterday").val());
        var rptToday = JSON.parse($("#advertiser_h_rpt_source .advertiser_h_rpt_today").val());
        var config = app.charts.hConfig(rptToday,rptYesterday,"charge");

        $("#advertiser_h_rpt_chart").highcharts(config);

        $("#advertiser_h_rpt_sel_btns span").click(function(){
            $(this).siblings(".label-info").removeClass("label-info").addClass("label-default");
            $(this).removeClass("label-default").addClass("label-info");

            var f = $(this).data("chart");

            var config = app.charts.hConfig(rptToday,rptYesterday,f);
            $("#advertiser_h_rpt_chart").highcharts(config);
        });


        $("#backBtn").click(function(){
            window.location.href='<?php echo $this->createUrl("/zuanshi/dashboard/index");?>';
        });

        $("#table_fixed").freezeHeader();

    });
</script>