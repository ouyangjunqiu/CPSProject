
<form id="shop-search-form" action="<?php echo $url;?>" method="get" class="form-inline">
    <div class="input-group">
        <a href="javascript:void(0)" data-click="my-shop" data-user="<?php echo $user["username"];?>">

            <?php if(!empty($query["pic"]) && $query["pic"] == $user["username"]):?>
                <span class="label label-warning"><i class="glyphicon glyphicon-star" aria-hidden="true">取消展示我的</i>
            <?php else:?>
                <span class="label label-default"><i class="glyphicon glyphicon-star-empty" aria-hidden="true">仅展示我的</i>
                </span>
            <?php endif;?>
        </a>
    </div>
    <div class="input-group">



        <span class="input-group-addon">
            <i class="fa fa-search"></i>
        </span>
        <input type="text" name="q" class="form-control" placeholder="关键字搜索" value="<?php echo CHtml::encode($query["q"]);?>">
    </div>
</form>

<script type="text/javascript">

    $(document).ready(function(){
        $("#shop-search-form").keydown(function(event){
            if(event.which == 13){
                $("#shop-search-form .fa-search").trigger("click");
                return false;
            }
        });

        $("#shop-search-form .fa-search").click(function(){
            var form = $(this).parents("#shop-search-form");
            var data = {};
            data.q = form.find("input[name=q]").val();
            location.href = app.url(form.attr("action"),data);
        });

        $("#shop-search-form [data-click=my-shop]").click(function(){
            var form = $(this).parents("#shop-search-form");
            var self = $(this);
            var data = {};
            if(self.find(".glyphicon-star-empty").size()>0){
                data.pic = self.data("user");
            }else{
                data.pic = "";
            }
            location.href = app.url(form.attr("action"),data);
        });
    })
</script>