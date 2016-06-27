
<link rel="stylesheet" href="<?php echo STATICURL.'/base/css/index.css'; ?>">
<link rel="stylesheet" href="<?php echo STATICURL.'/main/css/index.css'; ?>">
<div class="index-table-div">
    <form id="plugin-setting-form" class="form-horizontal">
        <div class="form-group">
            <label class="col-sm-2 control-label">版本:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="version"/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <input type="file" name="file" class="dropify" id="file" data-height="300" data-max-file-size="2M" />

            </div>
        </div>
        <div class="form-group">
            <input type="button" data-click="fileupload" class="btn btn-warning" value="确定">
        </div>
    </form>
</div>
<script src='<?php echo STATICURL."/base/js/plugins/ajaxfileupload/ajaxfileupload.js"; ?>'></script>

<script type="text/javascript">
    $(document).ready(function() {

        $(".top-ul>li").eq(0).addClass("top-li-hover");

        $('.dropify').dropify();

        $("[data-click=fileupload]").click(function () {
            var version = $("#plugin-setting-form").find("input[name=version]").val();

            $.ajaxFileUpload({
                url: '<?php echo $this->createUrl("/file/default/upload");?>',
                type: 'post',
                secureuri: false, //一般设置为false
                fileElementId: 'file', // 上传文件的id、name属性名
                dataType: 'json', //返回值类型，一般设置为json、application/json
                elementIds: {}, //传递参数到服务器
                success: function (resp, status) {
                    $.ajax({
                        url: "<?php echo $this->createUrl("/main/plugin/set");?>",
                        type: "post",
                        dataType: "json",
                        data: {version: version, file_md5: resp.data.md5},
                        success: function () {
                            app.alert("设置成功!");
                        }
                    })
                },
                error: function (data, status, e) {
                    app.error("上传失败，请确认网络连接是否正常后请重试!");
                }
            });
        });
    });


</script>