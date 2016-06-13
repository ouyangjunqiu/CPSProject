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
                    <a href="<?php echo $this->createUrl("/main/default/index");?>"><span class="label label-info">合作中</span></a>
                    <a href="<?php echo $this->createUrl("/main/default/stoplist");?>"><span class="label label-default">暂停中</span></a>
                    <a href="<?php echo $this->createUrl("/main/dashboard/index");?>"><span class="label label-default">总览</span></a>

                </small>
            </div>
            <div class="search-right">
                <form id="shop-search-form" action="<?php echo $this->createUrl("/main/default/index2",array("page"=>1));?>" method="get" class="form-inline">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="店铺、负责人搜索" value="<?php echo CHtml::encode($query["q"]);?>">
                        <span class="input-group-addon">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <table class="table-frame">
        <tbody id="babyInforTb">
        <?php $i=1;?>
        <?php foreach($list as $row):?>
            <tr  <?php if($i%2==0):?>class="stop-tr"<?php endif;?>>
                <?php $i++;?>
                <td class="babyInforTb-td-left">
                    <?php $this->widget("application\\modules\\main\\widgets\\ShopManagerWidget",array("shop"=>$row));?>
                </td>
                <td class="check-infor-td">
                    <div class="baby-box" data-role="shop-plan-case-list">
                        <div class="baby-trusteeship baby-frame-box" data-nick="<?php echo $row["nick"];?>">

                            <div class="row">
                                <div class="col-md-4">
                                    <h3 class="baby-frame-h3">
                                        <i class="tit-frame-icon"></i>
                                        CASE列表
                                        <?php if($row["isSure"]):?><o class="tit">已确认</o><?php endif;?>
                                    </h3>
                                </div>
                                <div class="col-md-7">
                                    <p class="pic_read type">
                                        <small>直通车预算：</small>
                                        <?php echo empty($row["plan"]["ztc_budget"])?0:$row["plan"]["ztc_budget"];?>
                                        <small>钻展预算：</small>
                                        <?php echo empty($row["plan"]["zuanshi_budget"])?0:$row["plan"]["zuanshi_budget"];?>
                                        <span class="editor" style="display: none;"><i class="glyphicon glyphicon-pencil"></i></span>
                                    </p>
                                    <p class="pic_input" data-role="budget" style="display: none"  data-nick="<?php echo $row["nick"];?>">
                                        <small>预算：</small>
                                        <?php echo empty($row["plan"]["budget"])?0:$row["plan"]["budget"];?>
                                        <small>直通车预算：</small>
                                        <input type="text" value="<?php echo empty($row["plan"]["ztc_budget"])?0:$row["plan"]["ztc_budget"];?>" class="name_writer" name="plan_ztc_budget"/>
                                        <small>钻展预算：</small>
                                        <input type="text" value="<?php echo empty($row["plan"]["zuanshi_budget"])?0:$row["plan"]["zuanshi_budget"];?>" class="name_writer" name="plan_zuanshi_budget"/>
                                    </p>
                                </div>
                                <div class="col-md-1">
                                    <?php if(!empty($row["plan"])):?>

                                        <div class="btn-group">
                                            <a class="label label-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">操作
                                                <span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li><a  data-toggle="modal" data-target="#ShopCaseAddModal" data-backdrop="false" data-planid="<?php echo $row["plan"]["planid"];?>" data-nick="<?php echo $row["nick"];?>"><i class="glyphicon glyphicon-plus"></i> 新增CASE</a></li>
                                                <li role="separator" class="divider"></li>
                                                <li><a  href="<?php echo $this->createUrl('/main/caserun/index2',array("nick"=> $row["nick"]));?>" target="_blank"><i class="glyphicon glyphicon-list"></i> 推广方案<i style="font-size: 12px">&</i>预算分配</a></li>
                                                <li role="separator" class="divider"></li>
                                                <li><a href="<?php echo $this->createUrl('/main/default/budget',array("nick"=> $row["nick"]));?>" target="_blank"><i class="glyphicon glyphicon-edit"></i> CASE报表<i style="font-size: 12px">&</i>上周报表录入</a></li>
                                            </ul>
                                        </div>
                                    <?php endif;?>

                                </div>
                            </div>
                            <div class="baby-frame-cont">

                                <?php if(empty($row["plan"]["cases"])):?>

                                    <p>暂无店铺的CASE，赶紧创建一个吧！</p>
                                <?php else:?>
                                    <table class="baby-frame-table">
                                        <thead>
                                        <tr><td>CASE类型</td><td>落地页</td><td>预算(元/天)</td><td>上周花费(元/天)</td><td>上周直通车ROI</td><td>上周钻展ROI</td><td>操作</td></tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($row["plan"]["cases"] as $case):?>
                                            <tr data-case-id="<?php echo $case["id"];?>" class="case-editor <?php if($case["budget"]<=0):?>ns<?php endif;?>">
                                                <td>
                                                    <span class="type" data-reader="case">
                                                      <?php echo $case["casetype"];?>
                                                    </span>
                                                    <p data-editor="case" style="display: none">
                                                        <select name="casetype" class="js-example-basic-single">
                                                            <option value="<?php echo $case["casetype"];?>" selected="selected"><?php echo $case["casetype"];?></option>
                                                        </select>
                                                    </p>
                                                </td>
                                                <td><a href="<?php echo $case["luodiye"];?>" target="_blank">
                                                        <small>[<?php echo $case["luodiye_type"];?>]</small>

                                                        <?php echo !empty($case["luodiye_alias"])?$case["luodiye_alias"]:(strlen($case["luodiye"])>100?substr($case["luodiye"],0,100)."...":$case["luodiye"]);?></a>
                                                </td>
                                                <td>
                                                    <span class="bud-span" data-reader="case" > <?php echo round($case["budget"]);?></span>
                                                    <p data-editor="case" style="display: none">
                                                        <input type="text" value="<?php echo round($case["budget"]);?>" class="name_writer" name="budget"/>
                                                    </p>
                                                </td>
                                                <td>
                                                    <span class="bud-span"  > <?php echo round(@($case["rpt"]["直通车"]["cost"]+$case["rpt"]["钻展"]["cost"]));?></span>
                                                </td>
                                                <td>
                                                    <span class="bud-span"  > <?php echo round(@$case["rpt"]["直通车"]["roi"],2);?></span>
                                                </td>
                                                <td>
                                                    <span class="bud-span"  > <?php echo round(@$case["rpt"]["钻展"]["roi"],2);?></span>
                                                </td>
                                                <td>
                                                    <a class="case-editor-btn"  data-case-id="<?php echo $case["id"];?>" data-reader="case"><i class="glyphicon glyphicon-pencil"></i></a>
                                                    <a class="case-save-btn"  data-case-id="<?php echo $case["id"];?>" data-editor="case" style="display: none"><i class="glyphicon glyphicon-floppy-disk"></i></a>
                                                    <a class="case-cancel-btn"  data-case-id="<?php echo $case["id"];?>" data-editor="case" style="margin-left:15px;display: none"><i class="glyphicon glyphicon-floppy-remove"></i></a>
                                                    <a class="case-del-btn" data-case-id="<?php echo $case["id"];?>" data-reader="case"  style="margin-left:15px"><i class="glyphicon glyphicon-trash"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach;?>

                                        </tbody>
                                    </table>

                                    <div class="row" style="text-align: right"><a href="<?php echo $this->createUrl("/main/case/log",array("nick"=>$row["nick"]));?>"><small>CASE历史记录>>></small></a></div>
                                    <?php if(!$row["isSure"]):?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-danger" data-click="sure" data-nick="<?php echo $row["nick"];?>" data-url="<?php echo $this->createUrl('/main/case/sure');?>">确认完成</button>
                                            </div>
                                        </div>
                                    <?php endif;?>
                                <?php endif;?>
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

<div class="modal fade" id="ShopCaseAddModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">新增CASE</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">合作店铺:</label>
                        <input type="text" class="form-control"  name="nick" readonly="readonly">
                    </div>
                    <div class="form-group" style="display: none">
                        <label for="recipient-name" class="control-label">推广周期编号:</label>
                        <input type="text" class="form-control"  name="planid" readonly="readonly">
                    </div>
                    <div class="form-group" style="display: none">
                        <label for="recipient-name" class="control-label">CASE编号:</label>
                        <input type="text" class="form-control"  name="caseid"  readonly="readonly">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="control-label">CASE类型:</label>

                        <div class="input-group">
                            <select id="shopcase-casetype" name="casetype">
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">落地页类型:</label>
                        <div class="input-group">

                            <input type="radio" value="首页" checked="checked" name="luodiye_type" />首页

                            <input type="radio" value="活动页" name="luodiye_type" />活动页

                            <input type="radio" value="详情页" name="luodiye_type" checked="checked" /> 详情页

                            <input type="radio" value="其它" name="luodiye_type" /> 其它

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">落地页名称:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="luodiye_alias">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="control-label">落地页URL:</label>
                        <div class="input-group">
                            <span class="input-group-addon">http://</span>
                            <input type="text" class="form-control"  name="luodiye">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="control-label">CASE预算(元/天):</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="text" class="form-control"  name="budget">
                            <span class="input-group-addon">元/天</span>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" id="shopcase-add-btn">保存</button>
            </div>
        </div>
    </div>
</div>



<script type="application/javascript">

    $(document).ready(function(){

        $(".top-ul>li").eq(0).addClass("top-li-hover");


        $(this).find("select[name=casetype]").select2({allowClear: false,width:200,data:<?php echo $case_types;?>});

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

        $(".c-pager").jPager({currentPage: <?php echo $pager["page"]-1;?>, total: <?php echo $pager["count"];?>, pageSize: <?php echo $pager["page_size"];?>,events: function(dp){
            location.href = app.url("<?php echo $this->createUrl('/main/default/index');?>",{page:dp.index+1})
        }});

        $("div[data-role=shop-plan-case-list]").delegate("span.editor","click",function(event){
            $(event.delegateTarget).find(".pic_read").hide();
            $(event.delegateTarget).find(".pic_input").show();
            $(event.delegateTarget).find(".pic_input input[name=plan_budget]").focus();
        });

        $("p[data-role=budget]").bind("keydown",function(event){
            if(event.which == 13) {
                var nick = $(this).attr("data-nick");
                var ztc_budget = $(this).find("input[name=plan_ztc_budget]").val();
                var zuanshi_budget = $(this).find("input[name=plan_zuanshi_budget]").val();
                var budget = parseInt(ztc_budget) + parseInt(zuanshi_budget);
                $.ajax({
                    url: "<?php echo $this->createUrl('/main/plan/budgetset');?>",
                    type: "post",
                    data: {nick: nick, budget: budget, ztc_budget: ztc_budget, zuanshi_budget: zuanshi_budget},
                    dataType: "json",
                    success: function (resp) {
                        if (resp.isSuccess) {
                            location.reload();
                        }
                    }
                });
                return false;
            }

        });


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


        $('#ShopCaseAddModal').on('show.bs.modal', function (event) {
            var self = $(this);
            var button = $(event.relatedTarget); // Button that triggered the modal
            var nick = button.data('nick'); // Extract info from data-* attributes
            self.find("input[name=nick]").val(nick);

            var planid = button.data('planid'); // Extract info from data-* attributes
            self.find("input[name=planid]").val(planid);

            $.ajax({
                url:"<?php echo $this->createUrl('/main/case/caseid');?>",
                type:"post",
                data:{nick:nick},
                dataType:"json",
                success:function(resp){
                    $("body").hideLoading();
                    if(resp.data.caseid)
                        self.find("input[name=caseid]").val(resp.data.caseid);
                },
                beforeSend:function(){
                    $("body").showLoading();
                },
                error:function(){
                    $("body").hideLoading();
                }
            });
            self.find("#shopcase-add-btn").unbind("click");
            self.find("#shopcase-add-btn").click(function(){
                var shopcase = self.find("form").serialize();
                $.ajax({
                    url:"<?php echo $this->createUrl('/main/case/add');?>",
                    type:"post",
                    data:shopcase,
                    dataType:"json",
                    success:function(resp){
                        $("body").hideLoading();
                        if(resp.isSuccess) {
                            self.modal('hide');
                            location.reload();
                        }
                    },
                    beforeSend:function(){
                        $("body").showLoading();
                    },
                    error:function(){
                        app.error("操作失败，请确认网络连接是否正常后请重试!");
                        $("body").hideLoading();
                    }
                });

            })
        });


        $("button[data-click=sure]").click(function(){
            var nick = $(this).attr("data-nick");
            var url = $(this).attr("data-url");

            $.ajax({
                url:url,
                type:"post",
                data:{nick:nick},
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
                    app.error("操作失败，请确认网络连接是否正常后请重试!");
                    $("body").hideLoading();
                }
            });
        })

    });


</script>

