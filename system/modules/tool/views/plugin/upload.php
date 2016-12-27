
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
                            <a href="<?php echo $this->createUrl("/tool/plugin/upload");?>"><span class="label label-info">插件管理</span></a>

                            <a href="http://yunying.da-mai.com" target="_blank"><span class="label label-default">运营系统</span></a>
                            <a href="http://idea.da-mai.com" target="_blank"><span class="label label-default">创意中心</span></a>
                            <a href="http://run.da-mai.com" target="_blank"><span class="label label-default">运维系统</span></a>

                        </small>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row" style="margin-bottom: 15px"></div>

    <form id="plugin-setting-form" class="form-horizontal">
        <div class="form-group">
            <label class="col-sm-2 control-label">版本:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="version"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">文件:</label>
            <div class="col-sm-10">
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

        $(".top-ul>li").eq(3).addClass("top-li-hover");

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
                        url: "<?php echo $this->createUrl("/tool/plugin/set");?>",
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