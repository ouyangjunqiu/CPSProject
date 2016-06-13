<link rel="stylesheet" href="<?php echo STATICURL.'/base/css/index.css'; ?>">
<link rel="stylesheet" href="<?php echo STATICURL.'/main/css/index.css'; ?>">

<script src='<?php echo STATICURL."/main/js/shop.js"; ?>'></script>

<div class="index-table-div">

    <div class="search-box">
        <div class="shop-list-cont" id="shop-search">
            <div class="search-log" style="display: none;"> </div>
            <div class="search-left com-list-tit" style="display: block;">
                <span class="shop-list-icon"></span>
                <span class="shop-list-txt">智·钻</span><small>
                    <a href="<?php echo $this->createUrl("/zuanshi/dashboard/index");?>"><span class="label label-default">实时状况</span></a>
                    <a href="<?php echo $this->createUrl("/zuanshi/rpt/index");?>"><span class="label label-default">全店推广报表</span></a>
                    <a href="<?php echo $this->createUrl("/zuanshi/rpt/index2");?>"><span class="label label-info">明星店铺报表</span></a>
                    <a href="<?php echo $this->createUrl("/zuanshi/summary/index");?>"><span class="label label-default">店铺统计报表</span></a>
                    <a href="<?php echo $this->createUrl("/zuanshi/summary/pic");?>"><span class="label label-default">人员统计报表</span></a>
                </small>
            </div>
            <div class="search-right">
                <?php $this->widget("application\\modules\\main\\widgets\\ShopSearchWidget",array("url"=>$this->createUrl("/zuanshi/rpt/index2",array("page"=>1)),"query"=>$query));?>

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
                                <div class="col-md-6">
                                    <h3 class="baby-frame-h3">
                                        <i class="tit-frame-icon"></i>
                                        明星店铺报表<small>(近15天)</small>

                                    </h3>
                                </div>
                                <div class="col-md-2">

                                </div>
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-2">
                                </div>
                            </div>
                            <div class="baby-frame-cont">

                                <?php if(empty($row["rpt"])):?>
                                    <p>安装插件后，登录钻石展位即可同步展示！</p>
                                <?php else:?>
                                    <?php $rpts = json_decode($row["rpt"]["rpts"],true);?>
                                    <?php if(isset($rpts["data"]["rptAdvertiserDayList"]) && !empty($rpts["data"]["rptAdvertiserDayList"])):?>
                                        <table class="baby-frame-table">
                                            <thead>
                                            <tr><td>日期</td><td>展现</td><td>点击</td><td>点击率</td><td>消耗</td><td>点击单价</td><td>收藏数</td><td>3天订单数</td><td>3天回报率</td><td>7天回报率</td></tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach($rpts["data"]["rptAdvertiserDayList"] as $rpt):?>
                                                <tr>
                                                    <td><strong><?php echo $rpt["logDateStr"];?></strong></td>
                                                    <td><?php echo $rpt["adPv"];?></td>
                                                    <td><?php echo $rpt["click"];?></td>
                                                    <td><?php echo $rpt["ctrStr"];?></td>
                                                    <td><?php echo $rpt["charge"];?></td>
                                                    <td><?php echo $rpt["ecpc"];?></td>
                                                    <td><?php echo $rpt["dirShopColNum"]+$rpt["inshopItemColNum"];?></td>
                                                    <td><?php echo $rpt["alipayInShopNum"];?></td>
                                                    <td><?php echo $rpt["roi"];?></td>
                                                    <td><?php echo $rpt["roi7"];?></td>
                                                </tr>
                                            <?php endforeach;?>
                                            <?php if(isset($rpts["data"]["rptAdvertiserDayTotal"])):?>
                                                <tr>
                                                    <td><strong>总计</strong></td>
                                                    <td><?php echo $rpts["data"]["rptAdvertiserDayTotal"]["adPv"];?></td>
                                                    <td><?php echo $rpts["data"]["rptAdvertiserDayTotal"]["click"];?></td>
                                                    <td><?php echo $rpts["data"]["rptAdvertiserDayTotal"]["ctrStr"];?></td>
                                                    <td><?php echo $rpts["data"]["rptAdvertiserDayTotal"]["charge"];?></td>
                                                    <td><?php echo $rpts["data"]["rptAdvertiserDayTotal"]["ecpc"];?></td>
                                                    <td><?php echo $rpts["data"]["rptAdvertiserDayTotal"]["dirShopColNum"]+$rpts["data"]["rptAdvertiserDayTotal"]["inshopItemColNum"];?></td>
                                                    <td><?php echo $rpts["data"]["rptAdvertiserDayTotal"]["alipayInShopNum"];?></td>
                                                    <td><?php echo $rpts["data"]["rptAdvertiserDayTotal"]["roi"];?></td>
                                                    <td><?php echo $rpts["data"]["rptAdvertiserDayTotal"]["roi7"];?></td>
                                                </tr>
                                            <?php endif;?>
                                            </tbody>
                                        </table>
                                    <?php endif;?>
                                <?php endif;?>

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


    $(document).ready(function() {
        $(".top-ul>li").eq(1).addClass("top-li-hover");

        $(".c-pager").jPager({
            currentPage: <?php echo $pager["page"]-1;?>,
            total: <?php echo $pager["count"];?>,
            pageSize: <?php echo $pager["page_size"];?>,
            events: function (dp) {
                var nick = $("input[data-ename=nick]").val();
                var pic = $("input[data-ename=pic]").val();
                location.href = app.url("<?php echo $this->createUrl('/zuanshi/rpt/index2');?>", {
                    nick: nick,
                    pic: pic,
                    page: dp.index + 1
                })
            }
        });


    })


</script>

