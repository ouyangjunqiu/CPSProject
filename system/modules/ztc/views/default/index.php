<link rel="stylesheet" href="<?php echo STATICURL.'/base/css/index.css'; ?>">
<link rel="stylesheet" href="<?php echo STATICURL.'/main/css/index.css'; ?>">
<script src='<?php echo STATICURL."/main/js/shop.js"; ?>'></script>

<div class="index-table-div">

    <div class="search-box">
        <div class="shop-list-cont" id="shop-search">
            <div class="search-log" style="display: none;"> </div>
            <div class="search-left com-list-tit" style="display: block;">
                <span class="shop-list-icon"></span>
                <span class="shop-list-txt">直通车:</span><small>

                    <a href="<?php echo $this->createUrl("/zuanshi/ztc/index");?>"><span class="label label-info">全店报表</span></a>
                    <a href="http://yj.da-mai.com/index.php?r=milestone/adviser/index" target="_blank"><span class="label label-default">大麦优驾</span></a>
                </small>

            </div>
            <div class="search-right">
                <?php $this->widget("application\\modules\\main\\widgets\\ShopSearchWidget",array("url"=>$this->createUrl("/zuanshi/rpt/index",array("page"=>1)),"query"=>$query));?>

            </div>
        </div>
    </div>
    <table class="table-frame">
        <tbody id="babyInforTb">
        <?php foreach($list as $row):?>
            <tr>
                <td class="babyInforTb-td-left">
                    <?php $this->widget("application\\modules\\main\\widgets\\ShopManagerWidget",array("shop"=>$row));?>
                </td>
                <td class="check-infor-td">

                    <div class="baby-box" data-nick="<?php echo $row["nick"];?>" data-role="list">
                        <ul class="nav nav-tabs shop-nav" role="tablist">
                            <li role="presentation"  class="active">
                                <a data-type="rpt" href="#rpt_<?php echo md5($row["nick"]);?>" title="总体报表" aria-controls="rpt_<?php echo md5($row["nick"]);?>" role="tab" data-toggle="tab" aria-expanded="true">
                                    <i class="fa fa-bar-chart-o"></i><span>总体报表<small>(近30天)</small></span>
                                </a>
                            </li>
                            <li role="presentation">
                                <a data-type="rpt_chart" href="#rpt_chart_<?php echo $row["id"];?>" title="近期趋势" aria-controls="rpt_chart_<?php echo $row["id"];?>" role="tab" data-toggle="tab" aria-expanded="true">
                                    <i class="fa fa-line-chart"></i><span>近期趋势</span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">

                            <div role="tabpanel" class="tab-pane active" id="rpt_<?php echo md5($row["nick"]);?>">
                                <div class="overlay-wrapper" data-tmpl="shop-ztcbalance-tmpl" data-load="overlay" data-url="http://yj.da-mai.com/index.php?r=milestone/adviser/shopinfo&nickname=<?php echo $row["nick"];?>">

                                </div>
                                <div class="overlay-wrapper" data-tmpl="shop-ztcrpt-list-tmpl" data-load="overlay" data-url="http://yj.da-mai.com/index.php?r=milestone/adviser/custreport&nick=<?php echo $row["nick"];?>">
                                </div>

                            </div>

                            <div role="tabpanel" class="tab-pane" id="rpt_chart_<?php echo $row["id"];?>">
                                <div data-role="rpt_chart" data-url="http://yj.da-mai.com/index.php?r=milestone/adviser/custreport&nick=<?php echo $row["nick"];?>">
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
<script type="text/x-jquery-tmpl" id="shop-ztcbalance-tmpl">
    {{if data.length>0}}
        {{each(i.rpt) data}}
        <p><small>余额:</small><strong>${rpt.balance}</strong><small>(${rpt.balance_time})</small></p>
        {{/each}}
    {{/if}}
</script>

<script type="text/x-jquery-tmpl" id="shop-ztcrpt-list-tmpl">
 {{if data.reports.length<=0}}
    <div class="alert alert-info" role="alert">
        <p>暂无该店铺的直通车数据,大麦优驾提供数据支持!</p>
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
            <th>加购物车数</th>
            <th>订单数</th>
            <th>回报率</th>
            <th>转化金额</th>
        </tr>
        </thead>
        <tbody>
        {{each(i,rpt) data.reports}}
            <tr class="small">
            <td><strong>${rpt.date}</strong></td>
            <td>${rpt.impressions}</td>
            <td>${rpt.click}</td>
            <td>${rpt.ctr}</td>
            <td>${rpt.cost}</td>
            <td>${rpt.ppc}</td>
            <td>${rpt.favcount}</td>
            <td>${rpt.carttotal}</td>
            <td>${rpt.paycount}</td>
            <td>${rpt.roi}</td>
            <td>${rpt.pay}</td>
            </tr>
        {{/each}}
        </tbody>

        </table>
        <p><small>*注：数据服务由大麦优驾提供</small></p>
{{/if}}
</script>


<script type="application/javascript">

    $(document).ready(function(){

        $(".top-ul>li").eq(2).addClass("top-li-hover");


        $(".c-pager").jPager({currentPage: <?php echo $pager["page"]-1;?>, total: <?php echo $pager["count"];?>, pageSize: <?php echo $pager["page_size"];?>,events: function(dp){

            location.href = app.url("<?php echo $this->createUrl('/ztc/default/index');?>",{page:dp.index+1})
        }});

        app.charts.ztc_custdata = function(data) {
            return {
                chart: {
                    height: 280,
                    width: 1100
                },
                title: {
                    text: ""
                },
                xAxis: {
                    categories: $(data).map(function (k, v) {
                        return v.date;
                    }),
                    tickInterval:4,
                    tickPosition: 'outside',
                    tickmarkPlacement: 'on',
                    gridLineWidth: 1,
                    gridLineColor:"#e2e2e2",
                    gridLineDashStyle:"Dash"
                    //labels: {
                    //    formatter: function () {
                    //        var labelVal = this.value;
                    //        var reallyVal = labelVal;
                    //        if (Object.keys(data).length > 7) {
                    //            reallyVal = labelVal.substring(0, labelVal.length - 3) + "<br/>" + labelVal.substring(2, labelVal.length - 2) + "<br/>" + labelVal.substring(3, labelVal.length);
                    //        } else {
                    //            reallyVal = labelVal.substring(0, labelVal.length);
                    //        }
                    //        return reallyVal;
                    //    }
                    //}
                },
                plotOptions: {
                    line: {
                        dataLabels: {
                            enabled: true //显示每条曲线每个节点的数据项的值
                        },
                        enableMouseTracking: true
                    },
                    column: {
                        dataLabels: {
                            enabled: true,
                            formatter: function () {
                                return this.y + "";
                            }
                        },
                        enableMouseTracking: true
                    },
                    spline: {
                        dataLabels: {
                            enabled: true,
                            formatter: function () {
                                return this.y + '';
                            }
                        },
                        enableMouseTracking: true
                    }
                },
                yAxis: [
                    {
                        labels: {
                            format: '{value}%',
                            style: {
                                color: '#2FCD71'
                            }
                        }, title: {
                        text: ''
                    },
                        min: 0
                    },
                    {
                        labels: {
                            format: '{value}元',
                            style: {
                                color: '#3499DC'
                            }
                        }, title: {
                        text: ''
                    }
                    },
                    {
                        labels: {
                            format: '{value}次',
                            style: {
                                color: '#3499DC'
                            }
                        }, title: {
                        text: ''
                    },
                        opposite: true,
                        min: 0,
                        allowDecimals: false
                    },
                    {
                        labels: {
                            format: '{value}k',
                            style: {
                                color: '#2FCD71'
                            }
                        }, title: {
                        text: ''
                    },
                        opposite: true
                    },
                    {
                        labels: {
                            format: '{value}笔',
                            style: {
                                color: '#3499DC'
                            }
                        }, title: {
                        text: ''
                    },
                        opposite: true,
                        min: 0,
                        allowDecimals: false
                    }
                ],
                series: [
                    {
                        type: 'areaspline',
                        name: '消耗',
                        yAxis: 1,
                        data: app.charts.formatData(data, 'cost'),
                        color: '#3499DC'
                    },
                    {
                        type: 'areaspline',
                        name: '成交额',
                        yAxis: 1,
                        data: app.charts.formatData(data, 'pay'),
                        color: '#FA6E50'
                    },
                    {
                        type: 'spline',
                        name: '3天订单数',
                        yAxis: 4,
                        data: app.charts.formatData(data, 'paycount'),
                        marker: {
                            lineWidth: 2,
                            lineColor: '#9378D8',
                            fillColor: '#9378D8'
                        },
                        color: '#9378D8',
                        visible: false
                    },
                    {
                        type: 'spline',
                        name: '点击',
                        yAxis: 2,
                        data: app.charts.formatData(data, 'click'),
                        marker: {
                            lineWidth: 2,
                            lineColor: '#1ABC9D',
                            fillColor: '#1ABC9D'
                        },
                        color: '#1ABC9D',
                        visible: false
                    },
                    {
                        type: 'spline',
                        name: '收藏数',
                        yAxis: 2,
                        data: app.charts.formatData(data, 'favcount'),
                        marker: {
                            lineWidth: 2,
                            lineColor: '#0086AA',
                            fillColor: '#0086AA'
                        },
                        color: '#0086AA',
                        visible: false
                    },
                    {
                        type: 'spline',
                        name: '展现',
                        yAxis: 2,
                        data: app.charts.formatData(data, 'impressions'),
                        marker: {
                            lineWidth: 2,
                            lineColor: '#E98223',
                            fillColor: '#E98223'
                        },
                        color: '#E98223',
                        visible: false
                    },
                    {
                        type: 'spline',
                        name: '点击率',
                        yAxis: 0,
                        data: app.charts.formatData(data, 'ctr'),
                        marker: {
                            lineWidth: 2,
                            lineColor: '#92B1DA',
                            fillColor: '#92B1DA'
                        },
                        color: '#92B1DA',
                        visible: false
                    },
                    {
                        type: 'spline',
                        name: '转化率',
                        yAxis: 0,
                        data: app.charts.formatData(data, 'ci'),
                        marker: {
                            lineWidth: 2,
                            lineColor: '#E55778',
                            fillColor: '#E55778'
                        },
                        color: '#E55778',
                        visible: false
                    },
                    {
                        type: 'spline',
                        name: '点击单价',
                        yAxis: 0,
                        data: app.charts.formatData(data, 'ppc'),
                        marker: {
                            lineWidth: 2,
                            lineColor: '#377700',
                            fillColor: '#377700'
                        },
                        color: '#377700',
                        visible: false
                    },
                    {
                        type: 'spline',
                        name: '投资回报率',
                        yAxis: 0,
                        data: app.charts.formatData(data, 'roi'),
                        marker: {
                            lineWidth: 2,
                            lineColor: '#377700',
                            fillColor: '#377700'
                        },
                        color: '#377700',
                        visible: false
                    }
                ]
            };
        };


        $("a[data-type=rpt_chart]").click(function(e){
            e.preventDefault();
            var self = $(this);
            var target = $(self.attr("href")).find("[data-role=rpt_chart]");
            var url = target.data("url");
            $.get(url,{},function(resp){
                var config = app.charts.ztc_custdata(resp.data.reports);
                config.chart.width = target.width();
                target.highcharts(config);
                self.tab('show');
            });

        })

    });

</script>

