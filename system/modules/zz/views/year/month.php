<link rel="stylesheet" href="<?php echo STATICURL.'/base/css/index.css'; ?>">
<link rel="stylesheet" href="<?php echo STATICURL.'/main/css/index.css'; ?>">
<style type="text/css">
    .b1{
        background: antiquewhite;
    }
    .b2{
        background: aliceblue;
    }
</style>

<div class="index-table-div">

    <div class="search-box">
        <div class="shop-list-cont">
            <div class="row">
                <div class="col-md-11">
                    <div class="com-list-tit" style="display: block;">
                        <span class="shop-list-icon"></span>
                        <span class="shop-list-txt"><?php echo $query["nick"];?></span>
                        <small>
                            <!--                            <a href="--><?php //echo $this->createUrl("/zuanshi/advertiser/more",array("nick"=>$query["nick"]));?><!--"><span class="label label-default">实时状况</span></a>-->
                            <a href="<?php echo $this->createUrl("/zz/advertiserrpt/more",array("nick"=>$query["nick"]));?>"><span class="label label-default">全店推广报表</span></a>
                            <a href="<?php echo $this->createUrl("/zz/year/month",array("nick"=>$query["nick"]));?>"><span class="label label-info">年度走势</span></a>
                            <!--                            <a href="--><?php //echo $this->createUrl("/zuanshi/adboard/index",array("nick"=>$query["nick"]));?><!--"><span class="label label-default">创意优选</span></a>-->
                            <!--                            <a href="--><?php //echo $this->createUrl("/zuanshi/dest/index",array("nick"=>$query["nick"]));?><!--"><span class="label label-default">定向优选</span></a>-->
                            <!--                            <a href="--><?php //echo $this->createUrl("/zuanshi/adzonerpt/index",array("nick"=>$query["nick"]));?><!--"><span class="label label-default">资源位优选</span></a>-->

                        </small>
                    </div>
                </div>

                <div class="col-md-1">
                    <div class="search-right">
                        <input type="button" class="btn btn-default" value="返回" id="backBtn">
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 10px;margin-bottom: 10px;">
            <div class="col-md-6">
                <div data-role="charts" role-id="charge"></div>

            </div>

            <div class="col-md-6">
                <div data-role="charts" role-id="alipayInshopAmt"></div>
            </div>
        </div>

        <div class="row" style="margin-top: 10px;margin-bottom: 10px;">
            <div class="col-md-6">
                <div data-role="charts" role-id="rate"></div>
            </div>

            <div class="col-md-6">
                <div data-role="charts" role-id="amt"></div>
            </div>
        </div>

    </div>
    <div style="height: 50px;"></div>

</div>

<?php
$month = (int)date("m");
$x = array();
$y_charge = array();
$y_amt = array();
$y_rate = array();
$y_trade = array();
for($i=1;$i<$month;$i++){
    $x[] = $i;
    $y_charge[] = isset($data[$i])?$data[$i]["charge"]:null;
    $y_amt[] = isset($data[$i])?round($data[$i]["alipayInshopAmt"],2):null;
    $y_trade[] = isset($trade[$i])?round($trade[$i],2):null;
    $y_rate[] = isset($data[$i])?round($data[$i]["alipayInshopAmt"]-$data[$i]["charge"],2):null;
}
?>

<script type="application/javascript">

    $(document).ready(function(){
        var self = $(this);

        $(".top-ul>li").eq(1).addClass("top-li-hover");

        $("#backBtn").click(function(){
            window.location.href='<?php echo $this->createUrl("/zz/advertiserrpt/index");?>';
        });

        var c1 = {
            chart: {
                height: 400,
                width: 500
            },
            title: {
                text: "<?php echo $query['year'];?>年度消耗走势"
            },
            xAxis: {
                categories: <?php echo CJavaScript::jsonEncode($x);?>,
                tickInterval:1,
                tickPosition: 'outside',
                tickmarkPlacement: 'on',
                gridLineWidth: 1,
                gridLineColor:"#e2e2e2",
                gridLineDashStyle:"Dash",
                labels: {
                    format: '{value} 月'
                }
            },
            plotOptions: {
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
                        format: '{value} 元',
                        style: {
                            color: '#4d7fff'
                        }
                    }, title: {
                    text: ''
                },
                    min: 0
                }
            ],
            series: [
                {
                    type: 'spline',
                    name: '消耗',
                    yAxis: 0,
                    data: <?php echo CJavaScript::jsonEncode($y_charge);?>,
                    marker: {
                        lineWidth: 2,
                        lineColor: '#4d7fff',
                        fillColor: '#4d7fff'
                    },
                    color: '#4d7fff'
                }
            ]
        };


        var c2 = {
            chart: {
                height: 400,
                width: 500
            },
            title: {
                text: "<?php echo $query['year'];?>年度转化金额走势"
            },
            xAxis: {
                categories: <?php echo CJavaScript::jsonEncode($x);?>,
                tickInterval:1,
                tickPosition: 'outside',
                tickmarkPlacement: 'on',
                gridLineWidth: 1,
                gridLineColor:"#e2e2e2",
                gridLineDashStyle:"Dash",
                labels: {
                    format: '{value} 月'
                }
            },
            plotOptions: {
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
                        format: '{value} 元',
                        style: {
                            color: '#4d7fff'
                        }
                    }, title: {
                    text: ''
                },
                    min: 0
                }
            ],
            series: [
                {
                    type: 'spline',
                    name: '转化金额',
                    yAxis: 0,
                    data: <?php echo CJavaScript::jsonEncode($y_amt);?>,
                    marker: {
                        lineWidth: 2,
                        lineColor: '#4d7fff',
                        fillColor: '#4d7fff'
                    },
                    color: '#4d7fff'
                }
            ]
        };

        var c3 = {
            chart: {
                height: 400,
                width: 500
            },
            title: {
                text: "<?php echo $query['year'];?>年度营业额走势"
            },
            xAxis: {
                categories: <?php echo CJavaScript::jsonEncode($x);?>,
                tickInterval:1,
                tickPosition: 'outside',
                tickmarkPlacement: 'on',
                gridLineWidth: 1,
                gridLineColor:"#e2e2e2",
                gridLineDashStyle:"Dash",
                labels: {
                    format: '{value} 月'
                }
            },
            plotOptions: {
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
                        format: '{value} 元',
                        style: {
                            color: '#4d7fff'
                        }
                    }, title: {
                    text: ''
                },
                    min: 0
                }
            ],
            series: [
                {
                    type: 'spline',
                    name: '营业额',
                    yAxis: 0,
                    data: <?php echo CJavaScript::jsonEncode($y_trade);?>,
                    marker: {
                        lineWidth: 2,
                        lineColor: '#4d7fff',
                        fillColor: '#4d7fff'
                    },
                    color: '#4d7fff'
                }
            ]
        };

        var c4 = {
            chart: {
                height: 400,
                width: 500
            },
            title: {
                text: "<?php echo $query['year'];?>年度推广利润走势"
            },
            xAxis: {
                categories: <?php echo CJavaScript::jsonEncode($x);?>,
                tickInterval:1,
                tickPosition: 'outside',
                tickmarkPlacement: 'on',
                gridLineWidth: 1,
                gridLineColor:"#e2e2e2",
                gridLineDashStyle:"Dash",
                labels: {
                    format: '{value} 月'
                }
            },
            plotOptions: {
                column: {
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
                        format: '{value} 元',
                        style: {
                            color: '#4d7fff'
                        }
                    },
                    title: {
                        text: ''
                    }
                }
            ],
            series: [
                {
                    type: 'spline',
                    name: '推广利润',
                    yAxis: 0,
                    data: <?php echo CJavaScript::jsonEncode($y_rate);?>,
                    marker: {
                        lineWidth: 2,
                        lineColor: '#4d7fff',
                        fillColor: '#4d7fff'
                    },

                    color: '#4d7fff'
                }
            ]
        };

        $("[role-id=charge]").highcharts(c1);
        $("[role-id=alipayInshopAmt]").highcharts(c2);
        $("[role-id=amt]").highcharts(c3);
        $("[role-id=rate]").highcharts(c4);

    });
</script>