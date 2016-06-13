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


    <div class="row" style="margin-top: 10px;margin-bottom: 10px;" data-role="shop-todo-list" data-nick="<?php echo $query["nick"];?>">
            <div class="col-md-1">
                <a class="left carousel-control" style="color: #337ab7;" href="<?php echo $this->createUrl("/main/todo/more",array("nick"=>$query["nick"],"logdate"=>date("Y-m-d",strtotime("-5 days",strtotime($query["logdate"])))));?>" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
            </div>
            <?php foreach($list as $g):?>
            <div class="col-md-2">
                <div class="list-group">
                    <?php if ($g["logdate"] == date("Y.m.d")):?>
                    <a class="list-group-item active">
                        <?php echo ($g["logdate"] == date("Y.m.d"))?"今日":$g["logdate"];?>
                    </a>
                    <?php else:?>
                        <a class="list-group-item disabled">
                            <?php echo ($g["logdate"] == date("Y.m.d"))?"今日":$g["logdate"];?>
                        </a>
                    <?php endif;?>

                    <?php if(isset($g["list"])):?>
                        <?php foreach($g["list"] as $todo):?>
                            <?php if($todo["status"] == 0):?>
                            <a data-id="<?php echo $todo["id"];?>" data-toggle="modal" data-target="#ShopTodoOpModal" data-backdrop="false" class="list-group-item" data-content="<?php echo $todo["content"];?>">
                                <small>[<?php echo $todo["priority"];?>]</small><?php echo $todo["title"];?> <?php if(!empty($todo["pic"])):?><small>@<?php echo $todo["pic"];?></small><?php endif;?>
                            </a>
                            <?php else:?>
                                <a data-id="<?php echo $todo["id"];?>" data-toggle="modal" data-target="#ShopTodoViewModal" data-backdrop="false" class="list-group-item list-group-item-success" data-content="<?php echo $todo["content"];?>">
                                    <small>[<?php echo $todo["priority"];?>]</small><?php echo $todo["title"];?> <?php if(!empty($todo["pic"])):?><small>@<?php echo $todo["pic"];?></small><?php endif;?>
                                </a>
                            <?php endif;?>
                        <?php endforeach;?>
                    <?php endif;?>
                </div>
            </div>
            <?php endforeach;?>

            <div class="col-md-1">
                <a class="right carousel-control" style="color: #337ab7;" href="<?php echo $this->createUrl("/main/todo/more",array("nick"=>$query["nick"],"logdate"=>date("Y-m-d",strtotime("+5 days",strtotime($query["logdate"])))));?>" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
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

            var t = $("#plan-fixed-header").offset().top+$("#plan-fixed-header").height();
            $(window).scroll(function(event){

                var top = $(window).scrollTop();
                if(top>t){
                    $("#plan-fixed-header").addClass("header-fixed");
                }else{
                    $("#plan-fixed-header").removeClass("header-fixed");
                }
            });

        });
    </script>

