<link rel="stylesheet" href="<?php echo STATICURL.'/base/css/index.css'; ?>">
<link rel="stylesheet" href="<?php echo STATICURL.'/main/css/index.css'; ?>">

<div class="index-table-div">

    <div class="search-box">
        <div class="shop-list-cont" id="plan-fixed-header">
            <div class="row">
                <div class="col-md-4">
                    <div class="com-list-tit" style="display: block;">
                        <span class="shop-list-icon"></span>
                        <span class="shop-list-txt"><?php echo $query["nick"];?></span>
                    </div>
                </div>
                <div class="col-md-7">
                    <small>店铺日预算：</small><span class="type"><span class="glyphicon glyphicon-yen"></span> <?php echo round($plan["budget"]);?></span>
                </div>


                <div class="col-md-1">
                    <input type="button" class="btn btn-default" value="返回" id="searchBtn">
                </div>
        </div>
    </div>
    <table class="table-frame">
        <tbody id="babyInforTb">
        <?php foreach($cases as $row):?>
            <tr>
                <td class="check-infor-td" style="width: 250px">
                    <div class="baby-box">
                        <div class="baby-trusteeship">

                            <h3 class="baby-frame-h3">
                                <i class="tit-frame-icon"></i>
                                <?php echo $row["casetype"];?>
                                <o class="tit"><i class="glyphicon glyphicon-yen"></i><?php echo round($row["budget"]);?></o>
                            </h3>
                            <p>
                                <a href="<?php echo $row["luodiye"];?>" target="_blank">
                                    <small style="color:#828282">
                                       [<?php echo $row["luodiye_type"];?>]
                                    </small>
                                    <?php echo !empty($row["luodiye_alias"])?$row["luodiye_alias"]:(strlen($row["luodiye"])>100?substr($row["luodiye"],0,100)."...":$row["luodiye"]);?>
                                </a>
                            </p>
                            <p>
                               <a href="<?php echo $this->createUrl("/dmp/group/view",array("nick"=>$query["nick"],"caseid"=>$row["id"]));?>">  <small style="color:#828282">达摩盘标签应用>></small></a>
                            </p>

                        </div>
                    </div>
                </td>
                <td>

                        <?php if(empty($row["run"])):?>
                        <div class="baby-frame-cont">
                            <p>暂推广方案，赶紧创建一个吧！</p>
                        </div>
                        <?php else:?>
                            <div class="row" style="padding-bottom: 5px">
                                <div class="col-md-2">
                                    <small>推广渠道</small>
                                </div>
                                <div class="col-md-1">
                                    <small>上周花费</small>
                                </div>
                                <div class="col-md-1">
                                    <small>上周ROI</small>
                                </div>
                                <div class="col-md-1">
                                    <small>日预算</small>
                                </div>
                                <div class="col-md-6">
                                    <small>How to do?</small>
                                </div>
                                <div class="col-md-1">
                                </div>
                            </div>
                            <?php foreach($row["run"] as $run):?>
                                <div class="row <?php if($run["budget"]<=0):?>ns<?php endif;?>" editor="run" style="padding-bottom: 5px">
                                    <form>
                                        <div class="col-md-2">
                                            <input type="hidden" name="runid" value="<?php echo $run["id"];?>"/>
                                            <strong><?php echo $run["dept"];?></strong>
                                        </div>
                                        <div class="col-md-1">
                                            <?php if(!isset($row["rpt"]) || !isset($row["rpt"][$run["dept"]])):?>
                                                -
                                            <?php else:?>
                                                <?php echo @round($row["rpt"][$run["dept"]]["cost"]);?>
                                            <?php endif;?>
                                        </div>
                                        <div class="col-md-1">
                                            <?php if(!isset($row["rpt"]) || !isset($row["rpt"][$run["dept"]])):?>
                                                -
                                            <?php else:?>
                                                <?php echo @$row["rpt"][$run["dept"]]["roi"];?>
                                            <?php endif;?>
                                        </div>
                                        <div class="col-md-1">
                                             <span data-reader="caserun">
                                                 <?php if($run["budget"]>0):?>
                                                    <small><i class="glyphicon glyphicon-yen"></i></small><?php echo round($run["budget"]);?>
                                                <?php else:?>
                                                     <span class="type">
                                                        不投放
                                                     </span>
                                                <?php endif;?>
                                             </span>
                                              <span data-editor="caserun" style="display: none">
                                                   <input type="text" value="<?php echo round($run["budget"]);?>" class="name_writer" name="budget"/>
                                              </span>
                                        </div>
                                        <div class="col-md-6">
                                               <span data-reader="caserun">
                                                 <?php echo $run["remark"];?>
                                               </span>
                                                <span data-editor="caserun" style="display: none">
                                                    <textarea name="remark" class="s"><?php echo $run["remark"];?></textarea>
                                                </span>
                                        </div>
                                        <div class="col-md-1">
                                            <a class="editor-btn"  data-run-id="<?php echo $run["id"];?>" data-reader="caserun"><i class="glyphicon glyphicon-pencil"></i></a>
                                            <a class="save-btn"  data-run-id="<?php echo $run["id"];?>" data-editor="caserun" style="display: none"><i class="glyphicon glyphicon-floppy-disk"></i></a>
                                        </div>
                                    </form>
                                </div>
                            <?php endforeach;?>
                        <div class="row">
                            <div class="col-md-12">
                            </div>
                        </div>
                        <?php endif;?>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>

    <div id="dialog-window" ></div>

<script type="application/javascript">


    $(document).ready(function(){

        $(".top-ul>li").eq(0).addClass("top-li-hover");

        $("#searchBtn").click(function(){
            window.location.href='<?php echo $this->createUrl("/main/default/index");?>';
        });

        $(".row[editor=run]").delegate(".editor-btn","click",function(event){

            $(event.delegateTarget).find("[data-reader=caserun]").hide();
            $(event.delegateTarget).find("[data-editor=caserun]").show();
            $(event.delegateTarget).find("input[name=budget]").focus();

        });

        $(".row[editor=run]").delegate(".save-btn","click",function(event){
            var form = $(event.delegateTarget).find("form");
            var data = form.serialize();
            $.ajax({
                url:"<?php echo $this->createUrl('/main/caserun/modify');?>",
                type:"post",
                data:data,
                dataType:"json",
                success:function(resp){
                    if(resp.isSuccess) {
                        location.reload();
                    }
                },
                beforeSend:function(){
                    $("body").showLoading();
                },
                error:function(){
                    alert("保存失败，请重试!");
                    $("body").hideLoading();
                }
            });

        });

        $(".row[editor=run]").delegate("input","keydown",function(event){
            var btn = $(event.delegateTarget).find(".save-btn");
            if(event.which == 13){
                btn.trigger("click");
                return false;
            }

        });

        var t = $("#plan-fixed-header").offset().top+$("#plan-fixed-header").height();
        $(window).scroll(function(event){

            var top = $(window).scrollTop();
            if(top>t){
                $("#plan-fixed-header").addClass("header-fixed");
            }else{
                $("#plan-fixed-header").removeClass("header-fixed");
            }
        });

    });
</script>

