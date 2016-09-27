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
<!--                            <a href="--><?php //echo $this->createUrl("/zuanshi/advertiser/more",array("nick"=>$query["nick"]));?><!--"><span class="label label-default">实时状况</span></a>-->
                            <a href="<?php echo $this->createUrl("/zz/advertiserrpt/more",array("nick"=>$query["nick"]));?>"><span class="label label-info">全店推广报表</span></a>
                            <a href="<?php echo $this->createUrl("/zz/year/month",array("nick"=>$query["nick"]));?>"><span class="label label-default">年度走势</span></a>
                            <a href="<?php echo $this->createUrl("/zz/weekrpt/index",array("nick"=>$query["nick"]));?>"><span class="label label-default">周报</span></a>

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

        <div class="row" style="margin-top: 10px;margin-bottom: 10px;">
            <div class="col-md-11">
                <form class="form-inline">
                    <div class="form-group">
                        <small>统计:</small>
                        <div class="input-group"  id="dateSetting">
                            <span class="input-group-addon"> <i class="glyphicon glyphicon-calendar"></i> </span>
                            <input type="text" class="form-control"  value="<?php echo $query['beginDate'];?> ~ <?php echo $query['endDate'];?>">
                            <span class="input-group-addon"><b class="caret"></b></span>
                        </div>
                        <small><a href="<?php echo $this->createUrl("/zuanshi/rpt/more",array("nick"=>$query["nick"]));?>">*2016年7月前的数据点击这里</a></small>
                    </div>

                </form>
            </div>

            <div class="col-md-1">
                <a class="btn btn-warning" href="<?php echo $this->createUrl("/zz/down/advertiserrpt",array("nick"=>$query["nick"],"begin_date"=>$query['beginDate'],"end_date"=>$query['endDate']));?>" id="down-excel">下载</a>
            </div>
        </div>

        <table class="baby-frame-table" id="table_fixed" style="table-layout: fixed;">
            <thead class="header">
            <tr class="small">
                <th>日期</th>
                <th>展现</th>
                <th>点击</th>
                <th>点击率(%)</th>
                <th class="b1">消耗(元)</th>
                <th>点击单价(元)</th>

                <th class="b2">3天回报率</th>
                <th class="b2">7天回报率</th>
                <th class="b2">15天回报率</th>

                <th>3天转化金额(元)</th>
                <th>7天转化金额(元)</th>
                <th>15天转化金额(元)</th>

                <th>3天订单数</th>
                <th>7天订单数</th>
                <th>15天订单数</th>

                <th>3天加购物车数</th>
                <th>7天加购物车数</th>
                <th>15天加购物车数</th>

                <th>店铺收藏数</th>
                <th>宝贝收藏数</th>
                <th>访客数</th>

                <th>店铺收藏率(%)</th>
                <th>宝贝收藏率(%)</th>
                <th>客单价(元)</th>
                <th>支付转化率(%)</th>
            </tr>
            </thead>
            <tbody>
            <?php

            $click3list = $list["click3"]["list"];
            $click7list = $list["click7"]["list"];
            $click15list = $list["click15"]["list"];

            $click3total = $list["click3"]["total"];
            $click7total = $list["click7"]["total"];
            $click15total = $list["click15"]["total"];


            ?>
            <?php foreach($list["click3"]["list"] as $i=>$rpt):?>
                <tr class="small">
                    <td><strong><?php echo @$rpt["logDate"];?></strong></td>
                    <td><?php echo @$rpt["adPv"];?></td>
                    <td><?php echo @$rpt["click"];?></td>
                    <td><?php echo @round($rpt["ctr"]*100,2);?></td>
                    <td class="b1"><?php echo @\cloud\core\utils\String::nFormat($rpt["charge"]);?></td>
                    <td><?php echo @round($rpt["ecpc"],2);?></td>

                    <td class="b2"><?php echo @round($rpt["roi"],2);?></td>
                    <td class="b2"><?php echo @round($click7list[$i]["roi"],2);?></td>
                    <td class="b2"><?php echo @round($click15list[$i]["roi"],2);?></td>

                    <td><?php echo @\cloud\core\utils\String::nFormat($rpt["alipayInshopAmt"]);?></td>
                    <td><?php echo @\cloud\core\utils\String::nFormat($click7list[$i]["alipayInshopAmt"]);?></td>
                    <td><?php echo @\cloud\core\utils\String::nFormat($click15list[$i]["alipayInshopAmt"]);?></td>

                    <td><?php echo @$rpt["alipayInShopNum"];?></td>
                    <td><?php echo @$click7list[$i]["alipayInShopNum"];?></td>
                    <td><?php echo @$click15list[$i]["alipayInShopNum"];?></td>

                    <td><?php echo @isset($rpt["cartNum"])?$rpt["cartNum"]:"-";?></td>
                    <td><?php echo @isset($click7list[$i]["cartNum"])?$click7list[$i]["cartNum"]:"-";?></td>
                    <td><?php echo @isset($click15list[$i]["cartNum"])?$click15list[$i]["cartNum"]:"-";?></td>

                    <td><?php echo @$rpt["dirShopColNum"];?></td>
                    <td><?php echo @$rpt["inshopItemColNum"];?></td>
                    <td><?php echo @$click7list[$i]["uv"];?></td>

                    <td><?php echo empty($rpt["uv"])?0:round(@($rpt["dirShopColNum"]/$rpt["uv"]*100),2);?></td>
                    <td><?php echo empty($rpt["uv"])?0:round(@($rpt["inshopItemColNum"]/$rpt["uv"]*100),2);?></td>
                    <td><?php echo empty($click7list[$i]["alipayInShopNum"])?0:round(@($click7list[$i]["alipayInshopAmt"]/$click7list[$i]["alipayInShopNum"]),2);?></td>
                    <td><?php echo empty($click7list[$i]["uv"])?0:round(@($click7list[$i]["alipayInShopNum"]/$click7list[$i]["uv"]*100),2);?></td>
                </tr>
            <?php endforeach;?>
            <tr class="small">
                <td><strong>总计</strong></td>
                <td><?php echo @$click3total["adPv"];?></td>
                <td><?php echo @$click3total["click"];?></td>
                <td><?php echo @round($click3total["ctr"]*100,2);?></td>
                <td class="b1"><?php echo @\cloud\core\utils\String::nFormat($click3total["charge"]);?></td>
                <td><?php echo @round($click3total["ecpc"],2);?></td>

                <td class="b2"><?php echo @round($click3total["roi"],2);?></td>
                <td class="b2"><?php echo @round($click7total["roi"],2);?></td>
                <td class="b2"><?php echo @round($click15total["roi"],2);?></td>

                <td><?php echo @\cloud\core\utils\String::nFormat($click3total["alipayInshopAmt"]);?></td>
                <td><?php echo @\cloud\core\utils\String::nFormat($click7total["alipayInshopAmt"]);?></td>
                <td><?php echo @\cloud\core\utils\String::nFormat($click15total["alipayInshopAmt"]);?></td>

                <td><?php echo @round($click3total["alipayInShopNum"]);?></td>
                <td><?php echo @round($click7total["alipayInShopNum"]);?></td>
                <td><?php echo @round($click15total["alipayInShopNum"]);?></td>

                <td><?php echo @round($click3total["cartNum"]);?></td>
                <td><?php echo @round($click7total["cartNum"]);?></td>
                <td><?php echo @round($click15total["cartNum"]);?></td>

                <td><?php echo @$click3total["dirShopColNum"];?></td>
                <td><?php echo @$click3total["inshopItemColNum"];?></td>
                <td><?php echo @$click3total["uv"];?></td>

                <td><?php echo empty($click3total["uv"])?0:round(@($click3total["dirShopColNum"]/$click3total["uv"]*100),2);?></td>
                <td><?php echo empty($click3total["uv"])?0:round(@($click3total["inshopItemColNum"]/$click3total["uv"]*100),2);?></td>
                <td><?php echo empty($click7total["alipayInShopNum"])?0:round(@($click7total["alipayInshopAmt"]/$click7total["alipayInShopNum"]),2);?></td>
                <td><?php echo empty($click7total["uv"])?0:round(@($click7total["alipayInShopNum"]/$click7total["uv"]*100),2);?></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div style="height: 50px;"></div>

</div>


    <script type="application/javascript">

        $(document).ready(function(){
            var self = $(this);

            $(".top-ul>li").eq(1).addClass("top-li-hover");

            $("#searchBtn").click(function(){
                var form = $(this).parents("form");
                form.submit();

            });

            $("#dateSetting").daterangepicker({
                "startDate": "<?php echo $query['beginDate'];?>",
                "endDate": "<?php echo $query['endDate'];?>",
                "format":"YYYY-MM-DD"
            },function (start,end){

                location.href = app.url("<?php echo $this->createUrl('/zz/advertiserrpt/more');?>",{
                    nick:'<?php echo $query["nick"];?>',
                    begin_date:start.format('YYYY-MM-DD'),
                    end_date:end.format('YYYY-MM-DD')
                })

            });

            $("#backBtn").click(function(){
                 window.location.href='<?php echo $this->createUrl("/zz/advertiserrpt/index");?>';
            });

            $("#table_fixed").freezeHeader();

        });
    </script>

