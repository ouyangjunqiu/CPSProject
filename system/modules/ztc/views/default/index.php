<link rel="stylesheet" href="<?php echo STATICURL.'/base/css/index.css'; ?>">
<link rel="stylesheet" href="<?php echo STATICURL.'/main/css/index.css'; ?>">
<script src='<?php echo STATICURL."/main/js/shop.js"; ?>'></script>

<div class="index-table-div">

    <div class="search-box">
        <div class="shop-list-cont" id="shop-search">
            <div class="search-log" style="display: none;"> </div>
            <div class="search-left com-list-tit" style="display: block;">
                <span class="shop-list-icon"></span>
                <span class="shop-list-txt">直通车:</span><small>

                    <a href="<?php echo $this->createUrl("/zuanshi/ztc/index");?>"><span class="label label-info">全店报表</span></a>
                    <a href="http://yj.da-mai.com/index.php?r=milestone/adviser/index" target="_blank"><span class="label label-default">大麦优驾</span></a>
                </small>

            </div>
            <div class="search-right">
                <?php $this->widget("application\\modules\\main\\widgets\\ShopSearchWidget",array("url"=>$this->createUrl("/zuanshi/rpt/index",array("page"=>1)),"query"=>$query));?>

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

                    <div class="baby-box" data-nick="<?php echo $row["nick"];?>" data-role="list">
                        <ul class="nav nav-tabs shop-nav" role="tablist">
                            <li role="presentation"  class="active">
                                <a data-type="rpt" href="#rpt_<?php echo md5($row["nick"]);?>" title="总体报表" aria-controls="rpt_<?php echo md5($row["nick"]);?>" role="tab" data-toggle="tab" aria-expanded="true">
                                    <i class="fa fa-bar-chart-o"></i><span>总体报表<small>(近30天)</small></span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">

                            <div role="tabpanel" class="tab-pane active" id="todo_<?php echo md5($row["nick"]);?>">

                            <div class="overlay-wrapper" data-tmpl="shop-ztcrpt-list-tmpl" data-load="overlay" data-url="http://yj.da-mai.com/index.php?r=milestone/adviser/custreport&nick=<?php echo $row["nick"];?>">
                            </div>

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

<script type="text/x-jquery-tmpl" id="shop-ztcrpt-list-tmpl">
 {{if data.reports.length<=0}}
    <div class="alert alert-info" role="alert">
        <p>暂无该店铺的直通车数据,大麦优驾提供数据支持!</p>
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
            <th>加购物车数</th>
            <th>订单数</th>
            <th>回报率</th>
            <th>转化金额</th>
        </tr>
        </thead>
        <tbody>
        {{each(i,rpt) data.reports}}
            <tr class="small">
            <td><strong>${rpt.date}</strong></td>
            <td>${rpt.impressions}</td>
            <td>${rpt.click}</td>
            <td>${rpt.ctr}</td>
            <td>${rpt.cost}</td>
            <td>${rpt.ppc}</td>
            <td>${rpt.favcount}</td>
            <td>${rpt.carttotal}</td>
            <td>${rpt.paycount}</td>
            <td>${rpt.roi}</td>
            <td>${rpt.pay}</td>
            </tr>
        {{/each}}
        </tbody>

        </table>
        <p><small>*注：数据服务由大麦优驾提供</small></p>
{{/if}}
</script>


<script type="application/javascript">

    $(document).ready(function(){

        $(".top-ul>li").eq(2).addClass("top-li-hover");


        $(".c-pager").jPager({currentPage: <?php echo $pager["page"]-1;?>, total: <?php echo $pager["count"];?>, pageSize: <?php echo $pager["page_size"];?>,events: function(dp){

            location.href = app.url("<?php echo $this->createUrl('/ztc/default/index');?>",{page:dp.index+1})
        }});

    });

</script>

