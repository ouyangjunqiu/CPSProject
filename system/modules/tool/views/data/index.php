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
                            <a href="<?php echo $this->createUrl("/tool/data/index");?>"><span class="label label-default">报表下载</span></a>
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
            <form action="<?php echo $this->createUrl("/tool/data/task");?>" class="form-inline" id="data-task-request-form">
                <div class="form-group">
                    <small>报表类型:</small>
                    <?php echo CHtml::dropDownList("datatype",$query["dataType"],array("class"=>"form-control"));?>
                </div>
                <div class="form-group">
                    <small>日期:</small>
                    <div class="input-group" id="dateSetting">
                        <span class="input-group-addon"> <i class="glyphicon glyphicon-calendar"></i> </span>
                        <input type="text" class="form-control" value="">
                        <span class="input-group-addon"><b class="caret"></b></span>
                    </div>
                    <input type="hidden" name="begin_time">
                    <input type="hidden" name="end_time">
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

    <div class="panel" id="item-detail-panel" style="display: none">
        <div class="panel-body">

        </div>
    </div>
</div>

<script type="text/x-jquery-tmpl" id="item-detail-tmpl">
{{if isSuccess}}
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

    <table class="table">
        <thead>
            <tr class="small"><td>类目</td><td>属性</td><td>值</td></tr>

        </thead>
        <tbody>
             {{each(i,v) data.props}}
                 <tr>
                    <td>${data.category_tree}</td>
                    <td>${v[2]}</td>
                    <td>${v[3]}</td>
                 </tr>

            {{/each}}
        </tbody>

    </table>
{{else}}
    <p>${msg}</p>
{{/if}}
</script>



<script type="text/javascript">
    $(document).ready(function(){

        var self = $(this);

        $(".top-ul>li").eq(3).addClass("top-li-hover");

        $("#dateSetting").daterangepicker({
            "startDate": "<?php echo $query['beginDate'];?>",
            "endDate": "<?php echo $query['endDate'];?>",
            "format":"YYYY-MM-DD"
        },function (start,end){

            $("input[name=begin_time]").val(start.format('YYYY-MM-DD'));
            $("input[name=end_time]").val(end.format('YYYY-MM-DD'));
        });

        $("button[data-click=save]").click(function(){
            $("#data-task-request-form").trigger("click");
        });


        $("#data-task-request-form").keydown(function(event){
            var self = $(this);
            if(event.which == 13){
                $.ajax({
                    url: self.attr("action"),
                    data: self.serialize(),
                    type:"post",
                    dataType:"json",
                    success:function(resp){
                        $("#item-detail-panel").show();

                        $("#item-detail-panel .panel-body").html($("#item-detail-tmpl").tmpl(resp));
                    }
                });
                return false;

            }
        });

    });
</script>