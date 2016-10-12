
<form id="shop-search-form" action="<?php echo $url;?>" method="get" class="form-inline">

    <div class="input-group">
        <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="border-color: white">
                <small class="glyphicon glyphicon-filter" style="color: #428bca"></small>
                <small><?php echo empty($query["pic"])?"所有":"@".$query["pic"];?></small>
                <small class="caret"></small>
            </button>
            <ul class="dropdown-menu" role="menu">
                <?php if(!empty($query["pic"])):?>
                    <li><a href="<?php echo $url."&page=1&pic=";?>">所有</a></li>
                <?php else:?>
                    <li><a href="<?php echo $url."&page=1&pic=".$user["username"];?>">@<?php echo $user["username"];?></a></li>
                <?php endif;?>
            </ul>
        </div>
    </div>
    <div class="input-group">

        <span class="input-group-addon">
            <i class="glyphicon glyphicon-search"></i>
        </span>
        <input type="text" name="q" class="form-control" placeholder="关键字搜索" value="<?php echo CHtml::encode($query["q"]);?>">
    </div>
</form>

<script type="text/javascript">

    $(document).ready(function(){
        $("#shop-search-form").keydown(function(event){
            if(event.which == 13){
                $("#shop-search-form .glyphicon-search").trigger("click");
                return false;
            }
        });

        $("#shop-search-form .glyphicon-search").click(function(){
            var form = $(this).parents("#shop-search-form");
            var data = {};
            data.q = form.find("input[name=q]").val();
            location.href = app.url(form.attr("action"),data);
        });

    })
</script>