

var CPS = {};
var app = {};
(function($) {

        /**
         * param 将要转为URL参数字符串的对象
         * key URL参数字符串的前缀
         * encode true/false 是否进行URL编码,默认为true
         *
         * return URL参数字符串
         */
        app.urlEncode = function (param, key, encode) {
            if (param == null) return '';
            var paramStr = '';
            var t = typeof (param);
            if (t == 'string' || t == 'number' || t == 'boolean') {
                paramStr += '&' + key + '=' + ((encode == null || encode) ? encodeURIComponent(param) : param);
            } else {
                for (var i in param) {
                    var k = key == null ? i : key + (param instanceof Array ? '[' + i + ']' : '.' + i);
                    paramStr += app.urlEncode(param[i], k, encode);
                }
            }
            return paramStr;
        };
        app.url = function (url, params) {
            var paramStr = app.urlEncode(params);
            if (paramStr && paramStr.substr(0, 1) == "&") {
                paramStr = paramStr.substr(1);
            }
            return url.indexOf("?") == -1 ? url + "?" + paramStr : url + "&" + paramStr;
        };


    app.alert = function (msg) {
        return $.dialog({title:"提示", lock: true,content:msg,ok:true}).time(5);
    };

    app.confirm = function(msg,okFn,cancelFn){
        var okCallback = function(){},cancelCallback = function(){};
        if(okFn && typeof okFn == 'function'){
            okCallback = okFn;
        }
        if(cancelFn && typeof cancelFn == 'function'){
            cancelCallback = cancelFn;
        }

        $.dialog({title:"提示", lock: true,content:msg,ok:okCallback,cancel:cancelCallback});
    };

    app.error = function (msg) {
        return $.dialog({title:"错误", lock: true,content:msg,ok:true});
    };

    app.charts = {};

    app.charts.formatData = function(data,column){
        var result = [];
        $(data).each(function (k, v) {
            var num = parseFloat(v[column]);
            num = parseInt(num)==num?num:parseFloat(num.toFixed(2));
            result.push(num);
        });
        return result;
    };

    app.charts.formatHourData = function(data,column){
        var result = [];
        var keys = app.charts.formatData(data,"hourId");
        var h = Math.max.apply(Math,keys);

        if(h){
            for(var i=0;i<=h;i++){
                var v = data[i] && data[i][column]?data[i][column]:0;
                result.push(parseFloat(v));
            }
        }

        return result;
    };

    app.charts.default = function(data,title) {
        return {
            chart: {
                height: 280,
                width: 1100
            },
            title: {
                text: title
            },
            xAxis: {
                categories: $(data).map(function (k, v) {
                    return v.date;
                }),
                tickInterval:2,
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
                    data: app.charts.formatData(data, 'charge'),
                    color: '#3499DC'
                },
                //{
                //    type: 'column',
                //    name: '成交额',
                //    yAxis: 1,
                //    data: app.charts.formatData(data, 'pay'),
                //    color: '#FA6E50'
                //},
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
                    data: app.charts.formatData(data, 'pv'),
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
                //{
                //    type: 'spline',
                //    name: '转化率',
                //    yAxis: 0,
                //    data: app.charts.formatData(data, 'ci'),
                //    marker: {
                //        lineWidth: 2,
                //        lineColor: '#E55778',
                //        fillColor: '#E55778'
                //    },
                //    color: '#E55778',
                //    visible: false
                //},
                {
                    type: 'spline',
                    name: '点击单价',
                    yAxis: 0,
                    data: app.charts.formatData(data, 'ecpc'),
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
                    name: '3天回报率',
                    yAxis: 0,
                    data: app.charts.formatData(data, 'roi3'),
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

    app.charts.hConfig = function(d1,d2,f){
        return {
            chart: {
                height: 280,
                width: 1100
            },
            title: {
                text: "实时状况"
            },
            xAxis: {
                categories: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23],
                tickInterval:1,
                tickPosition: 'outside',
                tickmarkPlacement: 'on',
                gridLineWidth: 1,
                gridLineColor:"#e2e2e2",
                gridLineDashStyle:"Dash"
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
                        format: '{value}',
                        style: {
                            color: '#4d7fff'
                        }
                    }, title: {
                        text: ''
                    },
                    min: 0
                },
                {
                    labels: {
                        format: '{value}',
                        style: {
                            color: '#fa5519'
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
                    name: '今日',
                    yAxis: 0,
                    data: app.charts.formatHourData(d1, f),
                    marker: {
                        lineWidth: 2,
                        lineColor: '#4d7fff',
                        fillColor: '#4d7fff'
                    },
                    color: '#4d7fff'
                },
                {
                    type: 'spline',
                    name: '昨日',
                    yAxis: 0,
                    data: app.charts.formatHourData(d2, f),
                    marker: {
                        lineWidth: 2,
                        lineColor: '#fa5519',
                        fillColor: '#fa5519'
                    },
                    color: '#fa5519'
                }
            ]
        };
    };

    CPS.app = app;
})($);
