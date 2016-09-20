<link rel="stylesheet" href="<?php echo STATICURL.'/main/css/index.css'; ?>">
<style>
    .w100{
        width: 100px;
    }
</style>
<div class="index-table-div">

    <div class="search-box">
        <div class="shop-list-cont" id="plan-fixed-header">
            <div class="row">
                <div class="col-md-8">
                    <div class="com-list-tit" style="display: block;">
                        <span class="shop-list-icon"></span>
                        <span class="shop-list-txt"><?php echo $query["nick"];?></span>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="search-right">
                        <?php echo \CHtml::dropDownList("days",$query["days"],array(
                            "365"=>"查看所有的竞品店铺",
                            "7"=>"最近7天内的竞品店铺",
                            "15"=>"最近15天内的竞品店铺",
                            "30"=>"最近30天内的竞品店铺",
                            "90"=>"最近90天内的竞品店铺",
                        ),array("class"=>"form-control"));?>

                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 10px;margin-bottom: 10px">

            <div class="col-md-12">

                    <?php $useArr = array(""=>"所有","-1"=>"未使用","1"=>"已使用");?>
                    <form id="shop-vie-search-form" action="<?php echo $this->createUrl("/zuanshi/setting/vie");?>" method="post" class="form-inline">
                        <?php echo \cloud\core\utils\Html::selectCombox("is_use",$query["is_use"],$useArr,array("id"=>"use_search_field"));?>

                        <div class="form-group">
                            <small>筛选:</small>
                            <input type="email" class="form-control" name="keyword" value="<?php echo $query["keyword"];?>" placeholder="搜索关键词">
                        </div>

                        <div class="form-group">
                            <small>销量:</small>
                            <input placeholder="最小" type="text" class="form-control" name="low_cnt" value="<?php echo $query["low_cnt"];?>" style="width: 55px">-
                            <input placeholder="最大" type="text" class="form-control" name="max_cnt"  value="<?php echo $query["max_cnt"];?>" style="width: 55px">
                        </div>

                        <input type="hidden"  name="days"  value="<?php echo $query["days"];?>">
                        <input type="hidden" name="nick" value="<?php echo $query["nick"];?>"/>

                        <input type="button" class="btn btn-warning" value="搜索" id="searchBtn">
                    </form>
                </div>

        </div>


        <?php if(empty($list)):?>
            <div class="baby-frame-cont">
                <p>暂无竞品店铺！</p>
            </div>
        <?php else:?>
            <form id="shop-selector-form">
                <input type="hidden" name="nick" value="<?php echo $query["nick"];?>"/>
                <table class="baby-frame-table">
                    <thead>
                    <tr>
                        <td><small><a class="select-all" href="javascript:void(0)">全选</a>/<a class="not-select-all" href="javascript:void(0)">全不选</a>/<a class="re-select-all" href="javascript:void(0)">反选</a></small></td>
                        <td><small>店铺名</small></td>
                        <td><small><a href="<?php echo $this->createUrl("/zuanshi/setting/vie",array("nick"=>$query["nick"],"orderby"=>"cnt"));?>"><small>月销量<?php if($query["orderby"] == "cnt"):?><span class="caret"></span><?php endif;?></small></td>
                        <td><small>搜索关键词</small></td>
                        <td><small><a href="<?php echo $this->createUrl("/zuanshi/setting/vie",array("nick"=>$query["nick"],"orderby"=>"log_date"));?>"><small>记录日期<?php if($query["orderby"] == "log_date"):?><span class="caret"></span><?php endif;?></small></td>
                        <td><small>是否使用</small></td>
                    </tr>

                    </thead>
                    <tbody>

                    <?php foreach($list as $row):?>
                        <tr data-list="shops">
                            <td>
                                <input class="shiftCheckbox" data-shop="<?php echo $row["shopnick"];?>" type="checkbox" name="shops[]" value="<?php echo $row["id"];?>,<?php echo $row["shopnick"];?>,<?php echo $row["cnt"];?>" <?php if(isset($row["isSelect"]) && $row["isSelect"]):?>checked="checked"<?php endif;?> />
                            </td>
                            <td><strong><?php echo $row["shopnick"];?></strong></td>
                            <td>
                                <?php echo $row["cnt"];?>
                            </td>
                            <td>
                                <?php echo $row["keyword"];?>
                            </td>
                            <td>
                                <?php echo $row["log_date"];?>
                            </td>
                            <td>
                                <?php if($row["campaignid"]>0):?>
                                    已使用<small>(<?php echo $row["campaignid"];?>)</small>
                                <?php else:?>
                                    未使用
                                <?php endif;?>
                            </td>

                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>

            </form>
        <?php endif;?>

        <div style="height: 60px"></div>
        <div style="position: fixed;bottom: 0px;width: 100%;background: white;opacity: 0.9; height: 100px;padding-top: 30px;">
            <div class="row">
                <div class="col-md-2">
                    <small><a class="select-all" href="javascript:void(0)">全选</a>/<a class="not-select-all" href="javascript:void(0)">全不选</a>/<a class="re-select-all" href="javascript:void(0)">反选</a></small>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-primary" data-click="shopbtn">设置完成</button>
                </div>
                <div class="col-md-5">
                    <p>
                        <o class="glyphicon glyphicon-hand-right"></o>下一步，请登录钻展后台，使用精准平台小助手的"批量推广..."功能完成后续推广操作！
                    </p>
                </div>
                <div class="col-md-3">
                    <input type="button" class="btn btn-default" value="上一步" id="backBtn">
                </div>

            </div>
        </div>

    </div>
</div>

<script type="application/javascript">


    $(document).ready(function(){

        $("select[name=days]").change(function(){

            $("#shop-vie-search-form").find("input[name=days]").val($(this).val());
            $("#shop-vie-search-form").submit();

        });

        $("#use_search_field").change(function(event){
            $("#shop-vie-search-form").submit();
        });

        $("#shop-vie-search-form").keydown(function(event){
            if(event.which == 13){
                $("#searchBtn").trigger("click");
            }
        });

        $("#backBtn").click(function(){
            window.location.href='<?php echo $this->createUrl("/zuanshi/setting/adzone",array("nick"=>$query["nick"]));?>';
        });

        $("#searchBtn").click(function(){
            $(this).parents("form").submit();
        });

        var selectFn  = function(){
            var selectCount = 0;
            var shops = [];
            $("[data-list=shops] .shiftCheckbox").each(function(){
                if(this.checked){
                    selectCount++;
                    var shop = $(this).attr("data-shop");
                    if($.inArray(shop,shops)<0){
                        shops.push(shop);
                    }
                }

            });

            $("button[data-click=shopbtn]").html("已选择店铺("+shops.length+"/"+selectCount+"),设置完成");
        };

        selectFn();

        $("button[data-click=shopbtn]").click(function(){
            var form = $("#shop-selector-form");
            $.ajax({
                url:"<?php echo $this->createUrl('/zuanshi/setting/bindvie');?>",
                type:"post",
                data:form.serialize(),
                dataType:"json",
                success:function(resp){
                    $("body").hideLoading();
                    if(resp.isSuccess) {
                        app.alert('设置成功,请登录钻石展位后台,请使用精准平台小助手的批量推广按钮!');
                    }else{
                        app.error('添加失败');
                    }
                },
                beforeSend:function(){
                    $("body").showLoading();
                },
                error:function(){
                    $("body").hideLoading();
                }
            })

        });
        $("#shop-selector-form").click(function(){
            selectFn();
        });

        $(".select-all").click(function(){
            $("[data-list=shops] .shiftCheckbox").each(function () {
                this.checked = true;
            });
            selectFn();
        });

        $(".not-select-all").click(function(){
            $("[data-list=shops] .shiftCheckbox").each(function () {
                this.checked = false;
            });
            selectFn();
        });
        $(".re-select-all").click(function(){
            $("[data-list=shops] .shiftCheckbox").each(function () {
                if(this.checked)
                    this.checked = false;
                else
                    this.checked = true;
            });
            selectFn();
        });

        $("#checker-all").click(function(){
            if (this.checked) {

                $("[data-list=shops] .shiftCheckbox").each(function () {
                    this.checked = true;
                });
            }
            else {
                $("[data-list=shops] .shiftCheckbox").each(function () {
                    this.checked = false;
                });
            }
            selectFn();
        });

        $('.shiftCheckbox').shiftcheckbox();

    });
</script>

