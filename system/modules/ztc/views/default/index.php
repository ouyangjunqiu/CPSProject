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
                    <div class="baby-box">
                        <div class="baby-trusteeship baby-frame-box">

                            <div class="row">
                                <div class="col-md-4">
                                    <h3 class="baby-frame-h3">
                                        <i class="tit-frame-icon"></i>
                                        总体报表<small>(近30天)</small>

                                    </h3>
                                </div>
                                <div class="col-md-7">
                                </div>
                                <div class="col-md-1">
                                    <small><a href="http://yj.da-mai.com/index.php?r=milestone/adviser/index&ishide=1&nick=<?php echo $row["nick"];?>" target="_blank">更多..</a></small>
                                </div>
                            </div>
                            <div class="overlay-wrapper" data-tmpl="shop-ztcrpt-list-tmpl" data-load="overlay" data-url="http://yj.da-mai.com/index.php?r=milestone/adviser/custreport&nick=<?php echo $row["nick"];?>">
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
{{/if}}
</script>


<script type="application/javascript">

    $(document).ready(function(){

        $(".top-ul>li").eq(2).addClass("top-li-hover");


        $(".c-pager").jPager({currentPage: <?php echo $pager["page"]-1;?>, total: <?php echo $pager["count"];?>, pageSize: <?php echo $pager["page_size"];?>,events: function(dp){
            var nick = $("input[data-ename=nick]").val();
            var pic = $("input[data-ename=pic]").val();
            location.href = app.url("<?php echo $this->createUrl('/ztc/default/index');?>",{nick:nick,pic:pic,page:dp.index+1})
        }});

    });

</script>

