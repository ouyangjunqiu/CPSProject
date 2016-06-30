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

                    <a href="<?php echo $this->createUrl("/zuanshi/dashboard/index");?>"><span class="label label-info">全店推广<small>(实时报表)</small></span></a>
                    <a href="<?php echo $this->createUrl("/zuanshi/rpt/index");?>"><span class="label label-default">全店推广<small>(近期报表)</small></span></a>
                    <a href="<?php echo $this->createUrl("/zuanshi/rpt/index2");?>"><span class="label label-default">明星店铺<small>(近期报表)</small></span></a>
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
                    <div class="baby-box" data-nick="<?php echo $row["nick"];?>" data-role="list">
                        <ul class="nav nav-tabs shop-nav" role="tablist">
                            <li role="presentation" class="active">
                                <a data-type="realtime" href="#realtime_<?php echo $row["id"];?>" title="实时状况" aria-controls="realtime_<?php echo $row["id"];?>" role="tab" data-toggle="tab" aria-expanded="true">
                                    <i class="fa fa-flash"></i><span>实时状况</span>
                                </a>
                            </li>
                            <li role="presentation">
                                <a data-type="rpt" href="#rpt_<?php echo $row["id"];?>" title="历史报表" aria-controls="rpt_<?php echo $row["id"];?>" role="tab" data-toggle="tab" aria-expanded="true">
                                    <i class="fa fa-bar-chart-o"></i><span>近期报表<small>(近15天)</small></span>
                                </a>
                            </li>
                            <li role="presentation">
                                <a data-type="rpt_chart" href="#rpt_chart_<?php echo $row["id"];?>" title="近期趋势" aria-controls="rpt_chart_<?php echo $row["id"];?>" role="tab" data-toggle="tab" aria-expanded="true">
                                    <i class="fa fa-line-chart"></i><span>近期趋势</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">

                            <div role="tabpanel" class="tab-pane active" id="realtime_<?php echo $row["id"];?>">
                                <div class="row" data-load="overlay" data-tmpl="shop-zuanshi-realtime-list-tmpl" data-role="shop-zuanshi-realtime-list" data-url="<?php echo $this->createUrl("/zuanshi/dashboard/getbynick",array("nick"=>$row["nick"]));?>" >

                                </div>

                                <div class="row padding" data-load="overlay" data-tmpl="shop-campaign-budget-warning-tmpl" data-url="<?php echo $this->createUrl("/zuanshi/dashboard/getcampaignbudgetwarning",array("nick"=>$row["nick"]));?>">

                                </div>
                                <div class="row">
                                    <div class="col-md-11">

                                    </div>
                                    <div class="col-md-1">
                                        <small>
                                            <a class="label label-primary" href="<?php echo $this->createUrl("/zuanshi/advertiser/more",array("nick"=>$row["nick"]));?>">详情</a>
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="rpt_<?php echo $row["id"];?>">
                                <div data-tmpl="shop-zuanshirpt-list-tmpl" data-load="overlay" data-url="<?php echo $this->createUrl("/zuanshi/rpt/getbynick",array("nick"=>$row["nick"],"shopname"=>$row["shopname"]));?>">
                                </div>

                                <div class="row">
                                    <div class="col-md-11">

                                    </div>
                                    <div class="col-md-1">
                                        <small>
                                            <a class="label label-primary" href="<?php echo $this->createUrl("/zuanshi/rpt/more",array("nick"=>$row["nick"]));?>">详情</a>
                                        </small>
                                    </div>
                                </div>

                            </div>

                            <div role="tabpanel" class="tab-pane" id="rpt_chart_<?php echo $row["id"];?>">
                                <div data-role="rpt_chart" data-url="<?php echo $this->createUrl("/zuanshi/rpt/getbynick",array("nick"=>$row["nick"],"shopname"=>$row["shopname"]));?>">
                                </div>

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

<script type="text/x-jquery-tmpl" id="shop-campaign-budget-warning-tmpl">
{{if isSuccess}}
    <div>
    <small class="glyphicon glyphicon-info-sign"></small>
    <small>截止${data.loghour}h内,</small>
    <small>计划预算消耗占比</small>

    {{if data.low.count>0}}
        <small>小于50%（
        <b style="color:red;padding-right:2px">${data.low.count}个</b>
        ）</small>
    {{/if}}

    {{if data.max.count>0}}
        <small>大于80%(
        <b style="color:red;padding-right:2px">${data.max.count}个</b>
        )</small>
    {{/if}}
    </div>

{{/if}}
</script>

<script type="text/x-jquery-tmpl" id="shop-zuanshirpt-list-tmpl">
 {{if !isSuccess}}
    <div>
        <p class="text-danger">安装插件后，登录钻石展位即可同步展示！</p>
    </div>
    {{else}}
    <table data-role="list" class="baby-frame-table" style="table-layout: fixed;">
        <thead><tr class="small">
            <th>日期</th>
            <th>展现</th>
            <th>点击</th>
            <th>点击率</th>
            <th>消耗</th>
            <th>点击单价</th>
            <th>收藏数</th>
            <th>3天订单数</th>
            <th>7天订单数</th>
            <th>15天订单数</th>
            <th>3天回报率</th>
            <th>7天回报率</th>
            <th>15天回报率</th>
            <th>营业额</th>
            <th>消耗占比(%)</th>
        </tr>
        </thead>
        <tbody>
        {{each(i,rpt) data.list}}
            <tr class="small"><td><strong>${rpt.logDateStr}</strong></td>
            <td>${rpt.adPv}</td>
            <td>${rpt.click}</td>
            <td>${rpt.ctrStr}</td>
            <td>${rpt.charge}</td>
            <td>${rpt.ecpc}</td>
            <td>${rpt.favcount}</td>
            <td>${rpt.alipayInShopNum}</td>
            <td>${rpt.alipayInShopNum7}</td>
            <td>${rpt.alipayInShopNum15}</td>
            <td>${rpt.roi}</td>
            <td>${rpt.roi7}</td>
            <td>${rpt.roi15}</td>
            <td>${rpt.payAmtStr}</td>
            <td>${rpt.chargeRateStr}</td>
            </tr>
        {{/each}}

        {{if data.total}}

            <tr class="small"><td><strong>总计</strong></td>
            <td>${data.total.adPv}</td>
            <td>${data.total.click}</td>
            <td>${data.total.ctrStr}</td>
            <td>${data.total.charge}</td>
            <td>${data.total.ecpc}</td>
            <td>${data.total.favcount}</td>
            <td>${data.total.alipayInShopNum}</td>
            <td>${data.total.alipayInShopNum7}</td>
            <td>${data.total.alipayInShopNum15}</td>
            <td>${data.total.roi}</td>
            <td>${data.total.roi7}</td>
            <td>${data.total.roi15}</td>
            <td>${data.total.payAmtStr}</td>
            <td>${data.total.chargeRateStr}</td>
            </tr>
        {{/if}}
        </tbody>

        </table>
{{/if}}
</script>

<script type="application/javascript">

    $(document).ready(function(){


        $(".top-ul>li").eq(1).addClass("top-li-hover");

        $(".c-pager").jPager({currentPage: <?php echo $pager["page"]-1;?>, total: <?php echo $pager["count"];?>, pageSize: <?php echo $pager["page_size"];?>,events: function(dp){
            location.href = app.url("<?php echo $this->createUrl('/zuanshi/dashboard/index');?>",{page:dp.index+1})
        }});

        //$("[data-toggle=popover]").popover({html : true});
        $("a[data-type=rpt_chart]").click(function(e){
            e.preventDefault();
            var self = $(this);
            var target = $(self.attr("href")).find("[data-role=rpt_chart]");
            var url = target.data("url");
            $.get(url,{},function(resp){
                var config = app.charts.default(resp.data.list,"");
                config.chart.width = target.width();
                target.highcharts(config);
                self.tab('show');
            });

        })


    });

</script>

