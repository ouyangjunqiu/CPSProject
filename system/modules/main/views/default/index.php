<?php
$user = \cloud\core\utils\Env::getUser();
$username = empty($user)?"游客":$user["username"];
?>
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
                        <ul class="nav nav-tabs shop-nav" role="tablist">
                            <li role="presentation" class="active"><a href="#todo_<?php echo $row["id"];?>" title="待办事项" aria-controls="todo_<?php echo $row["id"];?>" role="tab" data-toggle="tab" aria-expanded="true">
                                    <i class="fa fa-th-list"></i><span>待办事项</span></a>
                            </li>
                            <li role="presentation"><a href="#file_<?php echo $row["id"];?>" title="云共享" aria-controls="file_<?php echo $row["id"];?>" role="tab" data-toggle="tab" aria-expanded="true">
                                    <i class="fa fa-cloud"></i><span>云共享</span></a>
                            </li>
                        </ul>

                        <div class="tab-content">

                            <div role="tabpanel" class="tab-pane active" id="todo_<?php echo $row["id"];?>">

                                <div class="overlay-wrapper" data-load="overlay" data-tmpl="shop-todo-list-tmpl" data-role="shop-todo-list" data-nick="<?php echo $row["nick"];?>" data-url="<?php echo $this->createUrl("/main/todo/getbynick",array("nick"=>$row["nick"]));?>">
                                </div>
                                <div class="row">

                                    <div class="col-md-11">
                                    </div>
                                    <div class="col-md-1">
                                        <a href="<?php echo $this->createUrl("/main/todo/more",array("nick"=>$row["nick"]));?>"><small>更多..</small></a>
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="file_<?php echo $row["id"];?>">
                                <div class="overlay-wrapper" data-load="overlay" data-tmpl="shop-file-list-tmpl" data-role="shop-file-list" data-nick="<?php echo $row["nick"];?>" data-url="<?php echo $this->createUrl("/main/file/getbynick",array("nick"=>$row["nick"]));?>">
                                </div>

                                <a data-toggle="modal" data-target="#ShopFileUploadModal" data-backdrop="false" data-logdate-index="1" data-nick="<?php echo $row["nick"];?>" data-creator="<?php echo $username;?>" data-trigger-target="#todo_<?php echo $row["id"];?>">
                                    <i class="fa fa-cloud-upload"></i> 上传文件...
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
                <h4 class="modal-title" id="exampleModalLabel">新建待办事项</h4>
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


<?php $this->widget("application\\modules\\main\\widgets\\ShopTodoWidget");?>

<script src='<?php echo STATICURL."/base/js/plugins/ajaxfileupload/ajaxfileupload.js"; ?>'></script>

<script type="text/x-jquery-tmpl" id="shop-file-list-tmpl">
    <div class="list-group">

       {{each(i,v) data.list}}

         <a class="list-group-item" href="<?php echo $this->createUrl("/file/default/down");?>&md5=${v.file_md5}" target="_blank">
              <strong>${v.file_name}</strong><small>${v.logdate}</small>
         </a>

       {{/each}}
   </div>
</script>

<script type="application/javascript">

    $(document).ready(function(){

        $(".top-ul>li").eq(0).addClass("top-li-hover");


        $(".c-pager").jPager({currentPage: <?php echo $pager["page"]-1;?>, total: <?php echo $pager["count"];?>, pageSize: <?php echo $pager["page_size"];?>,events: function(dp){
            location.href = app.url("<?php echo $this->createUrl('/main/default/index');?>",{page:dp.index+1})
        }});

        $('.dropify').dropify();


        $('#ShopFileUploadModal').on('show.bs.modal', function (event) {
            var self = $(this);
            var button = $(event.relatedTarget); // Button that triggered the modal
            self.find("input[name=nick]").val(button.data("nick"));
            self.find("input[name=creator]").val(button.data("creator"));
            self.find("[data-click=fileupload]").attr("data-trigger-target",button.data("trigger-target"));
        });

        $("[data-click=fileupload]").click(function(){
            var nick = $("#ShopFileUploadModal").find("input[name=nick]").val();
            var creator = $("#ShopFileUploadModal").find("input[name=creator]").val();
            var target = $($(this).data("trigger-target")).find("[data-load=overlay]");
            $.ajaxFileUpload({
                url: '<?php echo $this->createUrl("/file/default/upload");?>',
                type: 'post',
                secureuri: false, //一般设置为false
                fileElementId: 'file', // 上传文件的id、name属性名
                dataType: 'json', //返回值类型，一般设置为json、application/json
                elementIds: {}, //传递参数到服务器
                success: function(resp, status){
                    $.ajax({
                        url:"<?php echo $this->createUrl("/main/file/add");?>",
                        type:"post",
                        dataType:"json",
                        data:{nick:nick,creator:creator,file_md5:resp.data.md5,file_name:resp.data.name},
                        success:function(){

                            $("#ShopFileUploadModal").modal('hide');
                            target.DataLoad();

                        }
                    })
                },
                error: function(data, status, e){
                    console.log(e);
                }
            });
        });

    });


</script>

