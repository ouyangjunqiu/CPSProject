<link rel="stylesheet" href="<?php echo STATICURL.'/main/css/index.css'; ?>">
<style>
    .w100{
        width: 100px;
    }

    .p_in {
        border: none;
        font-weight: bold;
        line-height: 28px;
        text-align: center;
        width: 60px;
        border-bottom: 1px solid #e2e2e2;
    }
</style>
<div class="index-table-div">

    <div class="search-box">
        <div class="shop-list-cont" id="plan-fixed-header">
            <div class="row">
                <div class="col-md-3">
                    <div class="com-list-tit" style="display: block;">
                        <span class="shop-list-icon"></span>
                        <span class="shop-list-txt"><?php echo $query["nick"];?></span>
                    </div>
                </div>
                <div class="col-md-8">


                </div>
                <div class="col-md-1">

                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 10px;margin-bottom: 10px;">
            <div class="col-md-12">
                <form action="<?php echo $this->createUrl("/zuanshi/setting/adzone");?>" method="post" class="form-inline">
                    <input type="hidden" name="nick" value="<?php echo $query["nick"];?>"/>
                    <div class="form-group">
                        <?php foreach(\application\modules\zuanshi\model\AdzoneTag::$TAGS as $tag):?>
                        <label class="checkbox-inline"><input type="checkbox" name="tags[]" value="<?php echo $tag;?>" <?php if(in_array($tag,$query["tags"])):?>checked<?php endif;?>><?php echo $tag;?></label>
                        <?php endforeach;?>
                    </div>

                    <div class="form-group">
                        <input placeholder="资源位搜索" type="text" class="form-control" name="keyword" value="<?php echo $query["keyword"];?>">
                    </div>

                    <input type="button" class="btn btn-warning" value="搜索" id="searchBtn">
                </form>


            </div>
        </div>


        <?php if(empty($list)):?>
            <div class="baby-frame-cont">
                <p>暂无资源位信息！</p>
            </div>
        <?php else:?>
            <form id="shop-selector-form">
                <input type="hidden" name="nick" value="<?php echo $query["nick"];?>"/>
                <table class="baby-frame-table">
                    <thead>
                    <tr>
                        <td><small>选择</small></td>
                        <td><small>资源信息</small></td>
                        <td><small>尺寸</small></td>
                        <td><small>标签</small></td>
                    </tr>

                    </thead>
                    <tbody>

                    <?php foreach($list as $row):?>
                        <tr data-list="adzones">
                            <td>
                                <input class="shiftCheckbox" type="radio" name="adzone[]" value="<?php echo $row["adzoneId"];?>,<?php echo $row["type"];?>" <?php if(isset($row["isSelect"]) && $row["isSelect"]):?>checked="checked"<?php endif;?> />
                            </td>
                            <td><strong><?php echo $row["adzoneName"];?></strong></td>
                            <td>
                               <p class="w2" title=" <?php echo $row["adzoneSize"];?>"> <?php echo $row["adzoneSize"];?></p>
                            </td>
                            <td>
                                <?php if(!empty($row["tag"]) && !empty($row["tag"]["tags"])):?>
                                    <?php
                                    $tags = @explode(",",$row["tag"]["tags"]);
                                    foreach($tags as $tag){
                                        echo ' <span class="label label-info">'.$tag.'</span> ';
                                    }
                                    ?>
                                <?php endif;?>
                            </td>

                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
                <div style="height: 60px"></div>
                <div style="position: fixed;bottom: 0px;width: 100%;background: white; height: 100px;line-height: 100px;">
                    <div class="row">

                        <div class="col-md-2">
                            <small>出价：</small><input type="text" class="p_in" name="price" value="<?php echo $setting["price"];?>"/>
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-primary" data-click="shopbtn"  data-target-url="<?php echo $this->createUrl("/zuanshi/setting/vie",array("nick"=>$query["nick"]));?>">下一步，设置竞品</button>
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-primary" data-click="shopbtn" data-target-url="<?php echo $this->createUrl("/zuanshi/setting/dmp",array("nick"=>$query["nick"]));?>">下一步，设置人群</button>
                        </div>
                        <div class="col-md-2">
                            <input type="button" class="btn btn-default" value="上一步" id="backBtn">
                        </div>

                    </div>
                </div>
            </form>
        <?php endif;?>

    </div>
</div>

<script type="application/javascript">


    $(document).ready(function(){

        $("#backBtn").click(function(){
            window.location.href='<?php echo $this->createUrl("/zuanshi/setting/index2",array("nick"=>$query["nick"]));?>';
        });

        $("#searchBtn").click(function(){
            $(this).parents("form").submit();
        });

//        var selectFn  = function(){
//            var selectCount = 0;
//
//            $("[data-list=adzones] .shiftCheckbox").each(function(){
//                if(this.checked){
//                    selectCount++;
//                }
//
//            });
//
//            $("#select_count").html(selectCount);
//        };
//
//        selectFn();

        $("button[data-click=shopbtn]").click(function(){
            var target = $(this).attr("data-target-url");
            var form = $(this).parents("form");
            $.ajax({
                url:"<?php echo $this->createUrl('/zuanshi/setting/bindadzone');?>",
                type:"post",
                data:form.serialize(),
                dataType:"json",
                success:function(resp){
                    $("body").hideLoading();
                    if(resp.isSuccess) {
                        app.confirm("保存成功,确定进入下一步?",function(){
                            window.location.href = target;
                        });
                    }else{
                        app.error('添加失败');
                    }
                },
                beforeSend:function(){
                    $("body").showLoading();
                },
                error:function(){
                    $("body").hideLoading();
                }
            })

        });
//        $("#shop-selector-form").click(function(){
//            selectFn();
//        });
//
//        $(".select-all").click(function(){
//            $("[data-list=adzones] .shiftCheckbox").each(function () {
//                this.checked = true;
//            });
//            selectFn();
//        });
//
//        $(".not-select-all").click(function(){
//            $("[data-list=adzones] .shiftCheckbox").each(function () {
//                this.checked = false;
//            });
//            selectFn();
//        });
//        $(".re-select-all").click(function(){
//            $("[data-list=adzones] .shiftCheckbox").each(function () {
//                if(this.checked)
//                    this.checked = false;
//                else
//                    this.checked = true;
//            });
//            selectFn();
//        });
//
//        $("#checker-all").click(function(){
//            if (this.checked) {
//
//                $("[data-list=adzones] .shiftCheckbox").each(function () {
//                    this.checked = true;
//                });
//            }
//            else {
//                $("[data-list=adzones] .shiftCheckbox").each(function () {
//                    this.checked = false;
//                });
//            }
//            selectFn();
//        });
//
//        $('.shiftCheckbox').shiftcheckbox();


//        var data = ["1680x400","1620x90","1180x500","1000x90","990x95","990x90","960x90","950x90","940x180","940x107","920x300","900x600","800x450","800x90","760x100","760x90","750x90","740x230","730x300","728x90","720x450","720x410","720x290","700x90","700x60","642x250","640x480","640x400","640x320","640x300","640x290","640x200","640x110","640x100","640x90","610x100","600x500","600x220","600x150","600x80","590x180","586x325","520x280","480x580","480x70","400x300","375x130","360x242","336x280","320x285","320x200","300x600","300x400","300x350","300x300","300x250","300x150","300x125","300x110","300x100","300x50","280x406","280x370","280x230","270x440","260x200","260x90","256x213","250x250","250x200","250x155","240x355","240x200","210x220","205x332","200x500","200x300","200x250","200x240","200x200","190x90","190x43","186x275","170x200","168x175","168x76","160x310","160x200","150x250","145x165","130x280","120x240","110x300","0x1","0x0"];
//        var b = [];
//        for(var i in data){
//            b.push({id:data[i],text:data[i]});
//        }

        //$("select[data-role=size]").select2({data:b,width:400});


    });
</script>

