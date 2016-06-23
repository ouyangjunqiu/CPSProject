<link rel="stylesheet" href="<?php echo STATICURL.'/base/css/index.css'; ?>">
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

                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 10px;margin-bottom: 10px">


        </div>


        <?php if(empty($list)):?>
            <div class="baby-frame-cont">
                <p>暂无人群标签！</p>
            </div>
        <?php else:?>
            <form id="shop-selector-form">
                <input type="hidden" name="nick" value="<?php echo $query["nick"];?>"/>
                <table class="baby-frame-table">
                    <thead>
                    <tr>
                        <td><small><a class="select-all" href="javascript:void(0)">全选</a>/<a class="not-select-all" href="javascript:void(0)">全不选</a>/<a class="re-select-all" href="javascript:void(0)">反选</a></small></td>
                        <td><small>人群标签</small></td>
                        <td><small>更新时间</small></td>
                    </tr>

                    </thead>
                    <tbody>

                    <?php foreach($list as $row):?>
                        <tr data-list="shops">
                            <td>
                                <input class="shiftCheckbox" type="checkbox" name="dmps[]" value="<?php echo $row["dmpCrowdId"];?>,<?php echo $row["dmpCrowdName"];?>" <?php if(isset($row["isSelect"]) && $row["isSelect"]):?>checked="checked"<?php endif;?> />
                            </td>
                            <td><strong><?php echo $row["dmpCrowdName"];?></strong></td>
                            <td>
                                <?php echo $row["updateTime"];?>
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
                        <o class="glyphicon glyphicon-hand-right"></o>下一步，请登录钻展后台，使用精准平台小助手的"批量低价推广"功能完成后续推广操作！
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


        $("#backBtn").click(function(){
            window.location.href='<?php echo $this->createUrl("/zuanshi/setting/adzone",array("nick"=>$query["nick"]));?>';
        });
        

        var selectFn  = function(){
            var selectCount = 0;
            $("[data-list=shops] .shiftCheckbox").each(function(){
                if(this.checked){
                    selectCount++;
                }

            });

            $("button[data-click=shopbtn]").html("已选择("+selectCount+"),设置完成");
        };

        selectFn();

        $("button[data-click=shopbtn]").click(function(){
            var form = $("#shop-selector-form");
            $.ajax({
                url:"<?php echo $this->createUrl('/zuanshi/setting/binddmp');?>",
                type:"post",
                data:form.serialize(),
                dataType:"json",
                success:function(resp){
                    $("body").hideLoading();
                    if(resp.isSuccess) {
                        app.alert('设置成功,请登录钻石展位后台,请使用精准平台小助手的批量低价推广按钮!');
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

