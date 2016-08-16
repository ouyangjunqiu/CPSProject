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
                            <a href="<?php echo $this->createUrl("/zz/advertiserrpt/more",array("nick"=>$query["nick"]));?>"><span class="label label-info">全店推广报表</span></a>
                            <a href="<?php echo $this->createUrl("/zz/year/month",array("nick"=>$query["nick"]));?>"><span class="label label-default">年度走势</span></a>

                            <a href="<?php echo $this->createUrl("/zz/adboardrpt/index",array("nick"=>$query["nick"]));?>"><span class="label label-info">创意优选</span></a>

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
                <small><?php echo date("Y.m.d",strtotime($query["begindate"]));?>~<?php echo date("Y.m.d",strtotime($query["enddate"]));?>统计报表:</small>
                <a href="<?php echo $this->createUrl("/zz/adboardrpt/index",array("nick"=>$query["nick"],"orderby"=>"ctr"));?>">
                    <?php if($query["orderby"] == "ctr"):?><span class="label label-info"><?php else:?><span class="label label-default"><?php endif;?>点击率</span>
                </a>
                <a href="<?php echo $this->createUrl("/zz/adboardrpt/index",array("nick"=>$query["nick"],"orderby"=>"charge"));?>">
                    <?php if($query["orderby"] == "charge"):?><span class="label label-info"><?php else:?><span class="label label-default"><?php endif;?>消耗</span>
                </a>
                <a href="<?php echo $this->createUrl("/zz/adboardrpt/index",array("nick"=>$query["nick"],"orderby"=>"alipayInshopAmt"));?>">
                    <?php if($query["orderby"] == "alipayInshopAmt"):?><span class="label label-info"><?php else:?><span class="label label-default"><?php endif;?>转化</span>
                </a>
            </div>

            <div class="col-md-1">
<!--                <a class="btn btn-warning" href="--><?php //echo $this->createUrl("/zuanshi/down/adboard",array("nick"=>$query["nick"]));?><!--" id="down-excel">下载</a>-->
            </div>
        </div>

        <table class="table-frame" style="table-layout: fixed;">
            <thead class="header">
            <tr class="small">
                <th>创意名称</th>
                <th class="b1">流量相关</th>
                <th class="b2">转化相关</th>
            </tr>
            </thead>
            <tbody>

            <?php if(empty($list)):?>
                <tr><td colspan="4">暂无创意分析报表!</td></tr>
            <?php else:?>

            <?php foreach($list as $rpt):?>
                <tr>
                    <td>
                        <a data-target="#tooltip_box" data-backdrop="false" data-toggle="modal" data-image="<?php echo $rpt["imagePath"];?>" data-name="<?php echo $rpt["adboardName"];?>">
                            <div class="thumbnail">

                                <img src="<?php echo $rpt["imagePath"];?>" alt="<?php echo $rpt["adboardName"];?>" class="img-rounded" />

                                <div class="caption">
                                    <p><?php echo $rpt["adboardName"];?></p>
                                </div>
                            </div>

                        </a>
                       <strong><?php echo $rpt["adboardName"];?></strong>
                    </td>
                    <td class="b1">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <small>展现:</small>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $rpt["adPv"];?></strong>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <small>点击:</small>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $rpt["click"];?></strong>
                            </div>
                            <div class="col-md-2"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <small>消耗:</small>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo \cloud\core\utils\String::nFormat($rpt["charge"]);?></strong>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <small>点击单价:</small>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo round(@($rpt["charge"]/$rpt["click"]),2);?></strong>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <small>点击率:</small>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $rpt["ctr"];?></strong>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </td>


                    <td class="b2">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <small>转化金额:</small>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo empty($rpt["alipayInshopAmt"])?0:\cloud\core\utils\String::nFormat($rpt["alipayInshopAmt"]);?></strong>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <small>ROI:</small>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo empty($rpt["roi"])?"-":round($rpt["roi"],2);?></strong>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <small>三天订单数:</small>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $rpt["alipayInShopNum"];?></strong>
                            </div>
                            <div class="col-md-2"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <small>店铺收藏数:</small>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $rpt["dirShopColNum"];?></strong>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <small>宝贝收藏数:</small>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $rpt["inshopItemColNum"];?></strong>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </td>
                </tr>

            <?php endforeach;?>
            <?php endif;?>
            </tbody>
        </table>
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

