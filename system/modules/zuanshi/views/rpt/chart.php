<link rel="stylesheet" href="<?php echo STATICURL.'/main/css/index.css'; ?>">
<script src='<?php echo STATICURL."/main/js/shop.js"; ?>'></script>

<div class="index-table-div">

    <div class="search-box">
        <div class="shop-list-cont" id="shop-search">
            <div class="search-log" style="display: none;"> </div>
            <div class="search-left com-list-tit" style="display: block;">
                <span class="shop-list-icon"></span>
                <span class="shop-list-txt">展示网络报表</span><small>
                    | <a href="<?php echo $this->createUrl("/zuanshi/rpt/index2");?>"><i class="fa fa-signal"></i> 明星店铺报表</a>
                    | <a href="<?php echo $this->createUrl("/main/default/index");?>"><i class="fa fa-home"></i>店铺列表</a>
                    | <a href="<?php echo $this->createUrl("/main/case/index");?>"><i class="fa fa-home"></i>CASE列表</a>
                </small>

            </div>
            <div class="search-right">
                <form>
                    <input placeholder="店铺名称" type="text" class="input-text search-shop-name" data-name="店铺名称" name="nick" value="<?php echo $query['nick'];?>">
                    <input placeholder="钻展、大数据、直通车负责人" type="text" class="input-text search-manager" data-name="钻展、大数据、直通车负责人" name="pic" style="width: 180px;" value="<?php echo $query['pic'];?>">
                    <?php echo CHtml::dropDownList("shoptype",$query['shoptype'],array(""=>"请选择合作业务","直钻业务"=>"直钻业务","直通车业务"=>"直通车业务","钻展业务"=>"钻展业务"));?>
                    <input type="button" class="btn-orange" value="搜索" id="searchBtn">
                </form>
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
                                        展示网络报表<small>(近15天)</small>

                                    </h3>
                                </div>
                                <div class="col-md-2">

                                </div>
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-2">
                                    <a href="<?php echo $this->createUrl("/zuanshi/rpt/more",array("nick"=>$row["nick"]));?>"><small>更多>>></small></a>
                                </div>
                            </div>
                            <div class="baby-frame-cont">

                                <?php if(empty($row["rpt"])):?>
                                    <p>安装插件后，登录钻石展位即可同步展示！</p>
                                <?php else:?>
                                    <?php $rpts = json_decode($row["rpt"]["rpts"],true);?>
                                    <?php if(isset($rpts["data"]["rptAdvertiserDayList"]) && !empty($rpts["data"]["rptAdvertiserDayList"])):?>
                                        <?php
                                        $data = array();
                                        foreach($rpts["data"]["rptAdvertiserDayList"] as $rpt) {
                                            $data[] = array(
                                                "date" => $rpt["logDateStr"],
                                                "pv" => $rpt["adPv"],
                                                "click" => $rpt["click"],
                                                "charge" => $rpt["charge"],
                                                "ecpc" =>  $rpt["ecpc"],
                                                "paycount" => $rpt["alipayInShopNum"],
                                                "roi3" => $rpt["roi"],
                                                "ctr"=> $rpt["ctrStr"],
                                                "favcount" => $rpt["dirShopColNum"]+$rpt["inshopItemColNum"]
                                            );
                                        }?>
                                        <div data-role="charts" data-rpts='<?php echo CJSON::encode($data);?>'></div>
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

    $(document).ready(function(){


        $(".sidebar-menu>li").eq(2).addClass("active");

        $("#shop-search").keydown(function(event){
            if(event.which == 13){
                $("#searchBtn").trigger("click");
            }
        });

        $("#searchBtn").click(function(){
            var form = $(this).parent();
            var data = {};
            data.nick = form.find("input[name=nick]").val();
            data.pic = form.find("input[name=pic]").val();
            data.shoptype = form.find("select[name=shoptype]").val();
            data.page = 1;
            location.href = app.url("<?php echo $this->createUrl('/zuanshi/rpt/index');?>",data)
        });


        $(".c-pager").jPager({currentPage: <?php echo $pager["page"]-1;?>, total: <?php echo $pager["count"];?>, pageSize: <?php echo $pager["page_size"];?>,events: function(dp){
            var nick = $("input[data-ename=nick]").val();
            var pic = $("input[data-ename=pic]").val();
            location.href = app.url("<?php echo $this->createUrl('/zuanshi/rpt/index');?>",{nick:nick,pic:pic,page:dp.index+1})
        }});

        $("div[data-role=charts]").each(function(){
           var data = eval("("+$(this).attr("data-rpts")+")");
            $(this).highcharts(app.charts.default(data,""));
        });

    });

</script>

