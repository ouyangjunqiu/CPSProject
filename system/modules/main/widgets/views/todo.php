
<div class="modal fade" id="ShopTodoAddModal" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document" aria-hidden="true">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">待办事项</h4>
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
                                <input type="checkbox" name="priority" value="紧急">紧急
                            </label>
                        </div>
                    </div>
                    <div class="input-group">
                        <select class="selectpicker" data-role="pic" name="pic[]" data-placeholder="@" style="width: 100%"  multiple="multiple">
                            <option value=""></option>
                            <?php foreach($users as $u):?>
                                <option value="<?php echo $u["text"];?>">@<?php echo $u["text"];?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-click="save">确定</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ShopTodoViewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document" aria-hidden="true">
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

<div id="my-todo-wrap">

    <div class="box box-default">
        <div class="box-body chat">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#mypictodo_list" title="待办事项" aria-controls="mytodo_list" role="tab" data-toggle="tab" aria-expanded="true">
                        <span>@我的事项</span>
                    </a>
                </li>
                <li role="presentation">
                    <a href="#my_create_todo_list" title="待办事项" aria-controls="my_create_todo_list" role="tab" data-toggle="tab" aria-expanded="true">
                        <span>我发布的事项</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="mypictodo_list">
                    <div data-role="my-todo" class="overlay-wrapper" data-tmpl="my-todo-list-tmpl" data-url="<?php echo \cloud\Cloud::app()->getUrlManager()->createUrl("/main/todo/my",array("pic"=>empty($user["username"])?"游客":$user["username"]));?>"></div>
                </div>

                <div role="tabpanel" class="tab-pane" id="my_create_todo_list">
                    <div data-role="my-todo" class="overlay-wrapper" data-tmpl="my-create-todo-list-tmpl" data-url="<?php echo \cloud\Cloud::app()->getUrlManager()->createUrl("/main/todo/mycreate",array("pic"=>empty($user["username"])?"游客":$user["username"]));?>"></div>
                </div>
            </div>

        </div>
        <div class="box-footer">

            <div class="btn-group">
                <button type="button" class="btn btn-default btn-sm" data-click="close"><i class="glyphicon glyphicon-chevron-up"></i></button>
            </div>

        </div>
    </div>
</div>


<script type="text/x-jquery-tmpl" id="my-todo-list-tmpl">

        {{each(i,v) data.list}}
        <div class="item row">
            <p class="message">
                <a href="<?php echo cloud\Cloud::app()->getUrlManager()->createUrl("/main/default/index");?>&q=${v.nick}" data-nick="${v.nick}" class="name" target="_blank">
                    <small class="text-muted pull-right label label-success"><i class="glyphicon glyphicon-time"></i> ${v.daysStr}</small>
                    ${v.nick}
                </a>
                <a data-id="${v.id}" data-toggle="modal" data-target="#ShopTodoOpModal" class="list-group-item" data-backdrop="false" data-content="${v.content}" data-trigger-target="todo_${v.md5}">

                    <small {{if v.priority=="紧急"}}class="danger"{{/if}}>[${v.priority}] ${v.creator}说:</small>{{html v.title}}
               </a>
            </p>

        </div>
        {{/each}}

    </script>

<script type="text/x-jquery-tmpl" id="my-create-todo-list-tmpl">

        {{each(i,v) data.list}}
        <div class="item row">
            <p class="message">
                <a href="<?php echo cloud\Cloud::app()->getUrlManager()->createUrl("/main/default/index");?>&q=${v.nick}" data-nick="${v.nick}" class="name" target="_blank">
                    <small class="text-muted pull-right label label-success"><i class="glyphicon glyphicon-time"></i> ${v.daysStr}</small>
                    ${v.nick}
                </a>
                {{if v.status==1}}
                    <a data-toggle="modal" data-target="#ShopTodoViewModal" data-backdrop="false" class="list-group-item list-group-item-success" data-content="${v.content}">
                    <small {{if v.priority=="紧急"}}class="danger"{{/if}}>[${v.priority}] ${v.creator}说:</small>{{html v.title}} {{if v.pic}}<small>@${v.pic}</small>{{/if}}
                    </a>
                {{else}}
                   <a data-id="${v.id}" data-toggle="modal" data-target="#ShopTodoOpModal" data-backdrop="false" class="list-group-item list-group-item-danger" data-content="${v.content}" data-trigger-target="todo_${v.md5}">
                    <small {{if v.priority=="紧急"}}class="danger"{{/if}}>[${v.priority}] ${v.creator}说:</small>{{html v.title}} {{if v.pic}}<small>@${v.pic}</small>{{/if}}
                   </a>
                {{/if}}
            </p>

        </div>
        {{/each}}

    </script>


<div class="modal fade" id="ShopTodoOpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document" aria-hidden="true">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">待办事项</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-2">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" class="do_reply_ctrl"> 回复
                            </label>
                        </div>

                    </div>
                    <div class="col-md-10">
                        <button type="button" class="btn btn-primary" data-role="reply" data-reply="no">完成</button>
                        <a data-toggle="modal" data-target="#ShopTodoAddModal" data-backdrop="false" data-role="doreply"></a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



<script type="text/x-jquery-tmpl" id="shop-todo-list-tmpl">
 <div>
    <div class="row">
        <div class="col-md-4">
          <div class="list-group">
              <a class="list-group-item disabled">
                以往 <span class="badge">近7天</span>
              </a>

              {{each(i,v) data.history}}
                {{if v.status==1}}
                    <a data-toggle="modal" data-target="#ShopTodoViewModal" data-backdrop="false" class="list-group-item list-group-item-success" data-content="${v.content}">
                    <small {{if v.priority=="紧急"}}class="danger"{{/if}}>[${v.priority}] ${v.creator}说:</small>{{html v.title}} {{if v.pic}}<small>@${v.pic}</small>{{/if}}
                    <small class="label label-success"><i class="glyphicon glyphicon-time"></i> ${v.daysStr}</small>
                    </a>
                {{else}}
                   <a data-id="${v.id}" data-toggle="modal" data-target="#ShopTodoOpModal" data-backdrop="false" class="list-group-item list-group-item-danger" data-content="${v.content}" data-trigger-target="todo_${v.md5}">
                    <small {{if v.priority=="紧急"}}class="danger"{{/if}}>[${v.priority}] ${v.creator}说:</small>{{html v.title}} {{if v.pic}}<small>@${v.pic}</small>{{/if}}
                    <small class="label label-danger"><i class="glyphicon glyphicon-time"></i> ${v.daysStr}</small>
                   </a>
                {{/if}}
              {{/each}}
          </div>

        </div>

        <div class="col-md-4">
            <div class="list-group">
              <a class="list-group-item active">
                今日
              </a>
              {{each(i,v) data.list[0]}}
                {{if v.status==1}}
                    <a data-toggle="modal" data-target="#ShopTodoViewModal" data-backdrop="false" class="list-group-item list-group-item-success" data-content="${v.content}">
                    <small {{if v.priority=="紧急"}}class="danger"{{/if}}>[${v.priority}] ${v.creator}说:</small>{{html v.title}} {{if v.pic}}<small>@${v.pic}</small>{{/if}}
                    </a>
                {{else}}
                   <a data-id="${v.id}" data-toggle="modal" data-target="#ShopTodoOpModal" data-backdrop="false" class="list-group-item" data-content="${v.content}"  data-trigger-target="todo_${v.md5}">
                    <small {{if v.priority=="紧急"}}class="danger"{{/if}}>[${v.priority}] ${v.creator}说:</small>{{html v.title}} {{if v.pic}}<small>@${v.pic}</small>{{/if}}
                   </a>
                {{/if}}
              {{/each}}
            </div>
        </div>
        <div class="col-md-4">
            <div class="list-group">
              <a class="list-group-item disabled">
                计划
              </a>
              {{each(i,v) data.list[1]}}
               {{if v.status==1}}
                    <a data-toggle="modal" data-target="#ShopTodoViewModal" data-backdrop="false" class="list-group-item list-group-item-success" data-content="${v.content}">
                    <small {{if v.priority=="紧急"}}class="danger"{{/if}}>[${v.priority}] ${v.creator}说:</small>{{html v.title}} {{if v.pic}}<small>@${v.pic}</small>{{/if}}
                     <small class="label label-success"><i class="glyphicon glyphicon-time"></i> ${v.daysStr}</small>
                    </a>
                {{else}}
                   <a data-id="${v.id}" data-toggle="modal" data-target="#ShopTodoOpModal" data-backdrop="false" class="list-group-item" data-content="${v.content}"  data-trigger-target="todo_${v.md5}">
                    <small {{if v.priority=="紧急"}}class="danger"{{/if}}>[${v.priority}] ${v.creator}说:</small>{{html v.title}} {{if v.pic}}<small>@${v.pic}</small>{{/if}}
                    <small class="label label-success"><i class="glyphicon glyphicon-time"></i> ${v.daysStr}</small>
                   </a>
                {{/if}}
              {{/each}}
          </div>
        </div>
    </div>
 </div>
</script>





<script type="application/javascript">

    $(document).ready(function(){

        $("select.selectpicker").select2({theme: "bootstrap", allowClear: true});


        $('#ShopTodoAddModal').delegate("[data-click=save]","click",function(){
            var shopcase = $('#ShopTodoAddModal').find("form").serialize();
            var targetid = $(this).attr("data-trigger-target");
            var target = targetid && $("#"+targetid).find("[data-load=overlay]");
            $.ajax({
                url:"<?php echo $urls["todo_add_url"];?>",
                type:"post",
                data:shopcase,
                dataType:"json",
                success:function(resp){
                    $("body").hideLoading();
                    if(resp.isSuccess) {
                        $('#ShopTodoAddModal').find("textarea[name=content]").val("");
                        $("#my-todo-wrap [data-role=my-todo]").iLoad();
                        target.iLoad();
                    }
                },
                beforeSend:function(){
                    $("body").showLoading();
                    $('#ShopTodoAddModal').modal('hide');
                },
                error:function(){
                    app.error("操作失败，请确认网络连接是否正常后请重试!");
                    $("body").hideLoading();
                }
            });

        });

        $('#ShopTodoOpModal').delegate('.btn-default','click',function(){
            var id = $(this).attr("data-id");
            var targetid = $(this).attr("data-trigger-target");
            var target = targetid && $("#"+targetid).find("[data-load=overlay]");
            $.ajax({
                url:"<?php echo $urls["todo_del_url"];?>",
                type:"post",
                data:{id:id,updator:'<?php echo empty($user["username"])?"游客":$user["username"];?>'},
                dataType:"json",
                success:function(resp){
                    $("body").hideLoading();
                    if(resp.isSuccess) {
                        $("#my-todo-wrap [data-role=my-todo]").iLoad();
                        target.iLoad();
                    }
                },
                beforeSend:function(){
                    $('#ShopTodoOpModal').modal('hide');
                    $("body").showLoading();
                },
                error:function(){
                    app.error("操作失败，请确认网络连接是否正常后请重试!");
                    $("body").hideLoading();
                }
            });

        });

        $('#ShopTodoOpModal').delegate('.btn-primary[data-role=sure]','click',function(){
            var id = $(this).attr("data-id");
            var targetid = $(this).attr("data-trigger-target");
            var target = targetid && $("#"+targetid).find("[data-load=overlay]");
            $.ajax({
                url:"<?php echo $urls["todo_done_url"];?>",
                type:"post",
                data:{id:id,updator:'<?php echo empty($user["username"])?"游客":$user["username"];?>'},
                dataType:"json",
                success:function(resp){
                    $("body").hideLoading();
                    if(resp.isSuccess) {
                        $("#my-todo-wrap [data-role=my-todo]").iLoad();
                        target.iLoad();
                    }
                },
                beforeSend:function(){
                    $('#ShopTodoOpModal').modal('hide');
                    $("body").showLoading();
                },
                error:function(){
                    app.error("操作失败，请确认网络连接是否正常后请重试!");
                    $("body").hideLoading();
                }
            });

        });
        $('#ShopTodoOpModal').delegate('.do_reply_ctrl','change',function(){
            var reply = $('#ShopTodoOpModal').find(".btn-primary[data-role=reply]");
            if(this.checked){
                reply.attr("data-reply","yes").html("完成并回复");
            }else{
                reply.attr("data-reply","no").html("完成");
            }

        });


        $('#ShopTodoOpModal').delegate('.btn-primary[data-role=reply]','click',function(){
            var id = $(this).attr("data-id");
            var e = $('#ShopTodoOpModal').find("a[data-role=doreply]");
            var targetid = $(this).attr("data-trigger-target");
            e.attr("data-trigger-target",targetid);
            var target = targetid && $("#"+targetid).find("[data-load=overlay]");
            var isReply = $(this).attr("data-reply");
            isReply = (isReply && isReply == "yes")?true:false;

            $.ajax({
                url:"<?php echo $urls["todo_done_url"];?>",
                type:"post",
                data:{id:id,updator:'<?php echo empty($user["username"])?"游客":$user["username"];?>'},
                dataType:"json",
                success:function(resp){
                    $("body").hideLoading();
                    if(resp.isSuccess) {
                        $("#my-todo-wrap [data-role=my-todo]").iLoad();
                        target.iLoad();
                        if(isReply){
                            e.attr("data-nick",resp.data.nick);
                            e.attr("data-pic",resp.data.creator);
                            e.trigger("click");
                        }
                    }
                },
                beforeSend:function(){
                    $('#ShopTodoOpModal').modal('hide');
                    $("body").showLoading();
                },
                error:function(){
                    app.error("操作失败，请确认网络连接是否正常后请重试!");
                    $("body").hideLoading();
                }
            });

        });


        $('#ShopTodoAddModal').on('show.bs.modal', function (event) {
            var self = $(this);
            var button = $(event.relatedTarget); // Button that triggered the modal
            var nick = button.attr("data-nick");
            self.find("input[name=nick]").val(nick);
            var pic = button.attr("data-pic");
            if(pic && pic.length>0){
                self.find("select[data-role=pic]").val(pic);
            }


            $('#ShopTodoAddModal').find(".btn").attr("data-trigger-target",button.attr("data-trigger-target"));
        });

        $('#ShopTodoViewModal').on('show.bs.modal', function (event) {
            var self = $(this);
            var button = $(event.relatedTarget); // Button that triggered the modal
            self.find(".modal-body").html("<pre>"+button.attr("data-content")+"</pre>");

        });

        $('#ShopTodoOpModal').on('show.bs.modal', function (event) {
            var self = $(this);
            var button = $(event.relatedTarget); // Button that triggered the modal
            self.find(".modal-body").html("<pre>"+button.attr("data-content")+"</pre>");
            $('#ShopTodoOpModal').find(".btn").attr("data-id",button.attr("data-id"));
            $('#ShopTodoOpModal').find(".btn").attr("data-trigger-target",button.attr("data-trigger-target"));

        });

    })

</script>

