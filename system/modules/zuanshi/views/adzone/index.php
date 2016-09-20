<link rel="stylesheet" href="<?php echo STATICURL.'/main/css/index.css'; ?>">

<div class="index-table-div">

    <div class="search-box">
        <div class="shop-list-cont">
            <div class="row">
                <div class="col-md-4">
                    <div class="com-list-tit" style="display: block;">
                        <span class="shop-list-icon"></span>
                        <span class="shop-list-txt">工具:</span>
                        <small>
                            <a href="<?php echo $this->createUrl("/zuanshi/adzone/index");?>"><span class="label label-info">钻展资源位</span></a>
                            <a href="<?php echo $this->createUrl("/dmp/tag/index");?>"><span class="label label-default">DMP标签</span></a>
                        </small>
                    </div>
                </div>
                <div class="col-md-4">

                </div>

                <div class="col-md-3">

                </div>
                <div class="col-md-1">
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 10px;margin-bottom: 10px;">
    </div>

    <table class="baby-frame-table" id="table-fixed" style="table-layout: fixed;">
        <thead class="header">
        <tr><th>资源位编号</th><th>资源信息</th><th>可裂变尺寸</th><th>资源类型</th><th>标签</th><th>操作</th></tr>
        </thead>
        <tbody>
        <?php foreach($list as $row):?>
            <tr>
                <td><?php echo $row["adzoneId"];?></td>
                <td><?php echo $row["adzoneName"];?></td>
                <td><p class="w2" title=" <?php echo $row["adzoneSize"];?>"> <?php echo $row["adzoneSize"];?></p></td>
                <td><?php echo $row["type"];?></td>
                <td>
                    <div data-role="reader">
                        <?php if(!empty($row["tag"]) && !empty($row["tag"]["tags"])):?>
                            <?php
                            $tags = @explode(",",$row["tag"]["tags"]);
                            foreach($tags as $tag){
                                echo ' <span class="label label-info">'.$tag.'</span> ';
                            }
                            ?>
                        <?php endif;?>
                        <i class="glyphicon glyphicon-cog" style="cursor: pointer"></i>
                    </div>

                    <!-- Single button -->
                    <div data-role="input" class="btn-group" style="display: none">
                        <form action="<?php echo $this->createUrl("/zuanshi/adzone/tagset");?>" method="post">
                            <input type="hidden" name="adzoneId" value="<?php echo $row["adzoneId"];?>">
                        <div class="form-group">
                            <?php
                            if(!empty($row["tag"]) && !empty($row["tag"]["tags"])) {
                                $tags = explode(",", $row["tag"]["tags"]);
                            }else{
                                $tags = array();
                            }
                            $adzoneTags = \application\modules\zuanshi\model\AdzoneTag::$TAGS;
                            foreach($adzoneTags as $tag):?>
                             <label class="checkbox-inline"><input type="checkbox" name="tags[]" value="<?php echo $tag;?>" <?php if(in_array($tag,$tags)):?>checked<?php endif;?>><?php echo $tag;?></label>
                            <?php endforeach;?>
                        </div>

                        <input type="button" data-role="adzone-tag-btn"  class="btn btn-default" value="确定" />
                        </form>
                    </div>

                </td>
                <td>
                    <a class="adzone-del-btn" data-id="<?php echo $row["id"];?>"><i class="glyphicon glyphicon-trash"></i></a>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>


    <script type="application/javascript">

        $(document).ready(function(){
            var self = $(this);

            $(".top-ul>li").eq(2).addClass("top-li-hover");

            $("#table-fixed").freezeHeader();

            $(".adzone-del-btn").click(function(event){
                var id = $(this).attr("data-id");
               app.confirm("是否要删除该资源位?",function(){
                   $.ajax({url:"<?php echo $this->createUrl("/zuanshi/adzone/del");?>",data:{id:id},type:"post",dataType:"json",success:function(){
                       location.reload();
                   }})
               });
            });

        });

        $("[data-role=reader] i").click(function(){
            var a=$(this).parents("[data-role=reader]"),b = $(this).parents("[data-role=reader]").siblings("[data-role=input]");
            a.hide() && b.show();
        });

        $("[data-role=adzone-tag-btn]").click(function(){
            var form = $(this).parents("form");
            $.ajax({
                url:form.attr("action"),
                type:"post",
                data:form.serialize(),
                dataType:"json",
                success:function(resp){
                    $("body").hideLoading();
                    location.reload();

                },
                beforeSend:function(){
                    $("body").showLoading();
                },
                error:function(){
                    $("body").hideLoading();
                }
            })
        })
    </script>

