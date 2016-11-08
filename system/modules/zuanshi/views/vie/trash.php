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
                <div class="col-md-12">
                    <div class="com-list-tit" style="display: block;">
                        <span class="shop-list-icon"></span>
                        <span class="shop-list-txt"><?php echo $query["nick"];?></span>
                        <small>
                            <a href="<?php echo $this->createUrl("/zuanshi/vie/addcustom",array("nick"=>$query["nick"]));?>"><span class="label label-default">新增竞品</span></a>
                            <a href="<?php echo $this->createUrl("/zuanshi/vie/index",array("nick"=>$query["nick"]));?>"><span class="label label-default">竞品列表</span></a>
                            <a href="<?php echo $this->createUrl("/zuanshi/vie/trash",array("nick"=>$query["nick"]));?>"><span class="label label-info">回收站</span></a>
                        </small>
                    </div>
                </div>

            </div>
        </div>


        <?php if(empty($list)):?>
            <div class="baby-frame-cont">
                <p>回收站已清空!</p>
            </div>
        <?php else:?>
            <form id="shop-vie-form">
                <table class="baby-frame-table">
                    <thead>
                    <tr>
                        <td><small><a class="select-all" href="javascript:void(0)">全选</a>/<a class="not-select-all" href="javascript:void(0)">全不选</a>/<a class="re-select-all" href="javascript:void(0)">反选</a></small></td>
                        <td><small>店铺名</small></td>
                        <td><small>月销量</small></td>
                        <td><small>搜索关键词</small></td>
                        <td><small>记录日期</small></td>
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
                        <div class="col-md-7">
                            <button type="button" class="btn btn-primary" data-click="shoprenewbtn">批量恢复</button>

                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-warning" data-click="shopdelbtn">清空回收站</button>
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

        $("#searchBtn").click(function(){
            $(this).parents("form").submit();
        });

        $("button[data-click=shoprenewbtn]").click(function(event){
            var form = $(this).parents("#shop-vie-form");
            app.confirm('是否确定要恢复使用!',function() {
                $.ajax({
                    url: "<?php echo $this->createUrl('/zuanshi/vie/renew');?>",
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

        $("button[data-click=shopdelbtn]").click(function(event){

            app.confirm('是否确定要清空回收站,该操作会彻底的删除竞品店铺!',function() {
                $.ajax({
                    url: "<?php echo $this->createUrl('/zuanshi/vie/clean');?>",
                    type: "post",
                    data:{nick:'<?php echo $query["nick"];?>'},
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

