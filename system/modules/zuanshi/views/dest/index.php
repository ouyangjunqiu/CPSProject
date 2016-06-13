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
                            <a href="<?php echo $this->createUrl("/zuanshi/rpt/more",array("nick"=>$query["nick"]));?>"><span class="label label-default">全店推广报表</span></a>
                            <a href="<?php echo $this->createUrl("/zuanshi/adboard/index",array("nick"=>$query["nick"]));?>"><span class="label label-default">创意优选</span></a>
                            <a href="<?php echo $this->createUrl("/zuanshi/dest/index",array("nick"=>$query["nick"]));?>"><span class="label label-info">定向优选</span></a>
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
                <small>近7天统计报表</small>
                <a href="<?php echo $this->createUrl("/zuanshi/dest/index",array("nick"=>$query["nick"],"orderby"=>"ctr"));?>">
                    <?php if($query["orderby"] == "ctr"):?><span class="label label-info"><?php else:?><span class="label label-default"><?php endif;?>点击率</span>
                </a>
                <a href="<?php echo $this->createUrl("/zuanshi/dest/index",array("nick"=>$query["nick"],"orderby"=>"charge"));?>">
                    <?php if($query["orderby"] == "charge"):?><span class="label label-info"><?php else:?><span class="label label-default"><?php endif;?>消耗</span>
                </a>
                <a href="<?php echo $this->createUrl("/zuanshi/dest/index",array("nick"=>$query["nick"],"orderby"=>"alipayInShopNum7"));?>">
                    <?php if($query["orderby"] == "alipayInShopNum7"):?><span class="label label-info"><?php else:?><span class="label label-default"><?php endif;?>转化</span>
                </a>
            </div>

            <div class="col-md-1">
<!--                <a class="btn btn-warning" href="--><?php //echo $this->createUrl("/zuanshi/down/more",array("nick"=>$query["nick"],"begin_date"=>$query['beginDate'],"end_date"=>$query['endDate']));?><!--" id="down-excel">下载</a>-->
            </div>
        </div>

        <table class="baby-frame-table" id="table_fixed" style="table-layout: fixed;">
            <thead class="header">
            <tr>
                <th>人群名称</th>
                <th>展现</th>
                <th>点击</th>
                <th>点击率(%)</th>
                <th class="b1">消耗(元)</th>
                <th>点击单价(元)</th>

                <th class="b2">3天回报率</th>
                <th class="b2">7天回报率</th>

                <th>3天转化金额(元)</th>
                <th>7天转化金额(元)</th>

                <th>3天订单数</th>
                <th>7天订单数</th>

                <th>3天加购物车数</th>
                <th>7天加购物车数</th>

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

            <?php if(empty($list)):?>
                <tr><td colspan="22">暂无定向分析报表, 请在钻石展位后台使用精准平台小助手的"下载定向报表"功能下载定向人群报表!</td></tr>
            <?php else:?>

            <?php foreach($list as $rpt):?>
                <tr>
                    <td><strong><?php echo $rpt["targetName"];?></strong></td>
                    <td><?php echo $rpt["adPv"];?></td>
                    <td><?php echo $rpt["click"];?></td>
                    <td><?php echo round(@($rpt["click"]/$rpt["adPv"]),4)*100;?></td>
                    <td class="b1"><?php echo \cloud\core\utils\String::nFormat($rpt["charge"]);?></td>
                    <td><?php echo round(@($rpt["charge"]/$rpt["click"]),2);?></td>

                    <td class="b2"><?php echo empty($rpt["pay"])?"-":round(@($rpt["pay"]/$rpt["charge"]),2);?></td>
                    <td class="b2"><?php echo empty($rpt["pay7"])?"-":round(@($rpt["pay7"]/$rpt["charge"]),2);?></td>

                    <td><?php echo empty($rpt["pay"])?"-":\cloud\core\utils\String::nFormat($rpt["pay"]);?></td>
                    <td><?php echo empty($rpt["pay7"])?"-":\cloud\core\utils\String::nFormat($rpt["pay7"]);?></td>

                    <td><?php echo $rpt["alipayInShopNum"];?></td>
                    <td><?php echo $rpt["alipayInShopNum7"];?></td>

                    <td><?php echo $rpt["cartNum3"];?></td>
                    <td><?php echo $rpt["cartNum7"];?></td>

                    <td><?php echo $rpt["dirShopColNum"];?></td>
                    <td><?php echo $rpt["inshopItemColNum"];?></td>
                    <td><?php echo $rpt["clickUv"];?></td>

                    <td><?php echo round(@($rpt["dirShopColNum"]/$rpt["clickUv"]*100),2);?></td>
                    <td><?php echo round(@($rpt["inshopItemColNum"]/$rpt["clickUv"]*100),2);?></td>
                    <td><?php echo round(@($rpt["pay7"]/$rpt["alipayInShopNum7"]),2);?></td>
                    <td><?php echo round(@($rpt["alipayInShopNum7"]/$rpt["clickUv"]*100),2);?></td>
                </tr>

            <?php endforeach;?>
            <?php endif;?>
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


        $("#backBtn").click(function(){
            window.location.href='<?php echo $this->createUrl("/zuanshi/rpt/index");?>';
        });

        $("#table_fixed").freezeHeader();

    });
</script>

