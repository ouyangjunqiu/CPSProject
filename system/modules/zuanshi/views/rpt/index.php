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
                    <a href="<?php echo $this->createUrl("/zuanshi/rpt/index");?>"><span class="label label-info">全店推广报表</span></a>
<!--                    <a href="--><?php //echo $this->createUrl("/zuanshi/rpt/index2");?><!--"><span class="label label-default">明星店铺报表</span></a>-->
                    <a href="<?php echo $this->createUrl("/zuanshi/summary/index");?>"><span class="label label-default">店铺统计报表</span></a>
                    <a href="<?php echo $this->createUrl("/zuanshi/summary/pic");?>"><span class="label label-default">人员统计报表</span></a>

                </small>

            </div>
            <div class="search-right">
                <?php $this->widget("application\\modules\\main\\widgets\\ShopSearchWidget",array("url"=>$this->createUrl("/zuanshi/rpt/index",array("page"=>1)),"query"=>$query));?>

            </div>
        </div>
    </div>
    <table class="table-frame">
        <tbody id="babyInforTb">
        <?php $i=1;?>
        <?php foreach($list as $row):?>
        <tr <?php if($i%2==0):?>class="stop-tr"<?php endif;?>>
            <?php $i++;?>
            <td class="babyInforTb-td-left">
                <?php $this->widget("application\\modules\\main\\widgets\\ShopManagerWidget",array("shop"=>$row));?>
            </td>
            <td class="check-infor-td">
                <div class="baby-box">
                    <div class="baby-trusteeship baby-frame-box">

                        <div class="row">
                            <div class="col-md-4">
                                <h3 class="baby-frame-h3">
                                    <i class="tit-frame-icon"></i>
                                    全店推广报表<small>(近15天)</small>

                                </h3>
                            </div>
                            <div class="col-md-7">
                                <small><a href="javascript:void(0)" data-click="list"> <i class="fa fa-bar-chart-o"></i></a></small>
                                <small><a href="javascript:void(0)" data-click="chart"><i class="fa fa-line-chart"></i></a></small>
                            </div>
                            <div class="col-md-1">

                                <small><a href="<?php echo $this->createUrl("/zuanshi/rpt/more",array("nick"=>$row["nick"]));?>">更多..</a></small>
                            </div>
                        </div>
                        <div class="overlay-wrapper" data-tmpl="shop-zuanshirpt-list-tmpl" data-load="overlay" data-url="<?php echo $this->createUrl("/zuanshi/rpt/getbynick",array("nick"=>$row["nick"],"shopname"=>$row["shopname"]));?>">
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

<script type="text/x-jquery-tmpl" id="shop-zuanshirpt-list-tmpl">
 {{if !isSuccess}}
    <div>
        <p class="text-danger">安装插件后，登录钻石展位即可同步展示！</p>
    </div>
    {{else}}
    <table data-role="list" class="baby-frame-table" style="table-layout: fixed;">
        <thead><tr class="small">
            <th>日期</th>
            <th>展现</th>
            <th>点击</th>
            <th>点击率</th>
            <th>消耗</th>
            <th>点击单价</th>
            <th>收藏数</th>
            <th>3天订单数</th>
            <th>7天订单数</th>
            <th>15天订单数</th>
            <th>3天回报率</th>
            <th>7天回报率</th>
            <th>15天回报率</th>
            <th>营业额</th>
            <th>消耗占比(%)</th>
        </tr>
        </thead>
        <tbody>
        {{each(i,rpt) data.list}}
            <tr class="small"><td><strong>${rpt.logDateStr}</strong></td>
            <td>${rpt.adPv}</td>
            <td>${rpt.click}</td>
            <td>${rpt.ctrStr}</td>
            <td>${rpt.charge}</td>
            <td>${rpt.ecpc}</td>
            <td>${rpt.favcount}</td>
            <td>${rpt.alipayInShopNum}</td>
            <td>${rpt.alipayInShopNum7}</td>
            <td>${rpt.alipayInShopNum15}</td>
            <td>${rpt.roi}</td>
            <td>${rpt.roi7}</td>
            <td>${rpt.roi15}</td>
            <td>${rpt.payAmtStr}</td>
            <td>${rpt.chargeRateStr}</td>
            </tr>
        {{/each}}

        {{if data.total}}

            <tr class="small"><td><strong>总计</strong></td>
            <td>${data.total.adPv}</td>
            <td>${data.total.click}</td>
            <td>${data.total.ctrStr}</td>
            <td>${data.total.charge}</td>
            <td>${data.total.ecpc}</td>
            <td>${data.total.favcount}</td>
            <td>${data.total.alipayInShopNum}</td>
            <td>${data.total.alipayInShopNum7}</td>
            <td>${data.total.alipayInShopNum15}</td>
            <td>${data.total.roi}</td>
            <td>${data.total.roi7}</td>
            <td>${data.total.roi15}</td>
            <td>${data.total.payAmtStr}</td>
            <td>${data.total.chargeRateStr}</td>
            </tr>
        {{/if}}
        </tbody>

        </table>
{{/if}}
</script>


<script type="application/javascript">

    $(document).ready(function(){


        $(".top-ul>li").eq(1).addClass("top-li-hover");


        $(".c-pager").jPager({currentPage: <?php echo $pager["page"]-1;?>, total: <?php echo $pager["count"];?>, pageSize: <?php echo $pager["page_size"];?>,events: function(dp){
            var nick = $("input[data-ename=nick]").val();
            var pic = $("input[data-ename=pic]").val();
            location.href = app.url("<?php echo $this->createUrl('/zuanshi/rpt/index');?>",{nick:nick,pic:pic,page:dp.index+1})
        }});

        $("a[data-click=list]").click(function(){
            var list = $(this).parents(".baby-box").find("[data-load=overlay]");
            list.DataLoad();
        });

        $("a[data-click=chart]").click(function(){
            var chartSetting = $(this).parents(".baby-box").find("[data-load=overlay]");
            $.get(chartSetting.data("url"),{},function(resp){
                var config = app.charts.default(resp.data.list,"");
                config.chart.width = chartSetting.width();
                chartSetting.highcharts(config);
            });
        });


    });

</script>

