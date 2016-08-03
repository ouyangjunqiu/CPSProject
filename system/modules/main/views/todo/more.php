<link rel="stylesheet" href="<?php echo STATICURL.'/base/css/index.css'; ?>">
<link rel="stylesheet" href="<?php echo STATICURL.'/main/css/index.css'; ?>">
<div class="index-table-div">

    <div class="search-box">
        <div class="shop-list-cont" id="plan-fixed-header">
            <div class="row">
                <div class="col-md-4">
                    <div class="com-list-tit" style="display: block;">
                        <span class="shop-list-icon"></span>
                        <span class="shop-list-txt"><?php echo $query["nick"];?></span>
                    </div>
                </div>
                <div class="col-md-7">
                </div>


                <div class="col-md-1">
                    <input type="button" class="btn btn-default" value="返回" id="searchBtn">
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 10px;margin-bottom: 10px;">
        <div class="col-md-11">
            <form class="form-inline">
                <div class="form-group">
                    <small>筛选:</small>
                    <div class="input-group" id="dateSetting">
                        <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                        <input type="text" class="form-control"  value="<?php echo $query['beginDate'];?> ~ <?php echo $query['endDate'];?>">
                        <span class="input-group-addon"><b class="caret"></b></span>
                    </div>
                </div>

            </form>
        </div>

        <div class="col-md-1">
        </div>
    </div>

    <div class="row" style="margin-top: 10px;margin-bottom: 10px;" data-role="shop-todo-list" data-nick="<?php echo $query["nick"];?>">
        <div class="list-group">
            <a class="list-group-item active">
                待办事项
            </a>
            <?php foreach($list as $todo):?>

                <?php if($todo["status"] == 0):?>
                    <a data-id="<?php echo $todo["id"];?>" data-toggle="modal" data-target="#ShopTodoOpModal" data-backdrop="false" class="list-group-item" data-content="<?php echo $todo["content"];?>">
                        <small>[<?php echo $todo["priority"];?>] <?php echo $todo["creator"];?>说:</small><?php echo $todo["title"];?> <?php if(!empty($todo["pic"])):?><small>@<?php echo $todo["pic"];?></small><?php endif;?>
                        <?php if($todo["days"]<0):?>
                            <span class="badge label label-danger"><i class="fa fa-clock-o"></i> <?php echo $todo["days"];?> days</span>
                        <?php elseif($todo["days"] == 0):?>
                            <span class="badge label label-danger"><i class="fa fa-clock-o"></i> 今日</span>
                        <?php else:?>
                            <span class="badge label label-info"><i class="fa fa-clock-o"></i> <?php echo $todo["days"];?> days</span>
                        <?php endif;?>
                    </a>
                <?php else:?>
                    <a data-id="<?php echo $todo["id"];?>" data-toggle="modal" data-target="#ShopTodoViewModal" data-backdrop="false" class="list-group-item list-group-item-success" data-content="<?php echo $todo["content"];?>">
                        <small>[<?php echo $todo["priority"];?>]  <?php echo $todo["creator"];?>说:</small><?php echo $todo["title"];?> <?php if(!empty($todo["pic"])):?><small>@<?php echo $todo["pic"];?></small><?php endif;?>
                        <?php if($todo["days"]  == 0):?>
                            <span class="badge label label-success"><i class="fa fa-clock-o"></i> 今日</span>
                        <?php else:?>
                            <span class="badge label label-success"><i class="fa fa-clock-o"></i> <?php echo $todo["days"];?> days</span>
                        <?php endif;?>
                    </a>
                <?php endif;?>
            <?php endforeach;?>
        </div>

    </div>
</div>
<?php $this->widget("application\\modules\\main\\widgets\\ShopTodoWidget");?>
    <script type="application/javascript">


        $(document).ready(function(){

            $(".top-ul>li").eq(0).addClass("top-li-hover");

            $("#searchBtn").click(function(){
                window.location.href='<?php echo $this->createUrl("/main/default/index");?>';
            });

            $("#dateSetting").daterangepicker({
                "startDate": "<?php echo $query['beginDate'];?>",
                "endDate": "<?php echo $query['endDate'];?>",
                "format":"YYYY-MM-DD"
            },function (start,end){

                location.href = app.url("<?php echo $this->createUrl('/main/todo/more');?>",{
                    nick:'<?php echo $query["nick"];?>',
                    begin_date:start.format('YYYY-MM-DD'),
                    end_date:end.format('YYYY-MM-DD')
                })

            });


//            var t = $("#plan-fixed-header").offset().top+$("#plan-fixed-header").height();
//            $(window).scroll(function(event){
//
//                var top = $(window).scrollTop();
//                if(top>t){
//                    $("#plan-fixed-header").addClass("header-fixed");
//                }else{
//                    $("#plan-fixed-header").removeClass("header-fixed");
//                }
//            });

        });
    </script>

