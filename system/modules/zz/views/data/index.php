<link rel="stylesheet" href="<?php echo STATICURL.'/main/css/index.css'; ?>">

<div class="index-table-div">

    <div class="search-box">
        <div class="shop-list-cont">
            <div class="row">
                <div class="col-md-12">
                    <div class="search-left com-list-tit" style="display: block;">
                        <span class="shop-list-icon"></span>
                        <span class="shop-list-txt">智·钻</span>
                        <small>
                            <a href="<?php echo $this->createUrl("/zz/advertiserrpt/index");?>"><span class="label label-default">全店推广</span></a>
                            <a href="<?php echo $this->createUrl("/zz/summary/index");?>"><span class="label label-default">店铺统计报表</span></a>
                            <a href="<?php echo $this->createUrl("/zz/summary/pic");?>"><span class="label label-default">人员统计报表</span></a>
                            <a href="<?php echo $this->createUrl("/zz/data/index");?>"><span class="label label-info">报表下载</span></a>

                        </small>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row" style="margin-top: 10px;margin-bottom: 10px;">
        <div class="col-md-2">

        </div>
        <div class="col-md-8">

            <ul class="nav nav-tabs shop-nav" role="tablist">
                <li role="presentation" class="active"><a href="#category_task_request_panel" title="类目报表" aria-controls="category_task_request_panel" role="tab" data-toggle="tab" aria-expanded="true">
                        类目报表</a>
                </li>
                <li role="presentation"><a href="#shop_task_request_panel" data-type="file" title="店铺报表" aria-controls="shop_task_request_panel" role="tab" data-toggle="tab" aria-expanded="true">
                        店铺报表</a>
                </li>
            </ul>

            <div class="tab-content">

                <div role="tabpanel" class="tab-pane active" id="category_task_request_panel">
                    <form action="<?php echo $this->createUrl("/zz/data/down");?>" role="form" id="data-category-task-request-form">
                        <div class="form-group">
                            <small>报表类型:</small>
                            <?php echo \CHtml::dropDownList("datatype","",$query["categoryTaskType"],array("class"=>"form-control"));?>
                        </div>
                        <div class="form-group">
                            <small>日期:</small>
                            <div class="input-group" data-role="dateSetting">
                                <span class="input-group-addon"> <i class="glyphicon glyphicon-calendar"></i> </span>
                                <input type="text" class="form-control" data-role="dateview" value="<?php echo $query['beginDate'];?> ~ <?php echo $query['endDate'];?>">
                                <span class="input-group-addon"><b class="caret"></b></span>
                            </div>
                            <input type="hidden" name="begin_time" value="<?php echo $query['beginDate'];?>">
                            <input type="hidden" name="end_time" value="<?php echo $query['endDate'];?>">
                        </div>
                        <div class="form-group">
                            <small>主营行业:</small>
                            <select class="selectpicker" data-role="categoryname" name="categoryname[]" data-placeholder="" style="width: 100%"  multiple="multiple">
                                <option value=""></option>
                                <?php foreach($catgorynames as $k=>$r):?>
                                    <option value="<?php echo $r;?>"><?php echo $r;?></option>
                                <?php endforeach;?>
                            </select>
                        </div>

                        <div class="form-group">
                            <button type="button" class="btn btn-primary" data-click="save">创建下载任务</button>
                        </div>
                    </form>
                </div>
                <div role="tabpanel" class="tab-pane" id="shop_task_request_panel">
                    <form action="<?php echo $this->createUrl("/zz/data/down");?>" role="form" id="data-shop-task-request-form">
                        <div class="form-group">
                            <small>报表类型:</small>
                            <?php echo \CHtml::dropDownList("datatype","",$query["shopTaskType"],array("class"=>"form-control"));?>
                        </div>
                        <div class="form-group">
                            <small>日期:</small>
                            <div class="input-group" data-role="dateSetting">
                                <span class="input-group-addon"> <i class="glyphicon glyphicon-calendar"></i> </span>
                                <input type="text" class="form-control" data-role="dateview" value="<?php echo $query['beginDate'];?> ~ <?php echo $query['endDate'];?>">
                                <span class="input-group-addon"><b class="caret"></b></span>
                            </div>
                            <input type="hidden" name="begin_time" value="<?php echo $query['beginDate'];?>">
                            <input type="hidden" name="end_time" value="<?php echo $query['endDate'];?>">
                        </div>

                        <div class="form-group">
                            <small>店铺:</small>
                            <select class="selectpicker" data-role="shopname" name="shopname[]" data-placeholder="" style="width: 100%"  multiple="multiple">
                                <option value=""></option>
                                <?php foreach($shopnames as $k=>$r):?>
                                    <option value="<?php echo $r;?>"><?php echo $r;?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-primary" data-click="save">创建下载任务</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <div class="col-md-2">

        </div>
    </div>

    <div class="row" style="margin-top: 10px;margin-bottom: 10px;">
        <div class="col-md-2">

        </div>
        <div class="col-md-8">
            <div class="panel panel-info ">
                <div class="panel-heading">下载任务</div>
                <div class="panel-body" style="min-height: 500px">
                    <div data-load="overlay" data-tmpl="task-detail-tmpl" data-role="task-detail" data-url="<?php echo $this->createUrl("/zz/data/getlist");?>">
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-2">

        </div>
    </div>
</div>

<script type="text/x-jquery-tmpl" id="task-detail-tmpl">
<table class="table">
    <thead>
        <tr>
            <td>报表需求</td>
            <td>进度</td>
        </tr>
    </thead>
    <tbody>
{{each(i,v) data.list}}
    <tr>
        <td>
        {{each(j,p) v.params_obj}}
            <p><strong>${p.TableTypeName}</strong> <small>[${p.Begin_Time} ~ ${p.End_Time}]</small></p>
            <p>
            {{if p["Categoryname"].length>0}}<small style="margin-right:5px">主营行业：${p["Categoryname"].join(",")}</small>{{/if}}
            {{if p["Shopname"].length>0}}<small>店铺：${p["Shopname"].join(",")}</small>{{/if}}
            </p>
        {{/each}}
      </td>
      <td>
      {{if v.code>0}}
        <a href="<?php echo $this->createUrl("/zz/data/getfile");?>&id=${v.id}" target="_blank" class="text-primary"><i class="glyphicon glyphicon-save"></i> 下载文件</a>
      {{else}}
        {{if v.code<0}}
            <span class="text-danger"><i class="glyphicon glyphicon-remove-circle"></i> 任务失败</span>
        {{else}}
            <span class="text-muted"><i class="glyphicon glyphicon-time"></i> 任务运行中...</span>
        {{/if}}

      {{/if}}
      </td>
    </tr>
{{/each}}
    </tbody>
 </table>
</script>



<script type="text/javascript">
    $(document).ready(function(){

        var self = $(this);

        $(".top-ul>li").eq(1).addClass("top-li-hover");

        $("#data-category-task-request-form [data-role=dateSetting]").daterangepicker({
            locale:$.locale,
            "startDate": "<?php echo date("m/d/Y",strtotime($query['beginDate']));?>",
            "endDate": "<?php echo date("m/d/Y",strtotime($query['endDate']));?>",
            "maxDate":"<?php echo date("m/d/Y",strtotime("-1 days"));?>"
        },function (start,end){
            $("#data-category-task-request-form input[data-role=dateview]").val(start.format('YYYY-MM-DD')+" ~ "+end.format('YYYY-MM-DD'));

            $("#data-category-task-request-form input[name=begin_time]").val(start.format('YYYY-MM-DD'));
            $("#data-category-task-request-form input[name=end_time]").val(end.format('YYYY-MM-DD'));
        });

        $("select.selectpicker").select2({theme: "bootstrap", allowClear: true});

        $("#data-category-task-request-form [data-click=save]").click(function(){
            $("body").showLoading();
            var self = $("#data-category-task-request-form");
            $.ajax({
                url: self.attr("action"),
                data: self.serialize(),
                type:"post",
                dataType:"json",
                success:function(resp){
                    $("body").hideLoading();
                    if(resp.isSuccess){
                        $("[data-role=task-detail]").iLoad();
                    }else{
                        app.alert(resp.msg);
                    }
                },
                error:function(){
                    $("body").hideLoading();
                    app.alert("创建任务失败，请重试！");
                }
            });

        });


        $("#data-category-task-request-form").keydown(function(event){

            if(event.which == 13){
                $("#data-category-task-request-form [data-click=save]").trigger("click");
                return false;

            }
        });


        $("#data-shop-task-request-form [data-role=dateSetting]").daterangepicker({
            locale:$.locale,
            "startDate": "<?php echo date("m/d/Y",strtotime($query['beginDate']));?>",
            "endDate": "<?php echo date("m/d/Y",strtotime($query['endDate']));?>",
            "maxDate":"<?php echo date("m/d/Y",strtotime("-1 days"));?>"
        },function (start,end){
            $("#data-shop-task-request-form input[data-role=dateview]").val(start.format('YYYY-MM-DD')+" ~ "+end.format('YYYY-MM-DD'));

            $("#data-shop-task-request-form input[name=begin_time]").val(start.format('YYYY-MM-DD'));
            $("#data-shop-task-request-form input[name=end_time]").val(end.format('YYYY-MM-DD'));
        });

        $("#data-shop-task-request-form [data-click=save]").click(function(){
            $("body").showLoading();
            var self = $("#data-shop-task-request-form");
            $.ajax({
                url: self.attr("action"),
                data: self.serialize(),
                type:"post",
                dataType:"json",
                success:function(resp){
                    $("body").hideLoading();
                    if(resp.isSuccess){
                        $("[data-role=task-detail]").iLoad();
                    }else{
                        app.alert(resp.msg);
                    }
                },
                error:function(){
                    $("body").hideLoading();
                    app.alert("创建任务失败，请重试！");
                }
            });

        });


        $("#data-shop-task-request-form").keydown(function(event){

            if(event.which == 13){
                $("#data-shop-task-request-form [data-click=save]").trigger("click");
                return false;

            }
        });

        setInterval(function(){
            $("[data-role=task-detail]").iLoad();
        },15000);

    });
</script>