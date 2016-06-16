<form action="<?php echo $this->createUrl("/file/default/upload");?>" method="post" enctype="multipart/form-data">
    <input type="file" name="file" class="dropify" id="file" data-height="300" data-max-file-size="2M"/>
    <input type="button" data-click="fileupload" class="btn btn-warning" value="确定">
</form>

<script src='<?php echo STATICURL."/base/js/plugins/ajaxfileupload/ajaxfileupload.js"; ?>'></script>


<script type="application/javascript">

    $(document).ready(function(){

        $(".top-ul>li").eq(2).addClass("top-li-hover");

        $('.dropify').dropify();

        $("[data-click=fileupload]").click(function(){
            $.ajaxFileUpload({
                url: '<?php echo $this->createUrl("/file/default/upload");?>',
                type: 'post',
                secureuri: false, //一般设置为false
                fileElementId: 'file', // 上传文件的id、name属性名
                dataType: 'json', //返回值类型，一般设置为json、application/json
                elementIds: {}, //传递参数到服务器
                success: function(data, status){
                    console.log(data);
                },
                error: function(data, status, e){
                    console.log(e);
                }
            });
        });

    });

</script>

