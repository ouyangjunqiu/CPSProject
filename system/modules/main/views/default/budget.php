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
                        <small>(CASE报表)</small>
                    </div>
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-3">

                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-1">
                    <input type="button" class="btn btn-default" value="返回" id="searchBtn">
                </div>
            </div>
        </div>
    </div>
    <div style="padding: 15px">
        <?php echo $editor_view;?>
    </div>
    <div style="padding: 15px">
        <p style="margin-bottom: 15px"><small>历史记录>>></small></p>
        <?php echo $history_view;?>
    </div>

</div>

<script type="text/javascript">
    $(document).ready(function(){

        $(".top-ul>li").eq(0).addClass("top-li-hover");

        $("#searchBtn").click(function(){
            window.location.href='<?php echo $this->createUrl("/main/default/index");?>';
        });


        $(".row[editor=run]").delegate("input[name=cost]","change",function(event){
            var cost = parseInt($(this).val().replace(/,/g,""))/7;
            var roi = $(event.delegateTarget).find("input[name=roi]").val();
            var id = $(event.delegateTarget).attr("data-rpt-id");

            $.ajax({
                url:"<?php echo $this->createUrl('/main/caserunrpt/modify');?>",
                type:"post",
                data:{id:id,cost:cost,roi:roi},
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
                    alert("保存失败，请重试!");
                    $("body").hideLoading();
                }
            });
        });

        $(".row[editor=run]").delegate("input[name=roi]","change",function(event){
            var roi = $(this).val();
            var cost = $(event.delegateTarget).find("input[name=cost]").val().replace(/,/g,"");
            var id = $(event.delegateTarget).attr("data-rpt-id");

            cost = parseInt(cost)/7;

            $.ajax({
                url:"<?php echo $this->createUrl('/main/caserunrpt/modify');?>",
                type:"post",
                data:{id:id,cost:cost,roi:roi},
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
                    alert("保存失败，请重试!");
                    $("body").hideLoading();
                }
            });
        });

        $("input[name=budget]").change(function(){
            var runid = $(this).attr("data-run-id");
            var budget = $(this).val();

            $.ajax({
                url:"<?php echo $this->createUrl('/main/caserun/modify');?>",
                type:"post",
                data:{runid:runid,budget:budget},
                dataType:"json",
                success:function(resp){
                    $("body").hideLoading();
                    if(resp.isSuccess) {

                    }
                },
                beforeSend:function(){
                    $("body").showLoading();
                },
                error:function(){
                    alert("保存失败，请重试!");
                    $("body").hideLoading();
                }
            });
        });

        $("textarea[name=remark]").change(function(){
            var runid = $(this).attr("data-run-id");
            var remark = $(this).val();

            $.ajax({
                url:"<?php echo $this->createUrl('/main/caserun/modify');?>",
                type:"post",
                data:{runid:runid,remark:remark},
                dataType:"json",
                success:function(resp){
                    $("body").hideLoading();
                    if(resp.isSuccess) {

                    }
                },
                beforeSend:function(){
                    $("body").showLoading();
                },
                error:function(){
                    alert("保存失败，请重试!");
                    $("body").hideLoading();
                }
            });
        });

    });
</script>
