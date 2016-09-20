<link rel="stylesheet" href="<?php echo STATICURL.'/main/css/index.css'; ?>">
<script src='<?php echo STATICURL."/main/js/shop.js"; ?>'></script>

<div class="index-table-div">

    <div class="search-box">
        <div class="shop-list-cont" id="shop-search">
            <div class="search-log" style="display: none;"> </div>
            <div class="search-left com-list-tit" style="display: block;">
                <span class="shop-list-icon"></span>
                <span class="shop-list-txt">店铺列表</span>
            </div>
            <div class="search-right">
                <input placeholder="店铺名称" type="text" class="input-text search-shop-name" data-name="店铺名称" data-ename="nick" value="<?php echo $query['nick'];?>">
                <input placeholder="钻展、大数据、直通车负责人" type="text" class="input-text search-manager" data-name="钻展、大数据、直通车负责人" data-ename="pic" style="width: 180px;" value="<?php echo $query['pic'];?>">
                <input type="button" class="btn-orange" value="搜索" id="searchBtn">
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
                                    整体报表<small>(近15天)</small>

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
                                    <p>安装插件后，登录达摩盘即可同步展示！</p>
                                <?php else:?>
                                    <?php $rpts = json_decode($row["rpt"]["rpts"],true);?>
                                    <?php if(isset($rpts["data"]["list"]) && !empty($rpts["data"]["list"])):?>
                                    <table class="baby-frame-table">
                                        <thead>
                                        <tr><td>日期</td><td>加购物车次数</td><td>展现量</td><td>点击量</td><td>消耗金额（元）</td><td>3天回报率</td><td>7天回报率</td><td>宝贝收藏次数</td></tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($rpts["data"]["list"] as $rpt):?>
                                            <tr>
                                                <td><strong><?php echo $rpt["thedate"];?></strong></td>
                                                <td><?php echo $rpt["shoppingcartnum"];?></td>
                                                <td><?php echo $rpt["shownum"];?></td>
                                                <td><?php echo $rpt["clicknum"];?></td>
                                                <td><?php echo $rpt["consumeamount"];?></td>
                                                <td><?php echo $rpt["fifteendaycaprate"];?></td>
                                                <td><?php echo $rpt["sevendaycaprate"];?></td>
                                                <td><?php echo $rpt["collectionnum"];?></td>
                                            </tr>
                                        <?php endforeach;?>
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
        <div class="pager">
            <div class="pages-pre pager-pn"><span class="pages-pre-span">第一页</span><span class="pages-pre-span">上一页</span><span class="jPag-sprevious">&lt;&lt;</span></div>
            <div class="pagerol-div">
                <ol class="pagerol">
                </ol>
            </div>
            <div class="pages-next pager-pn"><span class="jPag-snext">&gt;&gt;</span>
                <span class="jPag-snext-span">下一页</span><span class="jPag-snext-span">最后页</span></div>
            <div class="pager-label">共<span class="total-y">0</span>页<span class="total-l">0</span>条数据</div>

        </div>

    </div>
</div>


<script type="application/javascript">

    $(document).ready(function() {

        $("#shop-search").keydown(function (event) {
            if (event.which == 13) {
                $("#searchBtn").trigger("click");
            }
        });

        $("#searchBtn").click(function () {
            var nick = $("input[data-ename=nick]").val();
            var pic = $("input[data-ename=pic]").val();
            location.href = app.url("<?php echo $this->createUrl('/dmp/rpt/index');?>", {nick: nick, pic: pic, page: 1})
        });


        $(".c-pager").jPager({
            currentPage: <?php echo $pager["page"]-1;?>,
            total: <?php echo $pager["count"];?>,
            pageSize: <?php echo $pager["page_size"];?>,
            events: function (dp) {
                var nick = $("input[data-ename=nick]").val();
                var pic = $("input[data-ename=pic]").val();
                location.href = app.url("<?php echo $this->createUrl('/dmp/rpt/index');?>", {
                    nick: nick,
                    pic: pic,
                    page: dp.index + 1
                })
            }
        });


    });

</script>

