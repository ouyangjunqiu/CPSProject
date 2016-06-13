<link rel="stylesheet" href="<?php echo STATICURL.'/base/css/index.css'; ?>">
<link rel="stylesheet" href="<?php echo STATICURL.'/main/css/index.css'; ?>">
<script src='<?php echo STATICURL."/main/js/shop.js"; ?>'></script>
<style type="text/css">
    .time-h{
        position: absolute;
        top: 20px;
        left: 15px;
    }
</style>

<div class="index-table-div">

    <div class="search-box">
        <div class="shop-list-cont" id="shop-search">
            <div class="search-log" style="display: none;"> </div>
            <div class="search-left com-list-tit" style="display: block;">
                <span class="shop-list-icon"></span>
                <span class="shop-list-txt">智·钻</span><small>
                    <a href="<?php echo $this->createUrl("/zuanshi/dashboard/index");?>"><span class="label label-info">实时状况</span></a>
                    <a href="<?php echo $this->createUrl("/zuanshi/rpt/index");?>"><span class="label label-default">全店推广报表</span></a>
                    <a href="<?php echo $this->createUrl("/zuanshi/summary/index");?>"><span class="label label-default">店铺统计报表</span></a>
                    <a href="<?php echo $this->createUrl("/zuanshi/summary/pic");?>"><span class="label label-default">人员统计报表</span></a>

                </small>

            </div>
            <div class="search-right">
                <?php $this->widget("application\\modules\\main\\widgets\\ShopSearchWidget",array("url"=>$this->createUrl("/zuanshi/dashboard/index",array("page"=>1)),"query"=>$query));?>

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
                    <div class="baby-box">
                        <div class="baby-trusteeship baby-frame-box" data-nick="<?php echo $row["nick"];?>" data-role="list">

                            <div class="row">
                                <div class="col-md-4">
                                    <h3 class="baby-frame-h3">
                                        <i class="tit-frame-icon"></i>
                                        实时状况
                                    </h3>
                                </div>
                                <div class="col-md-7">
                                </div>
                                <div class="col-md-1">

                                    <small>
                                        <a class="label label-primary" href="<?php echo $this->createUrl("/zuanshi/advertiser/more",array("nick"=>$row["nick"]));?>">详情</a>
                                    </small>

                                </div>
                            </div>

                            <div class="row" data-load="overlay" data-tmpl="shop-zuanshi-realtime-list-tmpl" data-role="shop-zuanshi-realtime-list" data-url="<?php echo $this->createUrl("/zuanshi/dashboard/getbynick",array("nick"=>$row["nick"]));?>" >

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


<script type="text/x-jquery-tmpl" id="shop-zuanshi-realtime-list-tmpl">
 {{if !isSuccess}}
    <div>
        <p class="text-danger">安装插件后，登录钻石展位即可同步展示！</p>
    </div>
    {{else}}
     <div class="col-md-12">
       <div>
           <div class="time-h"><o class="tit">${data.loghour}时</o></div>
           {{if data.account.warning}}
                <div class="stop-icon"></div>
           {{/if}}

           <div class="row padding"><div class="col-md-6 col-lg-4 col-sm-6">
            <p class=" text-center">
                <small>余额(<span class="glyphicon glyphicon-yen"></span>)</small>
            </p>

            <h3 class="text-center padding" {{if data.account.warning}}style="color: red"{{/if}}>${data.account.balance}</h3>

           </div>
           <div class="col-md-6 col-lg-4 col-sm-6">
             <p class=" text-center">
               <small>今日预算(<span class="glyphicon glyphicon-yen"></span>)</small>
             </p>
               <h3 class="text-center padding">
                  {{if data.account.zuanshi_budget>0 && data.account.zuanshi_budget!=data.account.dayBudget}}
                    <strong>${data.account.zuanshi_budget}</strong> / <small>${data.account.dayBudget}</small>
                  {{else}}
                    ${data.account.dayBudget}
                  {{/if}}

               </h3>
           </div>
           <div class="col-md-6 col-lg-4 col-sm-6">
             <p class=" text-center">
               <small>昨日消耗(<span class="glyphicon glyphicon-yen"></span>)</small>
             </p>
             <h3 class="text-center padding">
                ${data.account.yesterdayDeduct}
             </h3>
           </div>

       </div>
       <div class="row padding">
          <div class="col-md-6 col-lg-4 col-sm-6" style="background: aliceblue;">
             <div class="inner padding">
                <p class=" text-center">
                   <small>实时消耗(<span class="glyphicon glyphicon-yen"></span>)</small>
                </p>
             <h3 class="text-center padding">
                ${data.today.totalCharge}
             </h3>
             <ul class="d-ul padding">

                <li class="col-md-6">
                    <p><small>较同时刻</small></p>
                    {{if data.cur_yesterday.chargeGrowth<0}}
                        {{if Math.abs(data.cur_yesterday.chargeGrowth)>=30}}
                        <p style="color: red">-<b>${Math.abs(data.cur_yesterday.chargeGrowth)}%</b></p>
                        {{else}}
                        <p>-<b>${Math.abs(data.cur_yesterday.chargeGrowth)}%</b></p>
                        {{/if}}

                    {{else}}
                        {{if data.cur_yesterday.chargeGrowth>0}}
                            {{if Math.abs(data.cur_yesterday.chargeGrowth)>=30}}
                            <p style="color: red">+<b>${Math.abs(data.cur_yesterday.chargeGrowth)}%</b></p>
                            {{else}}
                            <p>+<b>${Math.abs(data.cur_yesterday.chargeGrowth)}%</b></p>
                            {{/if}}
                        {{else}}
                            <p><b>0%</b></p>
                        {{/if}}
                    {{/if}}

                </li>
                <li class="col-md-6">
                   <p><small>同时刻</small></p>
                   <p>
                       ${data.cur_yesterday.totalCharge}
                   </p>
                </li>

             </ul>
             <ul class="d-ul">

                <li class="col-md-6">
                   <p><small>消耗占比</small></p>
                   <p><b>${data.yesterday.chargeRate}%</b></p>
                </li>
                <li class="col-md-6">
                   <p><small>预算</small></p>
                   <p>
                       {{if data.account.zuanshi_budget>0}}${data.account.zuanshi_budget}  {{else}} ${data.account.dayBudget}{{/if}}
                   </p>

                </li>

             </ul>

            </div>
          </div>
          <div class="col-md-6 col-lg-4 col-sm-6" style="background: aliceblue">
          <div class="inner padding">

          <p class=" text-center">
          <small>点击单价(<span class="glyphicon glyphicon-yen"></span>)</small>
          </p>
          <h3 class="text-center padding">
                ${data.today.cpc}
          </h3>
          <ul class="d-ul padding">
            <li class="col-md-6 col-sm-12">
              <p><small>较同时刻</small></p>
                {{if data.cur_yesterday.cpcGrowth<0}}
                        {{if Math.abs(data.cur_yesterday.cpcGrowth)>=30}}
                        <p style="color: red">-<b>${Math.abs(data.cur_yesterday.cpcGrowth)}%</b></p>
                        {{else}}
                        <p>-<b>${Math.abs(data.cur_yesterday.cpcGrowth)}%</b></p>
                        {{/if}}

                    {{else}}
                        {{if data.cur_yesterday.cpcGrowth>0}}
                            {{if Math.abs(data.cur_yesterday.cpcGrowth)>=30}}
                            <p style="color: red">+<b>${Math.abs(data.cur_yesterday.cpcGrowth)}%</b></p>
                            {{else}}
                            <p>+<b>${Math.abs(data.cur_yesterday.cpcGrowth)}%</b></p>
                            {{/if}}
                        {{else}}
                            <p><b>0%</b></p>
                        {{/if}}
                    {{/if}}


            </li>
            <li class="col-md-6 col-sm-12">
              <p><small>同时刻</small></p>
              <p>${data.cur_yesterday.cpc}</p>
            </li>
          </ul>

          <ul class="d-ul">

             <li class="col-md-6 col-sm-12">
               <p><small>较昨日</small></p>
               <p>

                {{if data.yesterday.cpcGrowth<0}}
                        {{if Math.abs(data.yesterday.cpcGrowth)>=30}}
                        <p style="color: red">-<b>${Math.abs(data.yesterday.cpcGrowth)}%</b></p>
                        {{else}}
                        <p>-<b>${Math.abs(data.yesterday.cpcGrowth)}%</b></p>
                        {{/if}}

                    {{else}}
                        {{if data.yesterday.cpcGrowth>0}}
                            {{if Math.abs(data.yesterday.cpcGrowth)>=30}}
                            <p style="color: red">+<b>${Math.abs(data.yesterday.cpcGrowth)}%</b></p>
                            {{else}}
                            <p>+<b>${Math.abs(data.yesterday.cpcGrowth)}%</b></p>
                            {{/if}}
                        {{else}}
                            <p><b>0%</b></p>
                        {{/if}}
                    {{/if}}
               </p>

             </li>
             <li class="col-md-6 col-sm-12">
               <p><small>昨日</small></p>
               <p>
               <p>${data.yesterday.cpc}</p>


             </li>
          </ul>
          </div>
          </div>


          <div class="col-md-6 col-lg-4 col-sm-6" style="background: aliceblue">
          <div class="inner padding">

          <p class=" text-center">
               <small>点击率(%)</small>
          </p>
          <h3 class="text-center padding"> ${data.today.ctrStr}</h3>
          <ul class="d-ul padding">
          <li class="col-md-6 col-sm-12"><p><small>较同时刻</small></p>
            {{if data.cur_yesterday.ctrGrowth<0}}
                        {{if Math.abs(data.cur_yesterday.ctrGrowth)>=30}}
                        <p style="color: red">-<b>${Math.abs(data.cur_yesterday.ctrGrowth)}%</b></p>
                        {{else}}
                        <p>-</i><b>${Math.abs(data.cur_yesterday.ctrGrowth)}%</b></p>
                        {{/if}}

                    {{else}}
                        {{if data.cur_yesterday.ctrGrowth>0}}
                            {{if Math.abs(data.cur_yesterday.ctrGrowth)>=30}}
                            <p style="color: red">+<b>${Math.abs(data.cur_yesterday.ctrGrowth)}%</b></p>
                            {{else}}
                            <p>+<b>${Math.abs(data.cur_yesterday.ctrGrowth)}%</b></p>
                            {{/if}}
                        {{else}}
                            <p><b>0%</b></p>
                        {{/if}}
                    {{/if}}

          </li>
          <li class="col-md-6 col-sm-12">
             <p><small>同时刻</small></p>
             <p>
                <p>${data.cur_yesterday.ctrStr}</p>
             </p>
          </li>
       </ul>

       <ul class="d-ul">
       <li class="col-md-6">
       <p><small>较昨日</small></p>
       <p>

                  {{if data.yesterday.ctrGrowth<0}}
                        {{if Math.abs(data.yesterday.ctrGrowth)>=30}}
                        <p style="color: red">-<b>${Math.abs(data.yesterday.ctrGrowth)}%</b></p>
                        {{else}}
                        <p>-<b>${Math.abs(data.yesterday.ctrGrowth)}%</b></p>
                        {{/if}}

                    {{else}}
                        {{if data.yesterday.ctrGrowth>0}}
                            {{if Math.abs(data.yesterday.ctrGrowth)>=30}}
                            <p style="color: red">+<b>${Math.abs(data.yesterday.ctrGrowth)}%</b></p>
                            {{else}}
                            <p>+<b>${Math.abs(data.yesterday.ctrGrowth)}%</b></p>
                            {{/if}}
                        {{else}}
                            <p>-<b>0%</b></p>
                        {{/if}}
                    {{/if}}
       </p>

       </li>
       <li class="col-md-6 col-sm-12">
       <p><small>昨日</small></p>
       <p>
              ${data.yesterday.ctrStr}
       </p>

       </li>
     </ul>


     </div>


     </div>


</div>

</div>
{{/if}}
</script>


<script type="application/javascript">

    $(document).ready(function(){


        $(".top-ul>li").eq(1).addClass("top-li-hover");

        $(".c-pager").jPager({currentPage: <?php echo $pager["page"]-1;?>, total: <?php echo $pager["count"];?>, pageSize: <?php echo $pager["page_size"];?>,events: function(dp){
            var nick = $("input[data-ename=nick]").val();
            var pic = $("input[data-ename=pic]").val();
            location.href = app.url("<?php echo $this->createUrl('/zuanshi/dashboard/index');?>",{nick:nick,pic:pic,page:dp.index+1})
        }});

        $("div[data-role=list]").delegate("span.editor","click",function(event){
            $(event.delegateTarget).find(".pic_read").hide();
            $(event.delegateTarget).find(".pic_input").show();
            $(event.delegateTarget).find(".pic_input input[name=plan_budget]").focus();
        });

        $("p[data-role=budget]").bind("keydown",function(event){
            if(event.which == 13) {
                var nick = $(this).attr("data-nick");
                var ztc_budget = $(this).find("input[name=plan_ztc_budget]").val();
                var zuanshi_budget = $(this).find("input[name=plan_zuanshi_budget]").val();
                var budget = parseInt(ztc_budget) + parseInt(zuanshi_budget);
                $.ajax({
                    url: "<?php echo $this->createUrl('/main/plan/budgetset');?>",
                    type: "post",
                    data: {nick: nick, budget: budget, ztc_budget: ztc_budget, zuanshi_budget: zuanshi_budget},
                    dataType: "json",
                    success: function (resp) {
                        if (resp.isSuccess) {
                            location.reload();
                        }
                    }
                });
                return false;
            }

        });

        $("[data-toggle=popover]").popover({html : true});


    });

</script>

