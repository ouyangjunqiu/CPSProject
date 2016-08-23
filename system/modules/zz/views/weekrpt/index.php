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
                            <a href="<?php echo $this->createUrl("/zz/advertiserrpt/more",array("nick"=>$query["nick"]));?>"><span class="label label-default">全店推广报表</span></a>
                            <a href="<?php echo $this->createUrl("/zz/year/month",array("nick"=>$query["nick"]));?>"><span class="label label-default">年度走势</span></a>
                            <a href="<?php echo $this->createUrl("/zz/weekrpt/index",array("nick"=>$query["nick"]));?>"><span class="label label-info">周报</span></a>

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
        <div class="row" style="margin: 10px 0px;">
            <div class="col-md-11">
                <small>统计: <?php echo date("m.d",strtotime($query["begindate"]));?> ~ <?php echo date("m.d",strtotime($query["enddate"]));?> </small>

                <a href="<?php echo $this->createUrl("/zz/weekrpt/index",array("nick"=>$query["nick"],"orderby"=>"charge"));?>">
                    <?php if($query["orderby"] == "charge"):?><span class="label label-info"><?php else:?><span class="label label-default"><?php endif;?>消耗</span>
                </a>
                <a href="<?php echo $this->createUrl("/zz/weekrpt/index",array("nick"=>$query["nick"],"orderby"=>"alipayInshopAmt"));?>">
                    <?php if($query["orderby"] == "alipayInshopAmt"):?><span class="label label-info"><?php else:?><span class="label label-default"><?php endif;?>转化</span>
                </a>
                <a href="<?php echo $this->createUrl("/zz/weekrpt/index",array("nick"=>$query["nick"],"orderby"=>"ctr"));?>">
                    <?php if($query["orderby"] == "ctr"):?><span class="label label-info"><?php else:?><span class="label label-default"><?php endif;?>点击率</span>
                </a>
            </div>

            <div class="col-md-1">
<!--                <a class="btn btn-warning" href="--><?php //echo $this->createUrl("/zuanshi/down/adboard",array("nick"=>$query["nick"]));?><!--" id="down-excel">下载</a>-->
            </div>
        </div>

        <div class="row" style="margin: 10px 0px;">
            <div data-load="overlay" data-tmpl="zuanshi-adboard-week-rpt-tmpl" data-role="zuanshi-adboard-week-rpt" data-url="<?php echo $this->createUrl("/zz/adboardrpt/week",array("nick"=>$query["nick"],"date"=>$query["date"],"orderby"=>$query["orderby"]));?>">
            </div>
        </div>

        <div class="row" style="margin: 10px 0px;">
            <div data-load="overlay" data-tmpl="zuanshi-dmpdest-week-rpt-tmpl" data-role="zuanshi-dmpdest-week-rpt-tmpl" data-url="<?php echo $this->createUrl("/zz/destrpt/week",array("nick"=>$query["nick"],"date"=>$query["date"],"orderby"=>$query["orderby"],"destType"=>128));?>">
            </div>
        </div>
    </div>

    <div id="tooltip_box" class="modal fade" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">创意预览</h4>
                </div>
                <div class="modal-body">

                    <img src="" alt="" class="img-thumbnail">
                </div>
            </div>
        </div>
    </div>

    <div style="height: 50px;"></div>

</div>

<script type="text/x-jquery-tmpl" id="zuanshi-adboard-week-rpt-tmpl">
    <table class="table-frame" style="table-layout: fixed;">
        <thead class="header">
            <tr class="small">
                <th>创意名称</th>
                <th class="b1">流量相关</th>
                <th class="b2">转化相关</th>
            </tr>
        </thead>
        <tbody>
        {{if !isSuccess}}
            <tr><td colspan="3">暂无创意分析报表!</td></tr>
        {{else}}
            {{each(i,rpt) data}}
               <tr>
                    <td>
                        <a data-target="#tooltip_box" data-backdrop="false" data-toggle="modal" data-image="${rpt.imagePath}" data-name="${rpt.adboardName}">
                            <div class="">

                                <img src="${rpt.imagePath}" alt="${rpt.adboardName}" class="img-rounded" style="width: 220px;"/>

                                <div class="caption">
                                    <p><small>${rpt.adboardName}</small></p>
                                </div>
                            </div>

                        </a>
                    </td>
                    <td class="b1">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <small>展现:</small>
                            </div>
                            <div class="col-md-4">
                                <strong>${rpt.adPv}</strong>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <small>点击:</small>
                            </div>
                            <div class="col-md-4">
                                <strong>${rpt.click}</strong>
                            </div>
                            <div class="col-md-2"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <small>消耗(元):</small>
                            </div>
                            <div class="col-md-4">
                                <strong>${rpt.charge}</strong>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <small>点击单价(元):</small>
                            </div>
                            <div class="col-md-4">
                                <strong>${rpt.ecpc}</strong>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <small>点击率(%):</small>
                            </div>
                            <div class="col-md-4">
                                <strong>${rpt.ctr}</strong>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </td>


                    <td class="b2">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <small>转化金额(元):</small>
                            </div>
                            <div class="col-md-4">
                                <strong>${rpt.alipayInshopAmt}</strong>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <small>投资回报:</small>
                            </div>
                            <div class="col-md-4">
                                <strong>${rpt.roi.toFixed(2)}</strong>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <small>订单数:</small>
                            </div>
                            <div class="col-md-4">
                                <strong>${rpt.alipayInShopNum}</strong>
                            </div>
                            <div class="col-md-2"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <small>店铺收藏数:</small>
                            </div>
                            <div class="col-md-4">
                                <strong>${rpt.dirShopColNum}</strong>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <small>宝贝收藏数:</small>
                            </div>
                            <div class="col-md-4">
                                <strong>${rpt.inshopItemColNum}</strong>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </td>
                </tr>

           {{/each}}
    {{/if}}
</tbody>
</table>
</script>

<script type="text/x-jquery-tmpl" id="zuanshi-dmpdest-week-rpt-tmpl">

<table class="baby-frame-table" id="table_fixed" style="table-layout: fixed;">
     <thead class="header">
        <tr class="small">
            <th>人群名称</th>
            <th>展现</th>
            <th>点击</th>
            <th>点击率(%)</th>
            <th class="b1">消耗(元)</th>
            <th>点击单价(元)</th>

            <th class="b2">投资回报率</th>

            <th>转化金额(元)</th>

            <th>订单数</th>

            <th>加购物车数</th>

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

        {{if !isSuccess}}
            <tr><td colspan="17">暂无DMP定向分析报表!</td></tr>
        {{else}}

            {{each(i,rpt) data}}
                <tr class="small">
                    <td><strong>${rpt.targetName}</strong></td>
                    <td>${rpt.adPv}</td>
                    <td>${rpt.click}</td>
                    <td>${rpt.ctr}</td>
                    <td class="b1">${rpt.charge}</td>
                    <td>${rpt.ecpc}</td>

                    <td class="b2">${rpt.roi}</td>
                    <td class="b2">${rpt.alipayInshopAmt}</td>

                    <td>${rpt.alipayInShopNum}</td>

                    <td>${rpt.cartNum}</td>

                    <td>${rpt.dirShopColNum}</td>
                    <td>${rpt.inshopItemColNum}</td>
                    <td>${rpt.uv}</td>

                    <td>
                        {{if rpt.uv>0}}
                         ${rpt.dirShopColNum/rpt.uv*100.toFixed(2)}
                        {{else}}
                            -
                        {{/if}}
                    </td>
                    <td>
                        {{if rpt.uv>0}}
                         ${rpt.inshopItemColNum/rpt.uv*100.toFixed(2)}
                        {{else}}
                            -
                        {{/if}}
                    </td>
                    <td>
                        {{if rpt.alipayInShopNum>0}}
                            ${rpt.alipayInshopAmt/rpt.alipayInShopNum*100.toFixed(2)}
                        {{else}}
                            -
                        {{/if}}
                    </td>
                    <td>
                        {{if rpt.uv>0}}
                            ${rpt.alipayInShopNum/rpt.uv*100.toFixed(2)}
                        {{else}}
                            -
                        {{/if}}

                    </td>
                </tr>
            {{/each}}
        {{/if}}
     </tbody>
</table>
</script>

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

        $('#tooltip_box').on('show.bs.modal', function (event) {
            var self = $(this);
            var button = $(event.relatedTarget); // Button that triggered the modal
            var imagePath = button.data('image'); // Extract info from data-* attributes

            var name = button.data('name');

            $(this).find(".modal-title").html("<small>创意预览:</small>"+name);

            $(this).find(".img-thumbnail").attr("src",imagePath);
        });

    });
</script>

