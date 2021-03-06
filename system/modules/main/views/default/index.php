<?php
$user = \cloud\core\utils\Env::getUser();
$username = empty($user)?"游客":$user["username"];
?>
<script src='<?php echo STATICURL."/main/js/shop.js"; ?>'></script>

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
                    <a href="<?php echo $this->createUrl("/main/default/hide");?>"><span class="label label-default">值班店铺</span></a>
                    <a href="<?php echo $this->createUrl("/main/default/beinglost");?>"><span class="label label-default">流失店铺</span></a>
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
                        <ul class="nav nav-tabs shop-nav" role="tablist">
                            <li role="presentation" class="active"><a href="#todo_<?php echo md5($row["nick"]);?>" title="待办事项" aria-controls="todo_<?php echo md5($row["nick"]);?>" role="tab" data-toggle="tab" aria-expanded="true">
                                    <i class="glyphicon glyphicon-tasks"></i><span>待办事项</span></a>
                            </li>
                            <li role="presentation"><a href="#file_<?php echo md5($row["nick"]);?>" data-type="file" title="云共享" aria-controls="file_<?php echo md5($row["nick"]);?>" role="tab" data-toggle="tab" aria-expanded="true">
                                    <i class="glyphicon glyphicon-cloud"></i><span>云共享</span></a>
                            </li>
                        </ul>

                        <div class="tab-content">

                            <div role="tabpanel" class="tab-pane active" id="todo_<?php echo md5($row["nick"]);?>">
                                <div data-load="overlay" data-tmpl="shop-tips-tmpl" data-url="<?php echo $this->createUrl("/main/budget/getbynick",array("nick"=>$row["nick"]));?>" style="margin-bottom: 10px">

                                </div>

                                <div class="overlay-wrapper" data-load="overlay" data-tmpl="shop-todo-list-tmpl" data-role="shop-todo-list" data-nick="<?php echo $row["nick"];?>" data-url="<?php echo $this->createUrl("/main/todo/getbynick",array("nick"=>$row["nick"]));?>">
                                </div>
                                <div class="row">

                                    <div class="col-md-4">
                                        <a href="#ShopTodoAddModal" data-toggle="modal" data-target="#ShopTodoAddModal" data-backdrop="false" data-trigger-target="todo_<?php echo md5($row["nick"]);?>" data-nick="<?php echo $row["nick"];?>"><i class="glyphicon glyphicon-plus"></i>新建待办事项...</a>

                                    </div>
                                    <div class="col-md-7">

                                    </div>
                                    <div class="col-md-1">
                                        <a href="<?php echo $this->createUrl("/main/todo/more",array("nick"=>$row["nick"]));?>"><small>更多..</small></a>
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="file_<?php echo md5($row["nick"]);?>">
                                <div class="overlay-wrapper" data-tmpl="shop-file-list-tmpl" data-role="shop-file-list" data-nick="<?php echo $row["nick"];?>" data-url="<?php echo $this->createUrl("/main/file/getbynick",array("nick"=>$row["nick"]));?>">
                                </div>

                                <a href="#ShopFileUploadModal" data-toggle="modal" data-target="#ShopFileUploadModal" data-backdrop="false" data-logdate-index="1" data-nick="<?php echo $row["nick"];?>" data-creator="<?php echo $username;?>" data-trigger-target="#file_<?php echo md5($row["nick"]);?>">
                                    <i class="glyphicon glyphicon-cloud-upload"></i> 上传文件...
                                </a>
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


<div class="modal fade" id="ShopFileUploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">云共享</h4>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" name="nick"/>
                    <input type="hidden" name="creator">
                    <input type="file" name="file" class="dropify" id="file" data-height="300" data-max-file-size="2M" />
                </form>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-primary" data-click="fileupload">上传文件</button>
            </div>
        </div>
    </div>
</div>

<script src='<?php echo STATICURL."/base/js/plugins/ajaxfileupload/ajaxfileupload.js"; ?>'></script>

<script type="text/x-jquery-tmpl" id="shop-file-list-tmpl">
    <div class="list-group">

       {{each(i,v) data.list}}

         <a class="list-group-item" href="<?php echo $this->createUrl("/file/default/down");?>&md5=${v.file_md5}" target="_blank">
              <strong>${v.file_name}</strong><span class="badge">${v.logdate}</span>
         </a>

       {{/each}}
   </div>
</script>
<script type="text/x-jquery-tmpl" id="shop-tips-tmpl">
    <div class="row">
    <div class="col-md-12">
        <small>注意：</small>
        {{if data.ztc_budget && data.ztc_budget>0}}
            <span class="tag">直通车预算${data.ztc_budget}元</span>
        {{/if}}
         {{if data.zuanshi_budget && data.zuanshi_budget>0}}
            <span class="tag">智钻预算${data.zuanshi_budget}元</span>
        {{/if}}
        {{if data.tag_list}}
            {{each(i,v) data.tag_list}}
                <span class="tag">${v}</span>
            {{/each}}
       {{/if}}
    </div>
   </div>
</script>
<script type="application/javascript">

    $(document).ready(function(){

        $(".top-ul>li").eq(0).addClass("top-li-hover");


        $(".c-pager").jPager({currentPage: <?php echo $pager["page"]-1;?>, total: <?php echo $pager["count"];?>, pageSize: <?php echo $pager["page_size"];?>,events: function(dp){
            location.href = app.url("<?php echo $this->createUrl('/main/default/index');?>",{page:dp.index+1})
        }});

        $('.dropify').dropify();

        $("a[data-type=file]").click(function(e) {
            e.preventDefault();
            var self = $(this);
            self.tab("show");
            var target = $(self.attr("href")).find("[data-role=shop-file-list]");
            target.iLoad();
        });


        $('#ShopFileUploadModal').on('show.bs.modal', function (event) {
            var self = $(this);
            var button = $(event.relatedTarget); // Button that triggered the modal
            self.find("input[name=nick]").val(button.attr("data-nick"));
            self.find("input[name=creator]").val(button.attr("data-creator"));
            self.find("[data-click=fileupload]").attr("data-trigger-target",button.attr("data-trigger-target"));
        });

        $("[data-click=fileupload]").click(function(){
            var nick = $("#ShopFileUploadModal").find("input[name=nick]").val();
            var creator = $("#ShopFileUploadModal").find("input[name=creator]").val();
            var target = $($(this).attr("data-trigger-target")).find("[data-load=overlay]");

            $.ajaxFileUpload({
                url: '<?php echo $this->createUrl("/file/default/upload");?>',
                type: 'post',
                secureuri: false, //一般设置为false
                fileElementId: 'file', // 上传文件的id、name属性名
                dataType: 'json', //返回值类型，一般设置为json、application/json
                elementIds: {}, //传递参数到服务器
                success: function(resp, status){
                    $("#ShopFileUploadModal").modal('hide');
                    $.ajax({
                        url:"<?php echo $this->createUrl("/main/file/add");?>",
                        type:"post",
                        dataType:"json",
                        data:{nick:nick,creator:creator,file_md5:resp.data.md5,file_name:resp.data.name},
                        success:function(){
                            target.iLoad();
                        }
                    })
                },
                error: function(data, status, e){
                    app.error("上传失败，请确认网络连接是否正常后请重试!");
                }
            });
        });

    });


</script>

