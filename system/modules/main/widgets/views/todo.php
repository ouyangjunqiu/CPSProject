
<div class="modal fade" id="ShopTodoAddModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">新建待办事项</h4>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" name="nick"  />
                    <input type="hidden" name="creator"  value="<?php echo empty($user["username"])?"游客":$user["username"];?>"/>
                    <div class="form-group">

                        <label class="radio-inline">
                            <input type="radio" name="logdate" value="<?php echo date("Y-m-d");?>" checked="checked"> 今日
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="logdate" value="<?php echo date("Y-m-d",strtotime("+1 days"));?>"> 明日
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="logdate" value="<?php echo date("Y-m-d",strtotime("+2 days"));?>"> 后日
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="logdate" value="<?php echo date("Y-m-d",strtotime("+3 days"));?>"> 3天后
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="logdate" value="<?php echo date("Y-m-d",strtotime("+5 days"));?>"> 5天后
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="logdate" value="<?php echo date("Y-m-d",strtotime("+7 days"));?>"> 7天后
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">事项:</label>

                        <textarea class="form-control" name="content" rows="3"></textarea>
                    </div>


                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="priority">紧急
                            </label>
                        </div>
                    </div>
                    <div class="input-group">
                        <select class="selectpicker" data-live-search="true" name="pic" data-none-selected-text="@" data-live-search-normalize="true" data-live-search-placeholder="@">
                            <option value=""></option>
                            <?php foreach($users as $u):?>
                                <option data-tokens="<?php echo $u["text"];?>" value="<?php echo $u["text"];?>">@<?php echo $u["text"];?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" id="shopcase-add-btn">保存</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ShopTodoViewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">待办事项</h4>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ShopTodoOpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">待办事项</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default">废弃</button>
                <button type="button" class="btn btn-primary">完成</button>
            </div>
        </div>
    </div>
</div>

<script type="text/x-jquery-tmpl" id="shop-todo-list-tmpl">
 <div>
    <div class="row">
        <div class="col-md-3">
          <div class="list-group">
              <a class="list-group-item disabled">
                以往
              </a>

              {{each(i,v) data.history}}
                {{if v.status==1}}
                    <a data-toggle="modal" data-target="#ShopTodoViewModal" data-backdrop="false" class="list-group-item list-group-item-success" data-content="${v.content}">
                    <small {{if v.priority=="紧急"}}class="danger"{{/if}}>[${v.priority}]</small>{{html v.title}} {{if v.pic}}<small>@${v.pic}</small>{{/if}}
                    </a>
                {{else}}
                   <a data-id="${v.id}" data-toggle="modal" data-target="#ShopTodoOpModal" data-backdrop="false" class="list-group-item list-group-item-danger" data-content="${v.content}">
                    <small {{if v.priority=="紧急"}}class="danger"{{/if}}>[${v.priority}]</small>{{html v.title}} {{if v.pic}}<small>@${v.pic}</small>{{/if}}
                   </a>
                {{/if}}
              {{/each}}
          </div>

        </div>
        <div class="col-md-3">
           <div class="list-group">
              <a class="list-group-item disabled">
                昨日
              </a>
              {{each(i,v) data.list[0]}}
                {{if v.status==1}}
                    <a data-toggle="modal" data-target="#ShopTodoViewModal" data-backdrop="false" class="list-group-item list-group-item-success" data-content="${v.content}">
                    <small {{if v.priority=="紧急"}}class="danger"{{/if}}>[${v.priority}]</small>{{html v.title}} {{if v.pic}}<small>@${v.pic}</small>{{/if}}
                    </a>
                {{else}}
                   <a data-id="${v.id}" data-toggle="modal" data-target="#ShopTodoOpModal" data-backdrop="false" class="list-group-item list-group-item-danger" data-content="${v.content}">
                    <small {{if v.priority=="紧急"}}class="danger"{{/if}}>[${v.priority}]</small>{{html v.title}} {{if v.pic}}<small>@${v.pic}</small>{{/if}}
                   </a>
                {{/if}}
              {{/each}}
           </div>
        </div>
        <div class="col-md-3">
            <div class="list-group">
              <a class="list-group-item active">
                今日
              </a>
              {{each(i,v) data.list[1]}}
                {{if v.status==1}}
                    <a data-toggle="modal" data-target="#ShopTodoViewModal" data-backdrop="false" class="list-group-item list-group-item-success" data-content="${v.content}">
                    <small {{if v.priority=="紧急"}}class="danger"{{/if}}>[${v.priority}]</small>{{html v.title}} {{if v.pic}}<small>@${v.pic}</small>{{/if}}
                    </a>
                {{else}}
                   <a data-id="${v.id}" data-toggle="modal" data-target="#ShopTodoOpModal" data-backdrop="false" class="list-group-item" data-content="${v.content}">
                    <small {{if v.priority=="紧急"}}class="danger"{{/if}}>[${v.priority}]</small>{{html v.title}} {{if v.pic}}<small>@${v.pic}</small>{{/if}}
                   </a>
                {{/if}}
              {{/each}}
              <a data-toggle="modal" data-target="#ShopTodoAddModal" data-backdrop="false" data-logdate-index="0" class="list-group-item">新建待办事项...</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="list-group">
              <a class="list-group-item disabled">
                计划
              </a>
              {{each(i,v) data.list[2]}}
               {{if v.status==1}}
                    <a data-toggle="modal" data-target="#ShopTodoViewModal" data-backdrop="false" class="list-group-item list-group-item-success" data-content="${v.content}">
                    <small {{if v.priority=="紧急"}}class="danger"{{/if}}>[${v.priority}]</small>{{html v.title}} {{if v.pic}}<small>@${v.pic}</small>{{/if}}
                    </a>
                {{else}}
                   <a data-id="${v.id}" data-toggle="modal" data-target="#ShopTodoOpModal" data-backdrop="false" class="list-group-item" data-content="${v.content}">
                    <small {{if v.priority=="紧急"}}class="danger"{{/if}}>[${v.priority}]</small>{{html v.title}} {{if v.pic}}<small>@${v.pic}</small>{{/if}}
                    <small class="label label-success"><i class="fa fa-clock-o"></i> ${v.days} days</small>
                   </a>
                {{/if}}
              {{/each}}
                <a data-toggle="modal" data-target="#ShopTodoAddModal" data-backdrop="false" data-logdate-index="1" class="list-group-item">新建待办事项...</a>
            </div>
        </div>
    </div>
 </div>
</script>

<style type="text/css">
    #my-todo-list-helper{
        position: fixed;
        top: 50%;
        left: 5px;
        cursor: pointer;
    }

    .icon-msg o{
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        border-radius: 50%;
        position: absolute;
        top: 7px;
        right: 2px;
        font-size: 10px;
        font-weight: normal;
        width: 15px;
        height: 15px;
        line-height: 1.0em;
        text-align: center;
        padding: 2px;
        background-color: red;
        display: inline;
        white-space: nowrap;
        vertical-align: baseline;
        color: #fff;
    }

    .icon-msg i{
        zoom: 2;
    }

    .icon-msg {
        position: relative;
        padding: 20px 5px;
    }


    #my-todo-wrap{
        position: fixed;
        top: 0px;
        left: 0px;
        width: 350px;
        display: none;
        opacity: 0.95;
        height: 100%;
        z-index: 1000;
    }

    #my-todo-wrap .box-body{
        overflow-y: auto !important;
        overflow-x: hidden;
    }

</style>
<div id="my-todo-list-helper" style="display:none">
    <a href="javascript:void(0)" class="icon-msg">
        <i class="fa fa-comments-o"></i>
        <o data-old="0">0</o>
    </a>
</div>

<div id="my-todo-wrap">

    <div class="box box-success">
        <div class="box-header">
            <i class="fa fa-comments-o"></i>
            <h3 class="box-title"></h3>
            <div class="box-tools pull-right">
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm" data-click="close"><i class="fa fa-times"></i></button>
                </div>
            </div>
        </div>
        <div style="min-height: 500px;" data-role="my-todo" class="box-body chat overlay-wrapper" data-tmpl="my-todo-list-tmpl" data-url="<?php echo \cloud\Cloud::app()->getUrlManager()->createUrl("/main/todo/my",array("pic"=>empty($user["username"])?"游客":$user["username"]));?>">


        </div>
    </div>
</div>

<script type="text/x-jquery-tmpl" id="my-todo-list-tmpl">

        {{each(i,v) data.list}}
        <div class="item row">
            <p class="message">
                <a href="<?php echo \cloud\Cloud::app()->getUrlManager()->createUrl("/main/default/index",array("_t"=>time()));?>&q=${v.nick}" data-nick="${v.nick}" class="name" target="_blank">
                    <small class="text-muted pull-right label label-success"><i class="fa fa-clock-o"></i> {{if v.days==0}}今天{{else}}${v.days}天前{{/if}}</small>
                    ${v.nick}
                </a>
                <a data-id="${v.id}" data-toggle="modal" data-target="#ShopTodoOpModal" data-backdrop="false" data-content="${v.content}">

                    <small {{if v.priority=="紧急"}}class="danger"{{/if}}>[${v.priority}]</small>{{html v.title}}
               </a>
            </p>

        </div>
        {{/each}}

</script>


<script type="application/javascript">

    $(document).ready(function(){

        //$('#ShopTodoAddModal [name=pic]').selectpicker();

        $('#ShopTodoAddModal').on('show.bs.modal', function (event) {
            var self = $(this);
            var button = $(event.relatedTarget); // Button that triggered the modal
            var nick = button.parents("div[data-role=shop-todo-list]").eq(0).data("nick");
            var index = button.data('logdate-index'); // Extract info from data-* attributes
            self.find("input[name=nick]").val(nick);
            if(index>=0) {
                self.find("input[name=logdate]").eq(index).attr("checked", "checked");
            }

            var overlay = button.parents("div[data-load=overlay]").eq(0);

            self.find("#shopcase-add-btn").unbind("click");
            self.find("#shopcase-add-btn").click(function(){
                var shopcase = self.find("form").serialize();
                $.ajax({
                    url:"<?php echo $urls["todo_add_url"];?>",
                    type:"post",
                    data:shopcase,
                    dataType:"json",
                    success:function(resp){
                        $("body").hideLoading();
                        if(resp.isSuccess) {
                            self.find("textarea[name=content]").val("");
                            self.modal('hide');
                            overlay.DataLoad();
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

        $('#ShopTodoViewModal').on('show.bs.modal', function (event) {
            var self = $(this);
            var button = $(event.relatedTarget); // Button that triggered the modal
            self.find(".modal-body").html("<pre>"+button.data("content")+"</pre>");

        });

        $('#ShopTodoOpModal').on('show.bs.modal', function (event) {
            var self = $(this);
            var button = $(event.relatedTarget); // Button that triggered the modal
            self.find(".modal-body").html("<pre>"+button.data("content")+"</pre>");

            var id = button.data("id");

            var overlay = button.parents("div[data-load=overlay]").eq(0);

            self.find(".btn-default").unbind("click");
            self.find(".btn-default").click(function(){
                $.ajax({
                    url:"<?php echo $urls["todo_del_url"];?>",
                    type:"post",
                    data:{id:id,updator:'<?php echo empty($user["username"])?"游客":$user["username"];?>'},
                    dataType:"json",
                    success:function(resp){
                        $("body").hideLoading();
                        if(resp.isSuccess) {
                            self.modal('hide');
                            overlay.DataLoad();
                            $("#my-todo-wrap [data-role=my-todo]").DataLoad();
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

            });

            self.find(".btn-primary").unbind("click");
            self.find(".btn-primary").click(function(){
                $.ajax({
                    url:"<?php echo $urls["todo_done_url"];?>",
                    type:"post",
                    data:{id:id,updator:'<?php echo empty($user["username"])?"游客":$user["username"];?>'},
                    dataType:"json",
                    success:function(resp){
                        $("body").hideLoading();
                        if(resp.isSuccess) {
                            self.modal('hide');
                            overlay.DataLoad();
                            $("#my-todo-wrap [data-role=my-todo]").DataLoad();
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

        var r = function(){



            $.ajax({
                url:"<?php echo \cloud\Cloud::app()->getUrlManager()->createUrl("/main/todo/mytips",array("pic"=>empty($user["username"])?"游客":$user["username"]));?>",
                dataType:"json",
                type:"get",
                success:function(resp){
                    if(resp.isSuccess && resp.data && resp.data.count>0){
                        $("#my-todo-list-helper .icon-msg o").html(resp.data.count);
                        $("#my-todo-list-helper").show();

                        var t = $.cookie("todo.alert.time");
                        if(!t || Date.now()>t){
                            var date = new Date();
                            date.setTime(date.getTime() +  60 * 1000);
                            $.cookie("todo.alert.time",date.getTime());
                            window.postMessage({type:'alertMessage',title:"待办提醒",message:"你有"+resp.data.count+"件待办事项未完成!"},'*');
                        }
                    }else{
                        $("#my-todo-list-helper").hide();
                    }
                }
            })
        };
        setInterval(r,60000);
        r();

        $("#my-todo-list-helper").click(function(){
            $("#my-todo-wrap").show();

            $("#my-todo-list-helper").hide();
            $("#my-todo-wrap [data-role=my-todo]").css("height",$(window).height()+"px");
            $("#my-todo-wrap [data-role=my-todo]").DataLoad();

        });
        $("#my-todo-wrap .btn[data-click=close]").click(function(){
            $("#my-todo-wrap").hide();
            $("#my-todo-list-helper").show();
        });

    })

</script>

