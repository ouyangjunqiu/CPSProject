<link rel="stylesheet" href="<?php echo STATICURL.'/main/css/index.css'; ?>">

<div class="index-table-div">

    <div class="search-box">
        <div class="shop-list-cont" id="plan-fixed-header">
            <div class="row">
                <div class="col-md-4">
                    <div class="com-list-tit" style="display: block;">
                        <span class="shop-list-icon"></span>
                        <span class="shop-list-txt"><?php echo $nick;?></span>
                    </div>
                </div>
                <div class="col-md-7">
                </div>
                <div class="col-md-1">
                    <input type="button" class="btn-orange" value="返回" id="backBtn">
                </div>
            </div>
        </div>
        <table class="table-frame">
            <tbody id="babyInforTb">
                <tr>
                    <td class="check-infor-td" style="min-width: 250px">
                        <div class="baby-box">
                            <div class="baby-trusteeship baby-frame-box">

                                <h3 class="baby-frame-h3">
                                    <i class="tit-frame-icon"></i>
                                    <?php echo $case["casetype"];?>

                                </h3>
                                <p>
                                    <a href="<?php echo $case["luodiye"];?>" target="_blank">
                                        <small style="color:#828282">
                                            [<?php echo $case["luodiye_type"];?>]
                                        </small>
                                        <?php echo !empty($case["luodiye_alias"])?$case["luodiye_alias"]:(strlen($case["luodiye"])>100?substr($case["luodiye"],0,100)."...":$case["luodiye"]);?>
                                    </a>
                                </p>
                                <p class="dayBudget-p"><i class="glyphicon glyphicon-yen"></i><?php echo round($case["budget"]);?><small>元</small></p>

                            </div>
                        </div>
                    </td>
                    <td>
                            <div class="row" style="padding-bottom: 5px">
                                <div class="col-md-2">
                                    <small>推广渠道</small>
                                </div>
                                <div class="col-md-2">
                                    <small>日预算</small>
                                </div>
                                <div class="col-md-7">
                                    <small>How to do?</small>
                                </div>
                                <div class="col-md-1">
                                </div>
                            </div>
                            <?php foreach($runs as $run):?>
                                <div class="row <?php if($run["budget"]<=0):?>ns<?php endif;?>" style="padding-bottom: 5px">
                                    <form>
                                        <div class="col-md-2">
                                            <strong><?php echo $run["dept"];?></strong>
                                        </div>
                                        <div class="col-md-2">
                                             <span data-reader="caserun">
                                                 <?php if($run["budget"]>0):?>
                                                     <small><i class="glyphicon glyphicon-yen"></i></small><?php echo round($run["budget"]);?>
                                                 <?php else:?>
                                                     <span class="type">
                                                        不投放
                                                     </span>
                                                 <?php endif;?>
                                             </span>
                                        </div>
                                        <div class="col-md-7">
                                               <span data-reader="caserun">
                                                 <?php echo $run["remark"];?>
                                               </span>
                                        </div>
                                    </form>
                                </div>
                            <?php endforeach;?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="tab" style="margin: 20px">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#home_16" aria-controls="home_16" role="tab" data-toggle="tab">使用足迹</a></li>
            <li role="presentation"><a href="#zhanghuo_16" aria-controls="zhanghuo_16" role="tab" data-toggle="tab">新增标签组合</a></li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home_16" data-role="shop-base-info">
                <table class="baby-frame-table">
                    <thead>
                    <tr><td>标签组合</td><td>落地页类目<small>(1级)</small></td><td>落地页类目<small>(2级)</small></td><td>效果指数</td><td>记录日期</td></tr>
                    </thead>
                    <tbody>
                    <?php foreach($groups as $group):?>
                    <tr>
                        <td>
                            <span><?php echo implode("<br/>",explode(",",$group["tag_names"]));?></span>
                        </td>
                        <td>
                            <span><?php echo $group["t0"];?></span>
                        </td>
                        <td>
                            <span><?php echo $group["t1"];?></span>
                        </td>
                        <td>
                            <div class="star"  <?php if($group["isfinish"] != 1):?>editor="group_qscore_editor"<?php endif;?> data-id="<?php echo $group["id"];?>">
                                <ul>
                                    <?php for($i=1;$i<=5;$i++):?>
                                        <?php if(isset($group["qscore"]) && $group["qscore"]>=$i):?>
                                            <li class="on"> <a href="javascript:;"><?php echo $i;?></a></li>
                                        <?php else:?>
                                            <li> <a href="javascript:;"><?php echo $i;?></a></li>
                                        <?php endif;?>
                                    <?php endfor;?>
                                </ul>
                            </div>
                        </td>
                        <td>
                            <span><?php echo $group["log_date"];?></span>
                        </td>
                    </tr>
                    <?php endforeach;?>

                    </tbody>
                </table>

            </div>
            <div role="tabpanel" class="tab-pane" id="zhanghuo_16" data-role="shop-taobao-info">
                <form action="<?php echo $this->createUrl("/dmp/group/add");?>" method="post">
                    <input type="hidden" value="<?php echo $nick;?>" name="nick" />
                    <input  type="hidden" value="<?php echo $case["id"];?>" name="caseid">
                    <input  type="hidden" value="<?php echo $case["casetype"];?>" name="casetype">
                    <div class="container-fluid">
                        <div class="row" style="padding: 10px">
                            <div class="col-md-3"><small>落地页类目(1级):</small></div>
                            <div class="col-md-9">
                                <input type="text" value="" class="name_writer" name="t0" />
                            </div>

                        </div>
                        <div class="row" style="padding: 10px">
                            <div class="col-md-3"><small>落地页类目(2级):</small></div>
                            <div class="col-md-9">
                                <input type="text" value="" class="name_writer" name="t1" />
                            </div>
                        </div>
                        <div class="row" style="padding: 10px">
                            <div class="col-md-3"><small>标签组合:</small></div>
                            <div class="col-md-9">
                                <select name="tag_ids[]" data-role="tags" multiple="multiple" style="400px"></select>
                            </div>
                        </div>

                        <div class="row" style="padding: 10px">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-primary" data-click="pic-save">保存</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

        </div>

    </div>
</div>
<script type="application/javascript">
    $(document).ready(function(){

        $(".top-ul>li").eq(0).addClass("top-li-hover");

        $("#backBtn").click(function(){
            window.location.href='<?php echo $this->createUrl("/main/caserun/index2",array("nick"=>$nick));?>';
        });

        $('div[editor="group_qscore_editor"]').Score({callback:function(cfg,selector){
            var id = $(selector).attr("data-id");

            app.confirm("是否要评分",function(){
                console.log(cfg.starAmount,id);
                $.ajax({
                    url:"<?php echo $this->createUrl("/dmp/group/data");?>",
                    data:{id:id,qscore:cfg.starAmount},
                    dataType:"json",
                    type:"post",
                    success:function(resp){
                        location.reload();
                    }
                })
            });

        }});
//
        $('select[data-role="tags"]').select2({
            data:<?php echo $tags;?>,
            maximumSelectionLength:5,
            width:500
        });

        $('button[data-click="pic-save"]').click(function(){
            var form = $(this).parents("form");
            $.ajax({
                url:form.attr("action"),
                type:form.attr("method"),
                data:form.serialize(),
                dataType:"json",
                success:function(resp){
                    if(resp.isSuccess){
                        location.reload();
                    }
                }
            });
        });
    });
</script>