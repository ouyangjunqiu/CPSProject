<script src='<?php echo STATICURL."/main/js/shop.js"; ?>'></script>

<link rel="stylesheet" href="<?php echo STATICURL.'/base/css/index.css'; ?>">
<link rel="stylesheet" href="<?php echo STATICURL.'/main/css/index.css'; ?>">

<div class="index-table-div">

    <div class="search-box">
        <div class="shop-list-cont" id="shop-search">
            <div class="search-log" style="display: none;"> </div>
            <div class="search-left com-list-tit" style="display: block;">
                <span class="shop-list-icon"></span>
                <span class="shop-list-txt">我的店铺</span>
                <small>
                    <a href="<?php echo $this->createUrl("/main/shop/index");?>"><span class="label label-default">新增店铺</span></a>
                    <a href="<?php echo $this->createUrl("/main/default/index");?>"><span class="label label-info">我的店铺</span></a>
                    <a href="<?php echo $this->createUrl("/main/default/stoplist");?>"><span class="label label-default">流失店铺</span></a>
                    <a href="<?php echo $this->createUrl("/main/dashboard/index");?>"><span class="label label-default">总览</span></a>

                </small>
            </div>
            <div class="search-right">
                <?php $this->widget("application\\modules\\main\\widgets\\ShopSearchWidget",array("url"=>$this->createUrl("/main/default/index",array("page"=>1)),"query"=>$query));?>

            </div>
        </div>
    </div>
    <table class="table-frame">
        <tbody id="babyInforTb">
        <?php $i=1;?>
        <?php foreach($list as $row):?>
            <tr <?php if($i%2==0):?>class="stop-tr"<?php endif;?>>
                <?php $i++;?>
                <td class="babyInforTb-td-left">
                    <?php $this->widget("application\\modules\\main\\widgets\\ShopManagerWidget",array("shop"=>$row));?>
                </td>
                <td class="check-infor-td">
                    <div class="baby-box" data-role="shop-plan-case-list">
                        <div class="baby-trusteeship baby-frame-box">

                            <div class="row">
                                    <div class="col-md-2">
                                        <h3 class="baby-frame-h3">
                                            <i class="tit-frame-icon"></i>
                                            待办事项
                                        </h3>
                                    </div>
                                    <div class="col-md-9">

                                        <?php $this->widget("application\\modules\\main\\widgets\\ShopPlanWidget",array("nick"=>$row["nick"]));?>
                                    </div>
                                    <div class="col-md-1">
                                        <a href="<?php echo $this->createUrl("/main/todo/more",array("nick"=>$row["nick"]));?>"><small>更多..</small></a>
                                    </div>
                                </div>
                            <div class="overlay-wrapper" data-load="overlay" data-tmpl="shop-todo-list-tmpl" data-role="shop-todo-list" data-nick="<?php echo $row["nick"];?>" data-url="<?php echo $this->createUrl("/main/todo/getbynick",array("nick"=>$row["nick"]));?>">

                            </div>

                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
    <div class="c-pager">
    </div>
</div>

<?php $this->widget("application\\modules\\main\\widgets\\ShopTodoWidget");?>


<script type="application/javascript">

    $(document).ready(function(){

        $(".top-ul>li").eq(0).addClass("top-li-hover");


        $(".c-pager").jPager({currentPage: <?php echo $pager["page"]-1;?>, total: <?php echo $pager["count"];?>, pageSize: <?php echo $pager["page_size"];?>,events: function(dp){
            location.href = app.url("<?php echo $this->createUrl('/main/default/index');?>",{page:dp.index+1})
        }});

        $("tr.case-editor").delegate(".case-editor-btn","click",function(event){
            $(event.delegateTarget).find("[data-reader=case]").hide();
            $(event.delegateTarget).find("[data-editor=case]").show();
        });

        $("tr.case-editor").delegate(".case-cancel-btn","click",function(event){
            location.reload();
        });

        $("tr.case-editor").delegate(".case-save-btn","click",function(event){
            var caseid = $(this).attr("data-case-id");
            var budget = $(event.delegateTarget).find("input[name=budget]").val();
            var casetype = $(event.delegateTarget).find("select[name=casetype]").val();

            $.ajax({
                url:"<?php echo $this->createUrl('/main/case/modify');?>",
                type:"post",
                data:{id:caseid,budget:budget,casetype:casetype},
                dataType:"json",
                success:function(resp){
                    $("body").hideLoading();
                    if(resp.isSuccess) {
                        location.reload();
                    }
                },
                beforeSend:function(){
                    $("body").showLoading();
                },
                error:function(){
                    app.alert("操作失败，请确认网络连接是否正常后请重试!");
                    $("body").hideLoading();
                }
            });
        });

        $("tr.case-editor").delegate(".case-del-btn","click",function(event){
            var caseid = $(this).attr("data-case-id");
            app.confirm('是否确定要删除!',function() {
                $.ajax({
                    url: "<?php echo $this->createUrl('/main/case/delete');?>",
                    type: "post",
                    data: {id: caseid},
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
                        app.error("操作失败，请确认网络连接是否正常后请重试!");
                        $("body").hideLoading();
                    }
                });
            });
        });




    });


</script>

