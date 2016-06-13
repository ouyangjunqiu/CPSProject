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
        <div class="shop-list-cont">
            <div class="row">
                <div class="col-md-11">
                    <div class="com-list-tit" style="display: block;">
                        <span class="shop-list-icon"></span>
                        <span class="shop-list-txt"><?php echo $query["nick"];?></span>
                        <small>
                            <a href="<?php echo $this->createUrl("/zuanshi/advertiser/more",array("nick"=>$query["nick"]));?>"><span class="label label-default">实时状况</span></a>
                            <a href="<?php echo $this->createUrl("/zuanshi/rpt/more",array("nick"=>$query["nick"]));?>"><span class="label label-info">全店推广报表</span></a>
                            <a href="<?php echo $this->createUrl("/zuanshi/adboard/index",array("nick"=>$query["nick"]));?>"><span class="label label-default">创意优选</span></a>
                            <a href="<?php echo $this->createUrl("/zuanshi/dest/index",array("nick"=>$query["nick"]));?>"><span class="label label-default">定向优选</span></a>
                            <a href="<?php echo $this->createUrl("/zuanshi/adzonerpt/index",array("nick"=>$query["nick"]));?>"><span class="label label-default">资源位优选</span></a>

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
                            <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                            <input type="text" class="form-control"  value="<?php echo $query['beginDate'];?> ~ <?php echo $query['endDate'];?>">
                            <span class="input-group-addon"><b class="caret"></b></span>
                        </div>
                    </div>

                </form>
            </div>

            <div class="col-md-1">
                <a class="btn btn-warning" href="<?php echo $this->createUrl("/zuanshi/down/more",array("nick"=>$query["nick"],"begin_date"=>$query['beginDate'],"end_date"=>$query['endDate']));?>" id="down-excel">下载</a>
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
            <?php $total = array(
                "ad_pv"=>0,
                "click"=>0,
                "charge"=>0,
                "pay"=>0,
                "pay7"=>0,
                "pay15" => 0,
                "alipayInShopNum"=>0,
                "alipayInShopNum7"=>0,
                "alipayInShopNum15"=>0,
                "dirShopColNum" => 0,
                "inshopItemColNum" =>0,
                "clickUv" =>0,
                "cartNum3"=>0,
                "cartNum7"=>0,
                "cartNum15"=>0,
            );?>
            <?php foreach($list as $rpt):?>
                <tr class="small">
                    <?php $extra = $rpt["extra"];?>
                    <td><strong><?php echo $rpt["log_date"];?></strong></td>
                    <td><?php echo $rpt["ad_pv"];?></td>
                    <td><?php echo $rpt["click"];?></td>
                    <td><?php echo $rpt["ctr"]*100;?></td>
                    <td class="b1"><?php echo \cloud\core\utils\String::nFormat($rpt["charge"]);?></td>
                    <td><?php echo $rpt["ecpc"];?></td>

                    <td class="b2"><?php echo $rpt["roi"];?></td>
                    <td class="b2"><?php echo $rpt["roi7"];?></td>
                    <td class="b2"><?php echo $extra["roi15"];?></td>

                    <td><?php echo \cloud\core\utils\String::nFormat($rpt["roi"]*$rpt["charge"]);?></td>
                    <td><?php echo \cloud\core\utils\String::nFormat($rpt["roi7"]*$rpt["charge"]);?></td>
                    <td><?php echo \cloud\core\utils\String::nFormat($extra["roi15"]*$rpt["charge"]);?></td>

                    <td><?php echo $extra["alipayInShopNum"];?></td>
                    <td><?php echo $extra["alipayInShopNum7"];?></td>
                    <td><?php echo $extra["alipayInShopNum15"];?></td>

                    <td><?php echo isset($extra["cartNum3"])?$extra["cartNum3"]:"-";?></td>
                    <td><?php echo isset($extra["cartNum7"])?$extra["cartNum7"]:"-";?></td>
                    <td><?php echo isset($extra["cartNum15"])?$extra["cartNum15"]:"-";?></td>

                    <td><?php echo $extra["dirShopColNum"];?></td>
                    <td><?php echo $extra["inshopItemColNum"];?></td>
                    <td><?php echo $extra["clickUv"];?></td>

                    <td><?php echo round(@($extra["dirShopColNum"]/$extra["clickUv"]*100),2);?></td>
                    <td><?php echo round(@($extra["inshopItemColNum"]/$extra["clickUv"]*100),2);?></td>
                    <td><?php echo round(@($rpt["roi7"]*$rpt["charge"]/$extra["alipayInShopNum7"]),2);?></td>
                    <td><?php echo round(@($extra["alipayInShopNum7"]/$extra["clickUv"]*100),2);?></td>
                </tr>
                <?php
                    $total["ad_pv"]+=$rpt["ad_pv"];
                    $total["click"]+=$rpt["click"];
                    $total["charge"]+=$rpt["charge"];
                    $total["alipayInShopNum"]+=$extra["alipayInShopNum"];
                    $total["alipayInShopNum7"]+=$extra["alipayInShopNum7"];
                    $total["alipayInShopNum15"]+=$extra["alipayInShopNum15"];
                    $total["pay"]+=$rpt["charge"]* $rpt["roi"];
                    $total["pay7"]+=$rpt["charge"]* $rpt["roi7"];
                    $total["pay15"]+=$rpt["charge"]* $extra["roi15"];

                    $total["dirShopColNum"]+=$extra["dirShopColNum"];
                    $total["inshopItemColNum"]+=$extra["inshopItemColNum"];
                    $total["clickUv"]+=$extra["clickUv"];

                    $total["cartNum3"]+=isset($extra["cartNum3"])?$extra["cartNum3"]:0;
                    $total["cartNum7"]+=isset($extra["cartNum7"])?$extra["cartNum7"]:0;
                    $total["cartNum15"]+=isset($extra["cartNum15"])?$extra["cartNum15"]:0;

                ?>
            <?php endforeach;?>
            <tr class="small">
                <td><strong>总计</strong></td>
                <td><?php echo $total["ad_pv"];?></td>
                <td><?php echo $total["click"];?></td>
                <td><?php echo @round($total["click"]/$total["ad_pv"]*100,2);?></td>
                <td class="b1"><?php echo \cloud\core\utils\String::nFormat($total["charge"]);?></td>
                <td><?php echo @round($total["charge"]/$total["click"],2);?></td>

                <td class="b2"><?php echo @round($total["pay"]/$total["charge"],2);?></td>
                <td class="b2"><?php echo @round($total["pay7"]/$total["charge"],2);?></td>
                <td class="b2"><?php echo @round($total["pay15"]/$total["charge"],2);?></td>

                <td><?php echo \cloud\core\utils\String::nFormat($total["pay"]);?></td>
                <td><?php echo \cloud\core\utils\String::nFormat($total["pay7"]);?></td>
                <td><?php echo \cloud\core\utils\String::nFormat($total["pay15"]);?></td>

                <td><?php echo @round($total["alipayInShopNum"]);?></td>
                <td><?php echo @round($total["alipayInShopNum7"]);?></td>
                <td><?php echo @round($total["alipayInShopNum15"]);?></td>

                <td><?php echo @round($total["cartNum3"]);?></td>
                <td><?php echo @round($total["cartNum7"]);?></td>
                <td><?php echo @round($total["cartNum15"]);?></td>

                <td><?php echo $total["dirShopColNum"];?></td>
                <td><?php echo $total["inshopItemColNum"];?></td>
                <td><?php echo $total["clickUv"];?></td>

                <td><?php echo round(@($total["dirShopColNum"]/$total["clickUv"]*100),2);?></td>
                <td><?php echo round(@($total["inshopItemColNum"]/$total["clickUv"]*100),2);?></td>
                <td><?php echo round(@($total["pay7"]/$total["alipayInShopNum7"]),2);?></td>
                <td><?php echo round(@($total["alipayInShopNum7"]/$total["clickUv"]*100),2);?></td>
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

                location.href = app.url("<?php echo $this->createUrl('/zuanshi/rpt/more');?>",{
                    nick:'<?php echo $query["nick"];?>',
                    begin_date:start.format('YYYY-MM-DD'),
                    end_date:end.format('YYYY-MM-DD')
                })

            });

            $("#backBtn").click(function(){
                 window.location.href='<?php echo $this->createUrl("/zuanshi/rpt/index");?>';
            });

            $("#table_fixed").freezeHeader();

        });
    </script>

