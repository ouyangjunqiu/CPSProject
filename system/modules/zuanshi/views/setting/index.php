<link rel="stylesheet" href="<?php echo STATICURL.'/base/css/index.css'; ?>">
<link rel="stylesheet" href="<?php echo STATICURL.'/main/css/index.css'; ?>">

<div class="index-table-div">
    <div class="shop-list-cont">
        <div class="row">
            <div class="col-md-4">
                <div class="com-list-tit" style="display: block;">
                    <span class="shop-list-icon"></span>
                    <span class="shop-list-txt">低价推广设置</span>
                </div>
            </div>
            <div class="col-md-2">
            </div>
            <div class="col-md-3">

            </div>
            <div class="col-md-2">
            </div>
            <div class="col-md-1">
                <input type="button" class="btn-orange" value="返回" id="searchBtn">
            </div>
        </div>
    </div>

    <form>
        <table class="table-frame">
            <tbody id="babyInforTb">
            <tr><td>店铺名：</td><td> <input type="text" class="form-control" name="nick" value="<?php echo $query["nick"];?>"></td><td></td></tr>
            <tr><td>计划编号：</td><td> <input type="text" class="form-control" name="campaignid" value="<?php echo empty($setting["campaignid"])?"":$setting["campaignid"];?>"></td><td></td></tr>
            <tr><td>展位1：</td><td> <input type="text" class="form-control" name="adzone[]" value="<?php echo empty($setting["adzone"][0])?"":implode(",",$setting["adzone"][0]);?>"></td><td>格式：展位编号,展位类型,展位出价</td></tr>
            <tr><td>展位2：</td><td> <input type="text" class="form-control" name="adzone[]" value="<?php echo empty($setting["adzone"][1])?"":implode(",",$setting["adzone"][1]);?>"></td><td></td></tr>
            <tr><td>展位3：</td><td> <input type="text" class="form-control" name="adzone[]" value="<?php echo empty($setting["adzone"][2])?"":implode(",",$setting["adzone"][2]);?>"></td><td></td></tr>
            <tr><td>展位4:</td><td> <input type="text" class="form-control" name="adzone[]" value="<?php echo empty($setting["adzone"][3])?"":implode(",",$setting["adzone"][3]);?>"></td><td></td></tr>
            <tr><td>创意编号:</td><td> <input type="text" class="form-control" name="creatives" value="<?php echo empty($setting["creatives"])?"":$setting["creatives"];?>"></td><td>格式：创意编号1,创意编号2,创意编号3</td></tr>
            <tr><td><button type="button" class="btn btn-primary" data-click="shopbtn">保存</button></td><td></td><td></td></tr>
            </tbody>
        </table>
    </form>
</div>

<script type="text/javascript">

    $(document).ready(function() {

        $(".top-ul>li").eq(1).addClass("top-li-hover");

        $("#searchBtn").click(function () {
            window.location.href = '<?php echo $this->createUrl("/main/default/index");?>';
        });
        $("button[data-click=shopbtn]").click(function(){
            var form = $(this).parents("form");
            $.ajax({
                url:"<?php echo $this->createUrl('/zuanshi/setting/update');?>",
                type:"post",
                data:form.serialize(),
                dataType:"json",
                success:function(resp){
                    $("body").hideLoading();
                    if(resp.isSuccess) {
                        $.dialog({title:"提示", lock: true,content:'设置成功,下一步设置竞品店铺!',ok:function(){
                            window.location.href = '<?php echo $this->createUrl("/zuanshi/setting/vie",array("nick"=>$query["nick"]));?>';
                        },cancel:function(){
                            window.location.reload()
                        }});
                    }else{
                        $.dialog({title:"提示", lock: true,content:'添加失败',ok:true});
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
    })
</script>