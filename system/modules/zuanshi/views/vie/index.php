<link rel="stylesheet" href="<?php echo STATICURL.'/main/css/index.css'; ?>">

<div class="index-table-div">

    <div class="search-box">
        <div class="shop-list-cont" id="plan-fixed-header">
            <div class="row">
                <div class="col-md-8">
                    <div class="com-list-tit" style="display: block;">
                        <span class="shop-list-icon"></span>
                        <span class="shop-list-txt"><?php echo $query["nick"];?></span>
                        <small>
                            <a href="<?php echo $this->createUrl("/zuanshi/vie/addcustom",array("nick"=>$query["nick"]));?>"><span class="label label-default">新增竞品</span></a>
                            <a href="<?php echo $this->createUrl("/zuanshi/vie/index",array("nick"=>$query["nick"]));?>"><span class="label label-info">竞品列表</span></a>
                            <a href="<?php echo $this->createUrl("/zuanshi/vie/trash",array("nick"=>$query["nick"]));?>"><span class="label label-default">回收站</span></a>
                        </small>
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

        <div class="row" style="margin:15px;">
            <?php $useArr = array(""=>"全部","-1"=>"未使用","1"=>"已使用");?>
            <form id="shop-vie-search-form" action="<?php echo $this->createUrl("/zuanshi/vie/index");?>" method="post" class="form-inline">

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


                        <?php if(empty($list)):?>
                            <div class="baby-frame-cont">
                                <p>暂无竞品店铺！</p>
                            </div>
                        <?php else:?>
                            <form id="shop-vie-form">
        <table class="baby-frame-table">
            <thead>
                <tr>
                    <td><small><a class="select-all" href="javascript:void(0)">全选</a>/<a class="not-select-all" href="javascript:void(0)">全不选</a>/<a class="re-select-all" href="javascript:void(0)">反选</a></small></td>
                    <td><small>店铺名</small></td>
                    <td><a href="<?php echo $this->createUrl("/zuanshi/vie/index",array("nick"=>$query["nick"],"orderby"=>"cnt"));?>"><small>月销量<?php if($query["orderby"] == "cnt"):?><span class="caret"></span><?php endif;?></small></a></td>
                    <td><small>搜索关键词</small></td>
                    <td><a href="<?php echo $this->createUrl("/zuanshi/vie/index",array("nick"=>$query["nick"],"orderby"=>"log_date"));?>"><small>记录日期<?php if($query["orderby"] == "log_date"):?><span class="caret"></span><?php endif;?></small></a></td>
                    <td><small>是否使用</small></td>

                </tr>

            </thead>
            <tbody>

                            <?php foreach($list as $row):?>
                                <tr data-list="shops">
                                    <td>
                                        <input class="shiftCheckbox"  type="checkbox" name="ids[]" value="<?php echo $row["id"];?>" />
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
                                    <?php if($row["is_use"]>0):?>
                                        已使用<small>(<?php echo $row["campaignid"];?>)</small>
                                    <?php else:?>
                                        未使用
                                    <?php endif;?>
                                    </td>


                                </tr>

                            <?php endforeach;?>
            </tbody>
            </table>

                            <div style="height: 60px"></div>
                            <div style="position: fixed;bottom: 0px;width: 100%;background: white; height: 100px;line-height: 100px;">
                                <div class="row">
                                    <div class="col-md-3">
                                        <small><a class="select-all" href="javascript:void(0)">全选</a>/<a class="not-select-all" href="javascript:void(0)">全不选</a>/<a class="re-select-all" href="javascript:void(0)">反选</a></small>
                                    </div>

                                    <div class="col-md-9">
                                        <button type="button" class="btn btn-primary" data-click="shopbtn">移入回收站</button>
                                    </div>

                                </div>
                            </div>
                            </form>
                        <?php endif;?>

    </div>
</div>

    <script type="application/javascript">


        $(document).ready(function(){

            $(".top-ul>li").eq(1).addClass("top-li-hover");

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


            $("#searchBtn").click(function(){
                $(this).parents("form").submit();
            });

            $("button[data-click=shopbtn]").click(function(event){
                var form = $(this).parents("#shop-vie-form");
                app.confirm('是否确定要移入回收站!',function() {
                    $.ajax({
                        url: "<?php echo $this->createUrl('/zuanshi/vie/del');?>",
                        type: "post",
                        data: form.serialize(),
                        dataType: "json",
                        success: function (resp) {
                            $("body").hideLoading();
                            if (resp.isSuccess) {
                                location.reload();
                            }
                        },
                        beforeSend: function () {
                            $("body").showLoading();
                        },
                        error: function () {
                            $("body").hideLoading();
                        }
                    });
                });
            });


            $(".select-all").click(function(){
                $("[data-list=shops] .shiftCheckbox").each(function () {
                    this.checked = true;
                });

            });

            $(".not-select-all").click(function(){
                $("[data-list=shops] .shiftCheckbox").each(function () {
                    this.checked = false;
                });

            });
            $(".re-select-all").click(function(){
                $("[data-list=shops] .shiftCheckbox").each(function () {
                    if(this.checked)
                        this.checked = false;
                    else
                        this.checked = true;
                });

            });

            $('[data-list=shops] .shiftCheckbox').shiftcheckbox();



        });
    </script>

