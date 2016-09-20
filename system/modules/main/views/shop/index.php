<link rel="stylesheet" href="<?php echo STATICURL.'/main/css/index.css'; ?>">
<div class="index-table-div">

    <div class="search-box">
        <div class="shop-list-cont">
            <div class="row">
                <div class="col-md-4">
                    <div class="com-list-tit" style="display: block;">
                        <span class="shop-list-icon"></span>
                        <span class="shop-list-txt">我的店铺</span>
                        <small>
                            <a href="<?php echo $this->createUrl("/main/shop/index");?>"><span class="label label-info">新增店铺</span></a>
                            <a href="<?php echo $this->createUrl("/main/default/index");?>"><span class="label label-default">我的店铺</span></a>
                            <a href="<?php echo $this->createUrl("/main/default/stoplist");?>"><span class="label label-default">流失店铺</span></a>
<!--                            <a href="--><?php //echo $this->createUrl("/main/case/index");?><!--"><span class="label label-default">CASE列表</span></a>-->
                            <a href="<?php echo $this->createUrl("/main/dashboard/index");?>"><span class="label label-default">总览</span></a>

                        </small>

                    </div>
                </div>
                <div class="col-md-7">
                </div>
                <div class="col-md-1">
                    <input type="button" class="btn btn-default" value="返回" id="searchBtn">
                </div>
            </div>
        </div>
        <form>
            <table class="table-frame">
                <tbody id="babyInforTb">
                    <tr><td>卖家昵称：</td><td> <input type="text" class="form-control" name="nick"></td><td><span style="color: red">* 淘宝卖家的登录主账户名称(也称旺旺名)</span></td></tr>
                    <tr><td>店铺名：</td><td> <input type="text" class="form-control" name="shopname"></td><td><span style="color: red">* 淘宝卖家的店铺名称</span></td></tr>
                    <tr><td>店铺地址：</td><td> <input type="text" class="form-control" name="shopurl"></td><td></td></tr>
                    <tr><td>淘宝登录账户：</td><td> <input type="text" class="form-control" name="login_nick"></td><td></td></tr>
                    <tr><td>淘宝登录密码：</td><td> <input type="text" class="form-control" name="login_password"></td><td></td></tr>
                    <tr><td>运营顾问：</td><td> <input type="text" class="form-control" name="pic"></td><td></td></tr>
                    <tr><td>智钻顾问:</td><td> <input type="text" class="form-control" name="zuanshi_pic"></td><td></td></tr>
                    <tr><td>直通车顾问:</td><td> <input type="text" class="form-control" name="ztc_pic"></td><td></td></tr>
                    <tr><td>数据顾问:</td><td> <input type="text" class="form-control" name="bigdata_pic"></td><td></td></tr>
                    <tr><td>合作业务：</td><td>
                            <?php echo CHtml::dropDownList("shoptype","直钻业务",\application\modules\main\model\Shop::$saleTypes,array("class"=>"form-control"));?>
                          </td><td></td></tr>
<!--                    <tr><td>竞争店铺:</td><td> <input type="text" class="form-control" name="jingzheng"></td><td></td></tr>-->
                    <tr><td><button type="button" class="btn btn-primary" data-click="shopbtn">保存</button></td><td></td><td></td></tr>
                </tbody>
            </table>
        </form>
    </div>

</div>

<script type="text/javascript">

    $(document).ready(function() {

        $(".top-ul>li").eq(0).addClass("top-li-hover");

        $("#searchBtn").click(function () {
            window.location.href = '<?php echo $this->createUrl("/main/default/index");?>';
        });
        $("button[data-click=shopbtn]").click(function(){
            var form = $(this).parents("form");
            $.ajax({
                url:"<?php echo $this->createUrl('/main/shop/add');?>",
                type:"post",
                data:form.serialize(),
                dataType:"json",
                success:function(resp){
                    $("body").hideLoading();
                    if(resp.isSuccess) {
                        app.confirm('添加成功,是否继续添加店铺!',function(){window.location.reload()},function(){
                            window.location.href = '<?php echo $this->createUrl("/main/default/index");?>';
                        });
                    }else{
                        app.alert('添加失败');
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