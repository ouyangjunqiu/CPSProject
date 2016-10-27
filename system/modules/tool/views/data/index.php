<link rel="stylesheet" href="<?php echo STATICURL.'/main/css/index.css'; ?>">

<div class="index-table-div">

    <div class="search-box">
        <div class="shop-list-cont">
            <div class="row">
                <div class="col-md-12">
                    <div class="search-left com-list-tit" style="display: block;">
                        <span class="shop-list-icon"></span>
                        <span class="shop-list-txt">常用工具:</span>
                        <small>
                            <a href="<?php echo $this->createUrl("/tool/default/index");?>"><span class="label label-default">宝贝详情</span></a>
                            <a href="<?php echo $this->createUrl("/tool/data/index");?>"><span class="label label-info">报表下载</span></a>
                            <a href="<?php echo $this->createUrl("/main/plugin/upload");?>"><span class="label label-default">插件管理</span></a>

                            <a href="http://run.da-mai.com" target="_blank"><span class="label label-default">运维系统</span></a>
                            <a href="http://yunying.da-mai.com" target="_blank"><span class="label label-default">运营中心</span></a>
                            <a href="http://idea.da-mai.com" target="_blank"><span class="label label-default">创意中心</span></a>


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
            <form action="<?php echo $this->createUrl("/tool/data/down");?>" role="form" id="data-task-request-form">
                <div class="form-group">
                    <small>报表类型:</small>
                    <?php echo \CHtml::dropDownList("datatype","",$query["dataType"],array("class"=>"form-control"));?>
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
                    <input type="text" class="form-control" name="categoryname">
                </div>
                <div class="form-group">
                    <small>店铺:</small>
                    <input type="text" class="form-control" name="shopname">
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary" data-click="save">创建下载任务</button>
                </div>
            </form>
        </div>
        <div class="col-md-2">

        </div>
    </div>

    <div class="panel" id="task-detail-panel" style="display: none">
        <div class="panel-body">
            <div data-load="overlay" data-tmpl="task-detail-tmpl" data-role="task-detail-tmpl" data-url="<?php echo $this->createUrl("/tool/data/getlist");?>">
            </div>

        </div>
    </div>
</div>

<script type="text/x-jquery-tmpl" id="task-detail-tmpl">
{{if isSuccess}}
{{each(i,v) data.list}}
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <a href="${data.detail_url}" class="thumbnail">
          <img data-src="${data.pic_url}" src="${data.pic_url}" alt="${data.title}" style="width:120px;height:120px"/>
        </a>
      </div>
      <div class="col-md-9">
        <p><small>标题:</small>${data.title}</p>
        <p><small>价格:</small>${data.price}</p>
      </div>
    </div>
{{/each}}

{{else}}
    <p>${msg}</p>
{{/if}}
</script>



<script type="text/javascript">
    $(document).ready(function(){

        var self = $(this);

        $(".top-ul>li").eq(3).addClass("top-li-hover");

        $("#data-task-request-form [data-role=dateSetting]").daterangepicker({
            "startDate": "<?php echo $query['beginDate'];?>",
            "endDate": "<?php echo $query['endDate'];?>",
            "format":"YYYY-MM-DD"
        },function (start,end){
            $("#data-task-request-form input[data-role=dateview]").val(start.format('YYYY-MM-DD')+" ~ "+end.format('YYYY-MM-DD'));

            $("#data-task-request-form input[name=begin_time]").val(start.format('YYYY-MM-DD'));
            $("#data-task-request-form input[name=end_time]").val(end.format('YYYY-MM-DD'));
        });

        $("#data-task-request-form [data-click=save]").click(function(){
            $("body").showLoading();
            var self = $("#data-task-request-form");
            $.ajax({
                url: self.attr("action"),
                data: self.serialize(),
                type:"post",
                dataType:"json",
                success:function(resp){
                    $("body").hideLoading();
                },
                error:function(){
                    $("body").hideLoading();
                    app.alert("创建任务失败，请重试！");
                }
            });

        });


        $("#data-task-request-form").keydown(function(event){

            if(event.which == 13){
                $("#data-task-request-form [data-click=save]").trigger("click");
                return false;

            }
        });

    });
</script>