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
                        <small>(<?php echo date("Y.m.d");?>)</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <small>昨天花费/ROI：</small>
                    <strong></strong>
                    <small> /</small>
                </div>

                <div class="col-md-2">
                    <small>预算：</small><span class="type"><span class="glyphicon glyphicon-yen"></span> <?php echo round($plan["budget"]);?></span>
                </div>
                <div class="col-md-2">
                    <input type="button" class="btn-orange" value="确认预算分配" id="searchBtn">
                </div>
        </div>
    </div>
    <table class="table-frame">
        <tbody id="babyInforTb">
        <?php foreach($cases as $row):?>
            <tr>
                <td class="check-infor-td">
                    <div class="baby-box">
                        <div class="baby-trusteeship baby-frame-box">
                            <div class="row">
                                <div class="col-md-4">
                                    <h3 class="baby-frame-h3">
                                        <i class="tit-frame-icon"></i>
                                        <?php echo $row["casetype"];?>
                                        <small>(<?php echo $row["luodiye"];?>)</small>
                                    </h3>
                                </div>

                                <div class="col-md-3">

                                    <small>昨天花费/ROI：</small>
                                    <strong><span class="type"><?php echo round($row["data"]["cost"]);?></span></strong>
                                    <small> / <span class="type"><?php echo round($row["data"]["pay"]);?></span></small>

                                </div>
                                <div class="col-md-3">
                                    <small>预算：</small><span class="type"> <span class="glyphicon glyphicon-yen"></span><?php echo round($row["budget"]);?></span>
                                </div>
                                <div class="col-md-2">
                                </div>
                            </div>
                            <div class="baby-frame-cont">
                                <?php if(!empty($row["run"])):?>
                                        <?php foreach($row["run"]["list"] as $dept=>$runs):?>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <span><?php echo $dept;?></span>
                                                </div>
                                                <div class="col-md-3">
                                                    <small>昨天花费/ROI：</small>
                                                    <span class="glyphicon glyphicon-yen"></span>  <?php echo round($row["run"]["total"][$dept]["cost"]);?>
                                                </div>
                                                <div class="col-md-2">
                                                    <small>预算：</small>
                                                    <span class="glyphicon glyphicon-yen"></span>  <?php echo round($row["run"]["total"][$dept]["budget"]);?>
                                                </div>
                                                <div class="col-md-2">
                                                </div>
                                            </div>
                                        <?php endforeach;?>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="ShopCaseRunAddModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">新增实施方案</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">需求编号:</label>
                        <input type="text" class="form-control" id="shopcase-id" name="caseid">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="control-label">推广渠道:</label>
                        <div class="input-group">
                            <select id="shopcase-runtype" name="runtype">
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="control-label">预算(元/天):</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="text" class="form-control" id="recipient-name" name="budget">
                            <span class="input-group-addon">元/天</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">方案:</label>
                        <div class="input-group">
                               <textarea class="form-control" name="remark"></textarea>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" id="shopcaserun-add-btn">保存</button>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">
    $('#ShopCaseRunAddModal').on('show.bs.modal', function (event) {
        var self = $(this);
        var button = $(event.relatedTarget); // Button that triggered the modal
        var caseid = button.data('caseid'); // Extract info from data-* attributes
        self.find("#shopcase-id").val(caseid);

        self.find("#shopcaserun-add-btn").unbind("click");
        self.find("#shopcaserun-add-btn").click(function(){
            var shopcase = self.find("form").serialize();
            $.ajax({
                url:"<?php echo $this->createUrl('/main/caserun/add');?>",
                type:"post",
                data:shopcase,
                dataType:"json",
                success:function(resp){
                    if(resp.isSuccess) {
                        self.modal('hide');
                        location.reload();
                    }
                }
            });

        })
    });

    $(".row[editor=run]").delegate("input","keypress",function(event){
        if(event.which == 13){
            var data = $(this).parent().parent().parent().parent().serialize();
            $.ajax({
                url:"<?php echo $this->createUrl('/main/caserun/data');?>",
                type:"post",
                data:data,
                dataType:"json",
                success:function(resp){
                    if(resp.isSuccess) {
                        location.reload();
                    }
                }
            });
        }
    });

    $(document).ready(function(){
        var self = $(this);
        self.find("#shopcase-runtype").select2({allowClear: true,width:400,placeholder: "请选择方案类型",data:[{id:"直通车",text:"直通车"},{id:"钻展",text:"钻展"}]});

        $("#searchBtn").click(function(){
            window.location.href='<?php echo $this->createUrl("/main/default/index");?>';
        })

        $(".row[editor=run]").dblclick(function(){
            $(".row[editor=run][status=editing]").parent().removeClass("case-run");
            $(".row[editor=run][status=editing]").parent().addClass("readonly");
            $(".row[editor=run][status=editing]").find("input").attr("readonly","readonly");

            $(this).attr("status","editing");
            $(this).find("input").removeAttr("readonly");
            $(this).parent().removeClass("readonly");
            $(this).parent().addClass("case-run");
        });

        $("#plan-roi-editor-form").keydown(function(event){
            if(event.which == 13){
                var data = $(this).serialize();
                $.ajax({
                    url:"<?php echo $this->createUrl('/main/plan/data');?>",
                    type:"post",
                    data:data,
                    dataType:"json",
                    success:function(resp){
                        if(resp.isSuccess) {
                            location.reload();
                        }
                    }
                });
            }
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

