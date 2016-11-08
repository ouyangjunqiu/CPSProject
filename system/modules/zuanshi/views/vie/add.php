<link rel="stylesheet" href="<?php echo STATICURL.'/main/css/index.css'; ?>">
<div class="index-table-div">

    <div class="search-box">
        <div class="shop-list-cont">
            <div class="row">
                <div class="col-md-12">
                    <div class="com-list-tit" style="display: block;">
                        <span class="shop-list-icon"></span>
                        <span class="shop-list-txt"><?php echo $query["nick"];?></span>
                        <small>
                            <a href="<?php echo $this->createUrl("/zuanshi/vie/addcustom",array("nick"=>$query["nick"]));?>"><span class="label label-info">新增竞品</span></a>
                            <a href="<?php echo $this->createUrl("/zuanshi/vie/index",array("nick"=>$query["nick"]));?>"><span class="label label-default">竞品列表</span></a>
                            <a href="<?php echo $this->createUrl("/zuanshi/vie/trash",array("nick"=>$query["nick"]));?>"><span class="label label-default">回收站</span></a>
                        </small>

                    </div>
                </div>

            </div>
        </div>
        <form id="shop-vie-form" action="<?php echo $this->createUrl("/zuanshi/vie/add");?>" method="post">
            <input type="hidden" name="nick" value="<?php echo $query["nick"];?>"/>
            <input type="hidden" name="src" value="手工录入"/>
            <input type="hidden" name="shops" value=""/>
            <table class="table-frame">
                <tbody id="babyInforTb">
                <tr><td>宝贝标题：</td><td> <input type="text" class="form-control" name="keyword" /></td><td><span style="color: red">* 宝贝的标题或者关键字</span></td></tr>
                <tr><td>竞品店铺：</td><td> <textarea cols="100" rows="20" id="shops-area-control"></textarea></td><td><span style="color: red">* 竞品店铺名称</span></td></tr>
                <tr><td><button type="button" class="btn btn-primary" data-click="shopbtn">保存</button></td><td></td><td></td></tr>
                </tbody>
            </table>
        </form>
    </div>

</div>

<script type="text/javascript">

    $(document).ready(function() {

        $(".top-ul>li").eq(1).addClass("top-li-hover");

        var s = function(){
            var a = $("#shops-area-control").val().split("\n");
            var shops = [];
            $.each(a,function(){
                shops.push({shopnick:this,cnt:0});
            });

            $("#shop-vie-form input[name=shops]").val(JSON.stringify(shops));
        };

        $("#shops-area-control").change(function(){
           s();
        });


        $("button[data-click=shopbtn]").click(function(){
            s();
            var form = $("#shop-vie-form");
            $.ajax({
                url:form.attr("action"),
                type:"post",
                data:form.serialize(),
                dataType:"json",
                success:function(resp){
                    $("body").hideLoading();
                    if(resp.isSuccess) {
                        app.confirm('添加成功,是否继续添加竞品店铺!',function(){window.location.reload()},function(){
                            window.location.href = '<?php echo $this->createUrl("/zuanshi/vie/index",array("nick"=>$query["nick"]));?>';
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