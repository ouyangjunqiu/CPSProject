(function() {
    var CPS = {};
    CPS.app = {};
    CPS.board = {};
    CPS.campaign = {};
    CPS.utils = {};
    CPS.layout = {};
    CPS.time = {};
    CPS.dmp = {};
    CPS.adgroup = {};
    CPS.app.start = function () {
        CPS.app.init();
    };

    /**
     * 获取钻展登录帐号名称
     * @version 2.9.6
     */
    CPS.app.init = function () {
        var fn = function () {
            var nick = $("#nickDrop").text();
            console.log(nick);
            if (nick) {
                CPS.app.nick = nick.trim();
                CPS.app.user();
            }else{
                setTimeout(fn,4000);
            }
        };
        fn();
    };


    /**
     * 获取登录用户token信息
     * @version 2.9.6
     */
    CPS.app.user = function () {
        setTimeout(function () {
            $.ajax({
                url: 'http://zuanshi.taobao.com/loginUser/info.json',
                type: 'GET',
                dataType: 'jsonp',
                success: function (data) {
                    CPS.app.csrfID = data.data.csrfID;
                    CPS.app.info = data.data;
                    CPS.app.loginUser = data.data.loginUser;
                    CPS.app.shopId = data.data.loginUser.shopId;
                    CPS.app.postUser();

                    CPS.layout.window();

                    var dateFormat = new DateFormat();
                    var hour = dateFormat.formatCurrentDate("HH");

                    hour = parseInt(hour);
                    if((hour>=9 && hour<=12) || (hour>=14 && hour<=18)){
                        CPS.app.getAdvertiserHour();
                        CPS.app.campaignRptnToday();
                    }

                    CPS.app.validate();

                    CPS.campaign.alert();
                    CPS.board.alert();

                    CPS.dmp.get();
                }
            });
        }, 1000);
    };

    CPS.dmp.get = function(){
        $.ajax({
            url:"http://zuanshi.taobao.com/dmpcrowdTarget/list.json",
            type:"post",
            dataType:"json",
            data:{csrfID:CPS.app.csrfID},
            success:function(resp){
                if(resp.info && resp.info.ok){
                    CPS.dmp.post(resp.data);
                }
            }
        })
    };

    CPS.dmp.post = function(data){
        $.ajax({
            url:"http://cps.da-mai.com/zuanshi/dmp/source.html",
            type:"post",
            dataType:"json",
            data:{nick:CPS.app.nick,data:JSON.stringify(data)},
            success:function(resp){

            }
        })
    };

    /**
     * 计划过期提醒功能
     * @version 3.0.7
     */
    CPS.campaign.alert = function(){
        var dateFormat = new DateFormat();
        var alertDate = 0;
        var alertDateStr = window.localStorage.getItem("campaign.alert."+CPS.app.shopId);
        if(alertDateStr) {
            alertDate = (dateFormat.parseDate(alertDateStr)).getTime();
        }

        if((new Date()).getTime()>alertDate) {


            CPS.app.findCampaignList(function (data) {
                var campaigns = CPS.app.campaignExpiredDetection(data);
                if (campaigns.length > 0) {
                    var html = CPS.app.campaignAlertBox(campaigns);
                    $("body").append(html);

                    $("#btn-w1").click(function () {
                        $("#CPS_campaign_alert").hide();

                    });

                    $("#btn-w2").click(function () {
                        $("#CPS_campaign_alert").hide();

                        var dateFormat = new DateFormat();
                        var nextDate = dateFormat.addDays(new Date(), 1);
                        window.localStorage.setItem("campaign.alert." + CPS.app.shopId, nextDate);

                    });
                }
            })
        }
    };

    /**
     * 提交用户基本信息
     * @version 2.9.6
     */
    CPS.app.postUser = function(){
        $.ajax({
            url: 'http://cps.da-mai.com/main/shop/cloudupdate.html',
            dataType: 'json',
            data: {nick:  CPS.app.nick,userid:CPS.app.loginUser.userId,shopid:CPS.app.loginUser.shopId,usernumid:CPS.app.loginUser.userNumId},
            type: 'post'
        });
    };

    /**
     * 检测平台是否下载过店铺历史报表
     * @version 3.0.5
     */
    CPS.app.validate = function () {
        setTimeout(function () {
            $.ajax({
                url: 'http://cps.da-mai.com/zuanshi/rpt/hasget2.html',
                dataType: 'json',
                data: {nick:  CPS.app.nick},
                type: 'post',
                success: function (resp) {
                    if (resp.data && !resp.data.hasget) {
                        CPS.app.accountRpt();
                        CPS.app.accountRpt2();
                    }
                }
            });
        }, 2000);
        setTimeout(function () {
            $.ajax({
                url: 'http://cps.da-mai.com/zuanshi/adboard/hasget.html',
                dataType: 'json',
                data: {nick:  CPS.app.nick},
                type: 'post',
                success: function (resp) {
                    if (resp.data && !resp.data.hasget) {
                        CPS.app.rptnAdboardAll();
                    }
                }
            });

            var dateFormat = new DateFormat();
            var dateStr= dateFormat.addDays(new Date(), -16, "yyyy-MM-dd");
            $.ajax({
                url: 'http://cps.da-mai.com/bigdata/adboard/hasget.html',
                dataType: 'json',
                data: {nick:  CPS.app.nick,logdate:dateStr},
                type: 'post',
                success: function (resp) {
                    if (resp.data && !resp.data.hasget) {
                        CPS.app.rptnAdboardAll2();
                    }
                }
            });
        }, 3000);
        setTimeout(function () {
            $.ajax({
                url: 'http://cps.da-mai.com/zuanshi/dest/hasget.html',
                dataType: 'json',
                data: {nick:  CPS.app.nick},
                type: 'post',
                success: function (resp) {
                    if (resp.data && !resp.data.hasget) {
                        CPS.app.rptnDestAll();
                    }
                }
            });

            var dateFormat = new DateFormat();
            var dateStr= dateFormat.addDays(new Date(), -16, "yyyy-MM-dd");
            $.ajax({
                url: 'http://cps.da-mai.com/bigdata/dest/hasget.html',
                dataType: 'json',
                data: {nick:  CPS.app.nick,logdate:dateStr},
                type: 'post',
                success: function (resp) {
                    if (resp.data && !resp.data.hasget) {
                        CPS.app.rptnDestAll2();
                    }
                }
            });

            $.ajax({
                url: 'http://cps.da-mai.com/bigdata/destadzone/hasget.html',
                dataType: 'json',
                data: {nick:  CPS.app.nick,logdate:dateStr},
                type: 'post',
                success: function (resp) {
                    if (resp.data && !resp.data.hasget) {
                        CPS.app.rptnDestAdzoneAll2();
                    }
                }
            });


        }, 4000);
        setTimeout(function () {

            $.ajax({
                url: 'http://cps.da-mai.com/zuanshi/adzonerpt/hasget.html',
                dataType: 'json',
                data: {nick:  CPS.app.nick},
                type: 'post',
                success: function (resp) {
                    if (resp.data && !resp.data.hasget) {
                        CPS.app.rptnAdzoneAll();
                    }
                }
            });

            var dateFormat = new DateFormat();
            var dateStr= dateFormat.addDays(new Date(), -16, "yyyy-MM-dd");
            $.ajax({
                url: 'http://cps.da-mai.com/bigdata/adzone/hasget.html',
                dataType: 'json',
                data: {nick:  CPS.app.nick,logdate:dateStr},
                type: 'post',
                success: function (resp) {
                    if (resp.data && !resp.data.hasget) {
                        CPS.app.rptnAdzoneAll2();
                    }
                }
            });
        }, 5000);
    };

    /**
     *  获取展示网络报表
     *  @version 2.9.6
     */
    CPS.app.accountRpt = function () {
        setTimeout(function () {
            var dateFormat = new DateFormat();
            var endDateStr= dateFormat.addDays(new Date(), -1, "yyyy-MM-dd");
            var beginDateStr = dateFormat.addDays(new Date(), -16, "yyyy-MM-dd");
            $.ajax({
                url: 'http://zuanshi.taobao.com/rptn/advertiserCmDay/all.json',
                dataType: 'json',
                data: {csrfID:  CPS.app.csrfID, startTime: beginDateStr, endTime: endDateStr, campaignModel: 1},
                type: 'get',
                success: function (data) {
                    CPS.app.postAccountRpt(data);
                }
            });

        }, 2000);
    };

    /**
     * 提交展示网络报表到平台
     * @version 2.9.6
     */
    CPS.app.postAccountRpt = function (rpts) {
        setTimeout(function () {
            $.ajax({
                url: 'http://cps.da-mai.com/zuanshi/rpt/source.html',
                dataType: 'json',
                data: {userinfo: CPS.app.csrfID, rpts: JSON.stringify(rpts), nick: CPS.app.nick},
                type: 'post',
                success: function (data) {
                }
            });

        }, 1000);
    };

    /**
     *  获取明星店铺报表
     *  @version 2.9.6
     */
    CPS.app.accountRpt2 = function () {
        setTimeout(function () {
            var dateFormat = new DateFormat();
            var endDateStr= dateFormat.addDays(new Date(), -1, "yyyy-MM-dd");
            var beginDateStr = dateFormat.addDays(new Date(), -16, "yyyy-MM-dd");
            $.ajax({
                url: 'http://zuanshi.taobao.com/rptn/advertiserCmDay/all.json',
                dataType: 'json',
                data: {csrfID:  CPS.app.csrfID, startTime: beginDateStr, endTime: endDateStr, campaignModel: 2},
                type: 'get',
                success: function (data) {
                    CPS.app.postAccountRpt2(data);
                }
            });

        }, 2000);
    };

    /**
     * 提交明星店铺报表到平台
     * @version 2.9.6
     */
    CPS.app.postAccountRpt2 = function (rpts) {
        setTimeout(function () {
            $.ajax({
                url: 'http://cps.da-mai.com/zuanshi/rpt/source2.html',
                dataType: 'json',
                data: {userinfo: CPS.app.csrfID, rpts: JSON.stringify(rpts), nick: CPS.app.nick},
                type: 'post',
                success: function (data) {
                }
            });

        }, 1000);
    };

    /**
     * 获取实时数据
     * @version 2.9.6
     */
    CPS.app.getAdvertiserHour = function(){
        setTimeout(function () {
            var dateFormat = new DateFormat();
            var logDateStr = dateFormat.addDays(new Date(), -1, "yyyy-MM-dd");
            $.when(
                $.ajax({
                    url: 'http://zuanshi.taobao.com/index/account.json',
                    dataType: 'json',
                    data: {csrfID: CPS.app.csrfID},
                    type: 'get'
                }),
                $.ajax({
                    url: 'http://zuanshi.taobao.com/rptn/advertiserHour/listSds.json',
                    dataType: 'json',
                    data: {csrfID: CPS.app.csrfID,logDate:logDateStr},
                    type: 'get'
                }),
                $.ajax({
                    url: 'http://zuanshi.taobao.com/rptn/advertiserHour/list.json',
                    dataType: 'json',
                    data: {csrfID: CPS.app.csrfID},
                    type: 'get'
                })
            ).then(function(a,b,c){
                if(a && b && c && a[0] && b[0] && c[0]){
                    if(a[0].data && b[0].data && c[0].data){
                        $.ajax({
                            url: 'http://cps.da-mai.com/zuanshi/advertiser/source.html',
                            dataType: 'json',
                            data: {
                                nick: CPS.app.nick,
                                accountdata: JSON.stringify(a[0].data),
                                yesterdaydata: JSON.stringify(b[0].data),
                                todaydata: JSON.stringify(c[0].data)
                            },
                            type: 'post'
                        })
                    }
                }
            })
        },1000);
    };


    /**
     * 获取创意统计报表
     * @version 2.9.7
     *
     */
    CPS.app.rptnAdboardDayList = function(beginDateStr,endDateStr,offset,fn){
        var t = parseInt(Math.random()*1000+offset/200*100);
        var r = function() {

            return $.ajax({
                url: 'http://zuanshi.taobao.com/rptn/adboardDay/list.json',
                dataType: 'json',
                data: {
                    csrfID: CPS.app.csrfID,
                    startTime: beginDateStr,
                    endTime: endDateStr,
                    pageSize: 200,
                    offset: offset,
                    campaignModel: 1,
                    campaignName: "",
                    transName: "",
                    adboardName: "",
                    sortField: "charge",
                    sortRule: "desc"
                },
                type: 'get',
                success: function (resp) {
                    if (resp && resp.data) {
                        fn(resp.data, offset);
                    }

                }
            })
        };
        setTimeout(r,t);
    };

    /**
     * 获取所有的创意统计报表
     * @version 3.0.5
     *
     */
    CPS.app.rptnAdboardAll = function(){
        var dateFormat = new DateFormat();
        var endDateStr = dateFormat.addDays(new Date(), -1, "yyyy-MM-dd");
        var beginDateStr = dateFormat.addDays(new Date(), -7, "yyyy-MM-dd");

        CPS.app.rptnAdboardDayList(beginDateStr,endDateStr,0,function(data){

            CPS.app.postRptnAboard(data,0);

            for(var offset = 200;offset < data.count;offset+=200){

                    CPS.app.rptnAdboardDayList(beginDateStr,endDateStr,offset,function(rpt,i){

                        CPS.app.postRptnAboard(rpt,i);

                    });

            }

        });
    };
    /**
     * 提交创意统计报表
     * @version 3.0.5
     *
     */
    CPS.app.postRptnAboard = function(data,offset){
        $.ajax({
            url:"http://cps.da-mai.com/zuanshi/adboard/source.html",
            type:"post",
            data:{
                rpt:JSON.stringify(data),nick:CPS.app.nick,offset:offset
            },
            dataType:"json"
        })
    };

    /**
     * 获取所有的创意统计报表
     * @version 3.0.5
     *
     */
    CPS.app.rptnAdboardAll2 = function(){
        var dateFormat = new DateFormat();
        var endDateStr = dateFormat.addDays(new Date(), -16, "yyyy-MM-dd");
        var beginDateStr = dateFormat.addDays(new Date(), -16, "yyyy-MM-dd");

        CPS.app.rptnAdboardDayList(beginDateStr,endDateStr,0,function(data){

            CPS.app.postRptnAboard2(data,beginDateStr,0);

            for(var offset = 200;offset < data.count;offset+=200){

                CPS.app.rptnAdboardDayList(beginDateStr,endDateStr,offset,function(rpt,i){
                    CPS.app.postRptnAboard2(rpt,beginDateStr,i);

                });

            }

        });
    };
    /**
     * 提交创意统计报表
     * @version 3.0.5
     *
     */
    CPS.app.postRptnAboard2 = function(data,logdate,offset){
        $.ajax({
            url:"http://cps.da-mai.com/bigdata/adboard/source.html",
            type:"post",
            data:{
                rpt:JSON.stringify(data),nick:CPS.app.nick,logdate:logdate,offset:offset
            },
            dataType:"json"
        })
    };

    /**
     * 获取定向统计报表
     * @version 2.9.7
     *
     */
    CPS.app.rptnDestDayList = function(beginDateStr,endDateStr,offset,fn){
        var t = parseInt(Math.random()*1000+offset/200*100);
        var r = function() {

            return $.ajax({
                url: 'http://zuanshi.taobao.com/rptn/destDay/list.json',
                dataType: 'json',
                data: {
                    csrfID: CPS.app.csrfID,
                    startTime: beginDateStr,
                    endTime: endDateStr,
                    pageSize: 200,
                    offset: offset,
                    campaignModel: 1,
                    campaignName: "",
                    transName: "",
                    adboardName: "",
                    sortField: "charge",
                    sortRule: "desc"
                },
                type: 'get',
                success: function (resp) {
                    if (resp && resp.data) {
                        fn(resp.data, offset);
                    }
                }
            })
        };
        setTimeout(r,t);
    };

    /**
     * 获取所有的创意统计报表
     * @version 2.9.7
     *
     */
    CPS.app.rptnDestAll = function(){
        var dateFormat = new DateFormat();
        var endDateStr = dateFormat.addDays(new Date(), -1, "yyyy-MM-dd");
        var beginDateStr = dateFormat.addDays(new Date(), -7, "yyyy-MM-dd");

        CPS.app.rptnDestDayList(beginDateStr,endDateStr,0,function(data){

            CPS.app.postRptnDest(data,0);

            for(var offset = 200;offset < data.count;offset+=200){

                CPS.app.rptnDestDayList(beginDateStr,endDateStr,offset,function(rpt,i){
                    CPS.app.postRptnDest(rpt,i);
                });

            }

        });
    };

    /**
     * 提交定向统计报表
     * @version 3.0.5
     *
     */
    CPS.app.postRptnDest = function(data,offset){
        $.ajax({
            url:"http://cps.da-mai.com/zuanshi/dest/source.html",
            type:"post",
            data:{
                rpt:JSON.stringify(data),nick:CPS.app.nick,offset:offset
            },
            dataType:"json"
        })
    };


    /**
     * 获取所有的定向统计报表
     * @version 3.0.5
     *
     */
    CPS.app.rptnDestAll2 = function(){
        var dateFormat = new DateFormat();
        var endDateStr = dateFormat.addDays(new Date(), -16, "yyyy-MM-dd");
        var beginDateStr = dateFormat.addDays(new Date(), -16, "yyyy-MM-dd");
        CPS.app.rptnDestDayList(beginDateStr,endDateStr,0,function(data){

            CPS.app.postRptnDest2(data,beginDateStr,0);

            for(var offset = 200;offset < data.count;offset+=200){

                CPS.app.rptnDestDayList(beginDateStr,endDateStr,offset,function(rpt,i){
                    CPS.app.postRptnDest2(rpt,beginDateStr,i);
                });

            }

        });
    };

    /**
     * 提交定向统计报表
     * @version 3.0.5
     *
     */
    CPS.app.postRptnDest2 = function(data,logdate,offset){
        $.ajax({
            url:"http://cps.da-mai.com/bigdata/dest/source.html",
            type:"post",
            data:{
                rpt:JSON.stringify(data),nick:CPS.app.nick,offset:offset,logdate:logdate
            },
            dataType:"json"
        })
    };

    /**
     * 获取定向统计报表
     * @version 2.9.7
     *
     */
    CPS.app.rptnDestAdzoneDayList = function(beginDateStr,endDateStr,offset,fn){
        var t = parseInt(Math.random()*1000+offset/200*100);
        var r = function() {

            return $.ajax({
                url: 'http://zuanshi.taobao.com/rptn/destAdzoneDay/list.json',
                dataType: 'json',
                data: {
                    csrfID: CPS.app.csrfID,
                    startTime: beginDateStr,
                    endTime: endDateStr,
                    pageSize: 200,
                    offset: offset,
                    campaignModel: 1,
                    campaignName: "",
                    transName: "",
                    sortField: "charge",
                    sortRule: "desc"
                },
                type: 'get',
                success: function (resp) {
                    if (resp && resp.data) {
                        fn(resp.data, offset);
                    }

                }
            })
        };
        setTimeout(r,t);
    };

    /**
     * 获取所有的定向统计报表
     * @version 3.0.5
     *
     */
    CPS.app.rptnDestAdzoneAll2 = function(){
        var dateFormat = new DateFormat();
        var endDateStr = dateFormat.addDays(new Date(), -16, "yyyy-MM-dd");
        var beginDateStr = dateFormat.addDays(new Date(), -16, "yyyy-MM-dd");
        CPS.app.rptnDestAdzoneDayList(beginDateStr,endDateStr,0,function(data){

            CPS.app.postRptnDestAdzone2(data,beginDateStr,0);

            for(var offset = 200;offset < data.count;offset+=200){

                CPS.app.rptnDestAdzoneDayList(beginDateStr,endDateStr,offset,function(rpt,i){
                    CPS.app.postRptnDestAdzone2(rpt,beginDateStr,i);
                });

            }

        });
    };

    /**
     * 提交定向统计报表
     * @version 3.0.5
     *
     */
    CPS.app.postRptnDestAdzone2 = function(data,logdate,offset){
        $.ajax({
            url:"http://cps.da-mai.com/bigdata/destadzone/source.html",
            type:"post",
            data:{
                rpt:JSON.stringify(data),nick:CPS.app.nick,offset:offset,logdate:logdate
            },
            dataType:"json"
        })
    };

    /**
     * 获取资源位统计报表
     * @version 2.9.7
     *
     */
    CPS.app.rptnAdzoneDayList = function(beginDateStr,endDateStr,offset,fn){
        var t = parseInt(Math.random()*1000+offset/200*100);
        var r = function() {

            return $.ajax({
                url: 'http://zuanshi.taobao.com/rptn/adzoneDay/list.json',
                dataType: 'json',
                data: {
                    csrfID: CPS.app.csrfID,
                    startTime: beginDateStr,
                    endTime: endDateStr,
                    pageSize: 200,
                    offset: offset,
                    campaignModel: 1,
                    campaignName: "",
                    transName: "",
                    adboardName: "",
                    sortField: "charge",
                    sortRule: "desc"
                },
                type: 'get',
                success: function (resp) {
                    if (resp && resp.data) {
                        fn(resp.data, offset);
                    }

                }
            })
        };
        setTimeout(r,t);
    };

    CPS.app.rptnAdzoneAll = function(){
        var dateFormat = new DateFormat();
        var endDateStr = dateFormat.addDays(new Date(), -1, "yyyy-MM-dd");
        var beginDateStr = dateFormat.addDays(new Date(), -7, "yyyy-MM-dd");

        CPS.app.rptnAdzoneDayList(beginDateStr,endDateStr,0,function(data){

            CPS.app.postRptnAdzone(data,0);

            for(var offset = 200;offset < data.count;offset+=200){

                CPS.app.rptnAdzoneDayList(beginDateStr,endDateStr,offset,function(rpt,i){
                    CPS.app.postRptnAdzone(rpt,i);
                });

            }

        });
    };
    /**
     * 获取所有的定向统计报表
     * @version 3.0.5
     *
     */
    CPS.app.rptnAdzoneAll2 = function(){
        var dateFormat = new DateFormat();
        var endDateStr = dateFormat.addDays(new Date(), -16, "yyyy-MM-dd");
        var beginDateStr = dateFormat.addDays(new Date(), -16, "yyyy-MM-dd");
        CPS.app.rptnAdzoneDayList(beginDateStr,endDateStr,0,function(data){

            CPS.app.postRptnAdzone2(data,beginDateStr,0);

            for(var offset = 200;offset < data.count;offset+=200){

                CPS.app.rptnAdzoneDayList(beginDateStr,endDateStr,offset,function(rpt,i){
                    CPS.app.postRptnAdzone2(rpt,beginDateStr,i);
                });

            }

        });
    };

    /**
     * 提交定向统计报表
     * @version 3.0.5
     *
     */
    CPS.app.postRptnAdzone = function(data,offset){
        $.ajax({
            url:"http://cps.da-mai.com/zuanshi/adzonerpt/source.html",
            type:"post",
            data:{
                rpt:JSON.stringify(data),nick:CPS.app.nick,offset:offset
            },
            dataType:"json"
        })
    };

    /**
     * 提交定向统计报表
     * @version 3.0.5
     *
     */
    CPS.app.postRptnAdzone2 = function(data,logdate,offset){
        $.ajax({
            url:"http://cps.da-mai.com/bigdata/adzone/source.html",
            type:"post",
            data:{
                rpt:JSON.stringify(data),nick:CPS.app.nick,offset:offset,logdate:logdate
            },
            dataType:"json"
        })
    };

    /**
     * 获取有效的推广计划列表
     * @version 2.9.8
     */
    CPS.app.findCampaignList = function(fn){
        $.ajax({
            url:"http://zuanshi.taobao.com/mooncampaign/findCampaignList.json",
            type:"post",
            data:{
                csrfID: CPS.app.csrfID,
                tab:"list",
                status:5,
                campaignModel:1,
                pageSize:40
            },
            dataType:"json",
            success:function(resp){
                if(resp && resp.data){
                    fn(resp.data);
                }

            }
        })
    };

    CPS.app.campaignRptnToday = function(){
        CPS.app.findCampaignList(function(data){
            if(data && data.list) {
                var list = data.list;
                var campaignids = [];
                for (var i in list) {
                    var campaign = list[i];
                    campaignids.push({"campaignId":campaign.campaignId});
                }
                var format = new DateFormat();
                var curDate = format.formatCurrentDate("yyyy-MM-dd");

                $.ajax({
                    url:"http://zuanshi.taobao.com/rptn/campaign/list.json",
                    type:"post",
                    dataType:"json",
                    data: {
                        csrfID: CPS.app.csrfID,
                        startTime:curDate,
                        endTime:curDate,
                        idList:campaignids
                    },
                    success:function(resp){
                        if(resp && resp.data && resp.data.list){
                            $.ajax({
                                url: "http://cps.da-mai.com/zuanshi/campaign/source.html",
                                type: "post",
                                dataType: "json",
                                data: {
                                    nick: CPS.app.nick,
                                    data: JSON.stringify(list),
                                    rptdata: JSON.stringify(resp.data.list)
                                }
                            });
                        }

                    }

                })
            }
        });
    };

    /**
     * 推广计划过期检测
     * @version 2.9.8
     */
    CPS.app.campaignExpiredDetection = function(data){
        var campaigns = [];
        if(data && data.list){
            var list = data.list;
            for(var i in list){
                var campaign = list[i];
                var format = new DateFormat();

                var result = format.compareTo(format.parseDate(campaign.endTime));
                if(result<=7*24*60*60*1000){
                    campaigns.push(campaign);
                }

            }
        }
        return campaigns;
    };

    /**
     * 推广计划过期弹窗
     * @version 2.9.8
     */
    CPS.app.campaignAlertBox = function(campaigns){
        var html = "<div id='CPS_campaign_alert'><div class='h'>计划过期提醒</div>";
        var content = "<div class='c'>";
        var items = [];
        for(var i in campaigns){
            var campaign = campaigns[i];
            var format = new DateFormat();
            var result = format.compareTo(format.parseDate(campaign.endTime));
            var days = parseInt(Math.ceil(result/(24*60*60*1000)));
            items.push("<p><strong>"+campaign.campaignName+"</strong>将在<em>"+days+"</em>天后过期</p>");
        }
        content = content + items.join("")+"</div>";
        var footer = "<div class='f'><div class='btns'><button id='btn-w1'>稍后提醒</button><button id='btn-w2'>24小时后提醒</button></div></div>";
        return html+content+footer+"</div>";
    };
    /**
     * 创建推广单元
     * @param shop
     * @version 2.9.1
     */
    CPS.app.createTrans = function(shop){
        setTimeout(function () {
            var trans = {};
            trans.campaignId = CPS.app.campaignid;
            trans.transName = shop.nickname+"_"+shop.shopId+"_"+shop.cnt;
            trans.transAdzoneBinds = [];
            for(var i in CPS.app.adzone){
                var a = CPS.app.adzone[i];
                trans.transAdzoneBinds.push({"adzoneId":a.adzoneId,"adzoneType":a.type});
            }

            var matrixPrices = [];
            for(var j in CPS.app.adzone){
                var b = CPS.app.adzone[j];
                matrixPrices.push({"adzoneId":b.adzoneId,"bidPrice":b.bidPrice});
            }
            trans.crowdVOList = [{
                "targetValue":1,
                "targetType":16,
                "targetName":"自主店铺",
                "matrixPriceBatchVOList":matrixPrices,
                "subCrowdVOList":[{"subCrowdName":shop.nickname,"subCrowdValue":shop.shopId}]
            }];

            $.ajax({
                url: 'http://zuanshi.taobao.com/adgroup/createAdgroup.json',
                dataType: 'json',
                data: {csrfID: CPS.app.csrfID,trans:JSON.stringify(trans)},
                type: 'post',
                success: function (resp) {
                    if(resp.info && resp.info.ok && resp.data && resp.data.transId) {
                        CPS.app.bindAdboard(resp.data.transId, CPS.app.creatives, function () {
                                CPS.time.success()
                        }, function () {
                            CPS.time.fail();
                        })
                    }else{
                        CPS.time.fail();
                    }

                },
                error:function(){
                    CPS.time.fail();
                }
            })

        }, 1000);
    };

    CPS.adgroup.createByDmp = function(dmp){
        setTimeout(function () {
            var format = new DateFormat();
            var dateStr = format.formatCurrentDate("yyyyMMdd");
            var trans = {};
            trans.campaignId = CPS.app.campaignid;
            trans.transName = dmp.targetName+"_"+dateStr;
            trans.transAdzoneBinds = [];
            for(var i in CPS.app.adzone){
                var a = CPS.app.adzone[i];
                trans.transAdzoneBinds.push({"adzoneId":a.adzoneId,"adzoneType":a.type});
            }

            var matrixPrices = [];
            for(var j in CPS.app.adzone){
                var b = CPS.app.adzone[j];
                matrixPrices.push({"adzoneId":b.adzoneId,"bidPrice":b.bidPrice});
            }
            trans.crowdVOList = [{
                "targetValue":dmp.targetValue,
                "targetType":128,
                "targetName":dmp.targetName,
                "matrixPriceBatchVOList":matrixPrices,
                "subCrowdVOList":[{"subCrowdName":dmp.targetName,"subCrowdValue":dmp.targetValue}]
            }];

            $.ajax({
                url: 'http://zuanshi.taobao.com/adgroup/createAdgroup.json',
                dataType: 'json',
                data: {csrfID: CPS.app.csrfID,trans:JSON.stringify(trans)},
                type: 'post',
                success: function (resp) {
                    if(resp.info && resp.info.ok && resp.data && resp.data.transId) {
                        CPS.app.bindAdboard(resp.data.transId, CPS.app.creatives, function () {
                            CPS.time.success()
                        }, function () {
                            CPS.time.fail();
                        })
                    }else{
                        CPS.time.fail();
                    }

                },
                error:function(){
                    CPS.time.fail();
                }
            })

        }, 1000);
    };

    /**
     * 修改推广单元
     * @param trans
     * @param adzones
     * @param fn
     * @param err
     */
    //CPS.app.modifyTrans = function(trans,adzones,fn,err){
    //    var newTrans = {};
    //    newTrans.campaignId = trans.campaignId;
    //    newTrans.transId = trans.transId;
    //    newTrans.transName = trans.transName;
    //    newTrans.shopGroupTargets =trans.shopGroupTargets;
    //    var matrixPrices = {};
    //    for(var i in  trans.shopGroupTargets[0].matrixPrices){
    //        var a =  trans.shopGroupTargets[0].matrixPrices[i];
    //        matrixPrices[a.adzoneId] = a.bidPrice;
    //    }
    //
    //    for(var j in adzones){
    //        var b = adzones[j];
    //        matrixPrices[b.adzoneId] = b.bidPrice;
    //    }
    //
    //    newTrans.shopGroupTargets[0].matrixPrices = [];
    //    for(var c in matrixPrices){
    //        newTrans.shopGroupTargets[0].matrixPrices.push({"adzoneId":c,"bidPrice":matrixPrices[c]});
    //    }
    //
    //    var transAdzoneBinds = {};
    //    for(var e in  trans.transAdzoneBinds){
    //        var g = trans.transAdzoneBinds[e];
    //        transAdzoneBinds[g.adzoneId] = g.type;
    //    }
    //
    //    for(var f in adzones){
    //        var k = adzones[f];
    //        transAdzoneBinds[k.adzoneId] = k.type;
    //    }
    //
    //    newTrans.transAdzoneBinds = [];
    //
    //    for(var d in transAdzoneBinds){
    //        newTrans.transAdzoneBinds.push({"adzoneId":d,"type":transAdzoneBinds[d]});
    //    }
    //
    //    $.ajax({
    //        url: 'http://zuanshi.taobao.com/trans/modifyTrans.json',
    //        dataType: 'json',
    //        data: {csrfID: CPS.app.csrfID,trans:JSON.stringify(newTrans)},
    //        type: 'post',
    //        success: function (data) {
    //            CPS.app.adzoneCount++;
    //
    //        }
    //    });
    //};

    /**
     * 批量增加资源位
     * @param crowd
     * @param adzoneId
     * @param adzoneType
     * @param bidPrice
     * @param fn
     * @param err
     * @version 2.9.1
     */
    CPS.app.targetAddAdzones = function(crowd,adzoneId,adzoneType,bidPrice,fn,err){
        var adgroupBindAdzoneVOList = [];

        adgroupBindAdzoneVOList.push({
            "campaignId":crowd.campaignId,
            "adzoneId":adzoneId,
            "adzoneType":adzoneType,
            "transId":crowd.transId,
            "matrixPriceBatchVOList":[{"targetId":crowd.targetId,"targetType":crowd.targetType,"bidPrice":bidPrice}]
        });

        CPS.app.getTransXTargetXAdzoneByCrowd(crowd,function(data){
            $.each(data.list,function(){
                adgroupBindAdzoneVOList.push({
                    "campaignId":this.campaignId,
                    "adzoneId":this.adzoneId,
                    "adzoneType":CPS.utils.formatAdzoneType(this.adzoneId),
                    "transId":this.transId,
                    "matrixPriceBatchVOList":[{"targetId":this.targetId,"targetType":this.targetType,"bidPrice":this.bidPrice}]
                });

            });


            $.ajax({
                url: 'http://zuanshi.taobao.com/adgroup/bind/updateAllAdzoneBind.json',
                dataType: 'json',
                data: {
                    csrfID: CPS.app.csrfID,
                    adgroupBindAdzoneVOList:JSON.stringify(adgroupBindAdzoneVOList)
                },
                type: 'post',
                success: function (resp) {
                    if(resp.info && resp.info.ok){
                        fn(resp.data);
                    }else{
                        err();
                    }

                },
                error:function(){
                    err();
                }
            });

        },function(){
            err();
        });

    };

    /**
     * 根据定向获取推广的资源位
     * @param crowd
     * @param fn
     * @param err
     * @version 2.9.1
     */
    CPS.app.getTransXTargetXAdzoneByCrowd = function(crowd,fn,err){
        var transId = crowd.transId,targetId = crowd.targetId,targetType = crowd.targetType;

        $.ajax({
            url: 'http://zuanshi.taobao.com/matrixprice/getTransXTargetXAdzoneByCrowd.json',
            dataType: 'json',
            data: {
                csrfID: CPS.app.csrfID,
                transId:transId,
                targetId:targetId,
                targetType:targetType,
                campaignType:2
                //trans:JSON.stringify(newTrans)
            },
            type: 'post',
            success: function (resp) {
                if(resp.info && resp.info.ok) {
                    fn(resp.data);
                }else{
                    err();
                }
            },
            error:function(){
                err();
            }
        });
    };

    /**
     * 移除资源位
     * @param adgroupBindAdzoneVOList
     * @param fn
     * @param err
     * @version 2.9.1
     */
    CPS.app.unbindAdzones = function(adgroupBindAdzoneVOList,fn,err){
        $.ajax({
            url: 'http://zuanshi.taobao.com/adgroup/bind/unbindAdzones.json',
            dataType: 'json',
            data: {csrfID: CPS.app.csrfID,adgroupBindAdzoneVOList:JSON.stringify(adgroupBindAdzoneVOList)},
            type: 'post',
            success: function (resp) {
                if(resp.info && resp.info.ok){
                    fn(resp.data);
                }else{
                    err();
                }

            },
            error:function(){
                err();
            }
        });
    };

    /**
     * 绑定推广的创意
     * @param transId
     * @param adboardIds
     * @param fn
     * @param err
     * @version 2.9.1
     */
    CPS.app.bindAdboard = function(transId,adboardIds,fn,err){
        setTimeout(function () {
            $.ajax({
                url: 'http://zuanshi.taobao.com/adgroup/bind/bindAdboard.json',
                dataType: 'json',
                data: {csrfID: CPS.app.csrfID,transId:transId,adboardIdList:adboardIds},
                type: 'post',
                success: function (resp) {
                    if(resp.info && resp.info.ok) {
                        fn(resp.data);
                    }else {
                        err();
                    }
                },
                error:function(){
                    err();
                }
            });

        }, 1000);
    };

    /**
     * 修改出价
     * @param matrixPriceBatchVOList [{"campaignId":campaignId,"transId":transId,"targetId":targetId,"targetType":targetType,"bidPrice":bidPrice,"adzoneId":adzoneId}]
     * @version 2.9.1
     */
    CPS.app.batchModifyMatrixPrice = function(matrixPriceBatchVOList){
        setTimeout(function () {
            $.ajax({
                url: 'http://zuanshi.taobao.com/matrixprice/batchModifyMatrixPrice.json',
                dataType: 'json',
                data: {
                    csrfID: CPS.app.csrfID,
                    matrixPriceBatchVOList: JSON.stringify(matrixPriceBatchVOList)
                },
                type: 'post',
                success: function (resp) {
                    if(resp.info && resp.info.ok){
                        CPS.time.success();
                    }else{
                        CPS.time.fail();
                    }
                },
                error:function(){
                    CPS.time.fail();
                }
            });
        },1000);
    };

    /**
     * 获取店铺信息，用于新增推广单元设置
     * @param nicknames
     * @param fn
     */
    CPS.app.shopInfo2 = function(nicknames,fn){
        setTimeout(function () {
            $.ajax({
                url: 'http://zuanshi.taobao.com/trans/isHavingShop.json',
                dataType: 'json',
                data: {csrfID: CPS.app.csrfID, nicknames: nicknames},
                type: 'post',
                success: function (data) {
                    if(data.data.shops) {
                        fn(data.data.shops);
                    }
                }
            });

        }, 1000);
    };

    /**
     * 获取低价推广设置
     * @param fn
     * @param err
     */
    CPS.app.getSetting = function(fn,err){

            $.ajax({
                url: 'http://cps.da-mai.com/zuanshi/setting/get.html',
                dataType: 'json',
                data: {nick:  CPS.app.nick},
                type: 'post',
                success: function (data) {
                    if(data.isSuccess && data.data){
                        fn(data.data);
                    }
                },error:function(){
                   err();
                }
            });
    };

    /**
     * 获取该计划下的定向列表
     * @param campaignId
     * @param page
     * @returns {*|{requires}}
     */
    CPS.app.getTargetList = function(campaignId,page){

            var offset = (page-1)*40;
            return $.ajax({
                url: 'http://zuanshi.taobao.com/targetManage/getTargetList.json',
                dataType: 'json',
                data: {csrfID: CPS.app.csrfID, campaignId: campaignId,campaignModel:1,tab:"unit_detail_target_list",page:page,offset:offset,pageSize:40},
                type: 'post'
            });
    };

    /**
     * 获取该计划下的定向列表
     * @param campaignId
     * @param page
     * @returns {*|{requires}}
     * @version 2.9.1
     */
    CPS.app.findCrowdList = function(campaignId,page){

        var offset = (page-1)*40;
        return $.ajax({
            url: 'http://zuanshi.taobao.com/horizontalManage/findCrowdList.json',
            dataType: 'json',
            data: {csrfID: CPS.app.csrfID, campaignId: campaignId,campaignModel:1,tab:"unit_detail_target_list",page:page,offset:offset,pageSize:40},
            type: 'post'
        });
    };

    /**
     *
     * @param campaignId
     * @param page
     * @param fn
     * @param err
     */
    CPS.app.getCreativeList = function(campaignId,page,fn,err){
        setTimeout(function () {
            var offset = (page-1)*40;
            $.ajax({
                url: 'http://zuanshi.taobao.com/targetManage/getTargetList.json',
                dataType: 'json',
                data: {csrfID: CPS.app.csrfID, campaignId: campaignId,campaignModel:1,tab:"unit_detail_creative_list",page:page,offset:offset,pageSize:40},
                type: 'post',
                success: function (data) {
                    if(data.data.list) {
                        fn(data.data.list,data.data.count);
                    }
                },
                error:function(){
                    err();
                }
            });

        }, 1000);
    };

    CPS.app.getTransList = function(campaignId,page){
        var offset = (page-1)*40;
        return $.ajax({
            url: 'http://zuanshi.taobao.com/trans/findTransList.json',
            dataType: 'json',
            data: {csrfID: CPS.app.csrfID, campaignId: campaignId,tab:"detail",campaignModel:1,status:25,page:page,offset:offset,pageSize:40},
            type: 'post'
        });
    };

    /**
     * 获取推广组列表
     * @param campaignId
     * @param page
     * @returns {*|{requires}}
     * @version 2.9.1
     */
    CPS.app.findAdgroupList = function(campaignId,page){
        var offset = (page-1)*40;
        return $.ajax({
            url: 'http://zuanshi.taobao.com/adgroup/findAdgroupList.json',
            dataType: 'json',
            data: {csrfID: CPS.app.csrfID, campaignId: campaignId,tab:"detail",campaignModel:1,status:25,page:page,offset:offset,pageSize:40},
            type: 'post'
        });
    };

    /**
     * 获取推广组的创意列表
     * @param campaignId
     * @param transId
     * @param fn
     * @param err
     * @version 2.9.1
     */
    CPS.app.findAdboardList = function(campaignId,transId,fn,err){
        $.ajax({
            url: ' http://zuanshi.taobao.com/horizontalManage/findAdboardList.json',
            dataType: 'json',
            data: {csrfID: CPS.app.csrfID, campaignId:campaignId,transId: transId,tab:"unit_detail_creative_list",campaignModel:1,offset:0,pageSize:40,index:1},
            type: 'post',
            success: function (resp) {

                if(resp.info && resp.info.ok && resp.data.list) {
                    var adboardList = [];
                    $.each(resp.data.list,function(){
                        adboardList.push(this.adboardId);
                    });
                    fn(adboardList);
                }else{
                    err();
                }
            },
            error:function(){
                err();
            }
        });
    };

    CPS.app.getTranDetail = function(transId,fn,err){
        $.ajax({
            url: ' http://zuanshi.taobao.com/trans/getTrans.json',
            dataType: 'json',
            data: {csrfID: CPS.app.csrfID, transId: transId,needTarget:true},
            type: 'post',
            success: function (data) {
                if(data.data.trans) {
                    fn(data.data.trans);
                }
            },
            error:function(){
                err();
            }
        });

    };

    /**
     * 批量替换创意
     * @param campaignId
     * @param transId
     * @param searchId
     * @param replaceId
     * @version 2.9.1
     */
    CPS.app.replaceAdboard = function(campaignId,transId,searchId,replaceId){
        CPS.app.findAdboardList(campaignId,transId,function(adboardList){

            var index = $.inArray(searchId, adboardList);

            var adboards = adboardList;
            if(index>=0){
                adboards.splice(index,1);
                if($.inArray(replaceId,adboards)<0){
                    adboards.push(replaceId);
                }

               CPS.app.bindAdboard(transId, $.unique(adboards).join(","),function(){
                   CPS.time.success();
               },function(){
                   CPS.time.fail();
               });
            }else{
                CPS.time.success();
            }

        },function(){
            CPS.time.fail();
        });
    };

    /**
     * 批量添加创意
     * @param campaignId
     * @param transId
     * @param needAddAdboardId
     * @version 2.9.1
     */
    CPS.app.addAdboard2 = function(campaignId,transId,needAddAdboardId){
        CPS.app.findAdboardList(campaignId,transId,function(adboardList){
            adboardList.push(needAddAdboardId);
            var adboardIds = $.unique(adboardList).join(",");
            CPS.app.bindAdboard(transId,adboardIds,function(){CPS.time.success()},function(){CPS.time.fail()});
        },function(){
            CPS.time.fail()
        });
    };

    /**
     * 移除创意
     * @param transId
     * @param adboardId
     * @version 2.9.1
     */
    CPS.app.unbindAdboard = function(transId,adboardId){
        var aboard = [{"adboardId":adboardId,"transId":transId}];
        setTimeout(function () {
            $.ajax({
                url: 'http://zuanshi.taobao.com/horizontalManage/unbindAdboard.json',
                dataType: 'json',
                data: {csrfID: CPS.app.csrfID,adboardList:JSON.stringify(aboard)},
                type: 'post',
                success: function (resp) {
                    if(resp.info && resp.info.ok){
                        CPS.time.success();
                    }else{
                        CPS.time.fail();
                    }
                },
                error:function(){
                    CPS.time.fail();
                }
            });

        }, 1000);
    };

    /**
     * 批量移除创意
     * @param campaignId
     * @param transId
     * @param needDelAdboardId
     * @version 2.9.1
     */
    CPS.app.delAdboard2 = function(campaignId,transId,needDelAdboardId){
        CPS.app.findAdboardList(campaignId,transId,function(adboardList){

            var index = $.inArray(needDelAdboardId,adboardList);

            if(index>=0){
                CPS.app.unbindAdboard(transId,needDelAdboardId);
            }else{
                CPS.time.success();
            }

        },function(){
            CPS.time.fail();
        });
    };

    CPS.app.getAdzoneList = function(page){
        var pager = {};
        pager.pageSize = 40;
        pager.index = page;
        pager.offset = (pager.index-1)* pager.pageSize;
        setTimeout(function () {
            $.ajax({
                url: ' http://zuanshi.taobao.com/adzone/findAdzoneList.json',
                dataType: 'json',
                data: {csrfID: CPS.app.csrfID,queryAdzoneParamStr:JSON.stringify(pager)},
                type: 'post',
                success: function (data) {
                    if(data.data && data.data.list){
                        for(var i in data.data.list){
                            CPS.app.updateAdzone(data.data.list[i]);
                        }

                    }
                }
            });
        }, 1000);
    };

    CPS.app.updateAdzone = function(adzone){

        $.ajax({
            url: 'http://cps.da-mai.com/zuanshi/adzone/update.html',
            dataType: 'json',
            data: {adzone: JSON.stringify(adzone)},
            type: 'post',
            success: function (data) {
               console.log(data);
            }
        });
    };

    /**
     * 构建小工具的资源位选择器
     * @version 2.9.5
     * @bug 修正界面展示错位问题
     */
    CPS.app.adzoneSelectHtml = function(){
        $.ajax({
            url: ' http://cps.da-mai.com/zuanshi/adzone/list.html',
            dataType: 'json',
            async:false,
            type: 'get',
            success: function (resp) {
                var data = resp.data;

                var t = {},s = [];
                $.each(data,function(){
                    t[this.adzoneId] = this.type;
                    s.push({"id":this.adzoneId+","+this.type,"text":this.adzoneName+"("+this.adzoneId+")"});
                });
                $("#CPS_tools_container .adzone_input select").select2({data:s});

                $("#adzone_data_json").html(JSON.stringify(t));
                $("#CPS_tools_container").show();
            }
        });

    };

    CPS.utils.formatAdzoneType = function(o){
        var t = $("#adzone_data_json").html();
        var data = eval("("+t+")");
        return data[o];
    };


    CPS.board.findAdboardList = function(offset){
        return $.ajax({
            url:"http://zuanshi.taobao.com/board/findAdboardList.json",
            dataType: 'json',
            data: {
                csrfID: CPS.app.csrfID,
                adzoneIdList:"",
                offset:offset,
                pageSize:40,
                status:"P",
                adboardSize:"",
                adboardLevel:"",
                format:2,
                multiMaterial:"",
                adboardName:"",
                archiveStatus:0
            },
            type: 'post'
        })
    };

    CPS.board.findAdboardAll = function(fn){
        $.when(CPS.board.findAdboardList(0)).then(function(a){
            if(a.data && a.data.list){
                var p = Math.ceil(a.data.count/40);
                if(p>3){
                    $.when(CPS.board.findAdboardList((p-1)*40),CPS.board.findAdboardList((p-2)*40),CPS.board.findAdboardList((p-3)*40)).then(function(b,c,d){
                        var list = [];
                        if(a.data && a.data.list){
                            list = list.concat(a.data.list);
                        }
                        if(b[0].data && b[0].data.list){
                            list = list.concat(b[0].data.list);
                        }
                        if(c[0].data && c[0].data.list){
                            list = list.concat(c[0].data.list);
                        }
                        if(d[0].data && d[0].data.list){
                            list = list.concat(d[0].data.list);
                        }
                        fn(list);
                    });
                }else{
                    $.when(CPS.board.findAdboardList(40),CPS.board.findAdboardList(80)).then(function(b,c){
                        var list = [];
                        if(a.data && a.data.list){
                            list = list.concat(a.data.list);
                        }
                        if(b[0].data && b[0].data.list){
                            list = list.concat(b[0].data.list);
                        }
                        if(c[0].data && c[0].data.list){
                            list = list.concat(c[0].data.list);
                        }
                        fn(list);
                    });
                }
            }

        });


    };

    CPS.board.expire = function(fn){
        CPS.board.findAdboardAll(function(list){
            var adboards = [];
            for(var i in list){
                var adboard = list[i];
                var format = new DateFormat();

                var result = format.compareTo(format.parseDate(adboard.outOfServiceTime));
                if(result<=7*24*60*60*1000){
                    adboards.push(adboard);
                }

            }

            fn(adboards);
        })
    };

    /**
     * 推广计划过期弹窗
     * @version 2.9.8
     */
    CPS.board.alertbox = function(adboards){
        var html = "<div id='CPS_adboard_alert'><div class='h'>创意过期提醒</div>";
        var content = "<div class='c'>";
        var items = [];
        for(var i in adboards){
            var adboard = adboards[i];
            var format = new DateFormat();
            var result = format.compareTo(format.parseDate(adboard.outOfServiceTime));
            var days = parseInt(Math.ceil(result/(24*60*60*1000)));
            items.push("<p><strong>"+adboard.adboardName+"</strong>将在<em>"+days+"</em>天后过期</p>");
        }
        content = content + items.join("")+"</div>";
        var footer = "<div class='f'><div class='btns'><button id='btn-adboard-w1'>稍后提醒</button><button id='btn-adboard-w2'>24小时后提醒</button></div></div>";
        return html+content+footer+"</div>";
    };

    /**
     * 计划过期提醒功能
     * @version 3.0.7
     */
    CPS.board.alert = function(){
        var dateFormat = new DateFormat();
        var alertDate = 0;
        var alertDateStr = window.localStorage.getItem("board.alert."+CPS.app.shopId);
        if(alertDateStr) {
            alertDate = (dateFormat.parseDate(alertDateStr)).getTime();
        }

        if((new Date()).getTime()>alertDate) {

            CPS.board.expire(function(list){
                if(list.length > 0){
                    var html = CPS.board.alertbox(list);
                    $("body").append(html);

                    $("#btn-adboard-w1").click(function () {
                        $("#CPS_adboard_alert").hide();

                    });

                    $("#btn-adboard-w2").click(function () {
                        $("#CPS_adboard_alert").hide();

                        var dateFormat = new DateFormat();
                        var nextDate = dateFormat.addDays(new Date(), 1);
                        window.localStorage.setItem("board.alert." + CPS.app.shopId, nextDate);

                    });
                }
            });


        }
    };

    CPS.time.start = function(c){
        $("#CPS_exector_msg").html("正在处理...");
        CPS.time.i = 0;
        CPS.time.s = 0;
        CPS.time.e = 0;
        CPS.time.c = c;
        var fn = function(){
            $("#CPS_exector_msg").html("正在处理("+ CPS.time.i+"/"+ CPS.time.c+")，成功("+CPS.time.s+"),失败("+CPS.time.e+"),请稍等...");
            if(CPS.time.i>=CPS.time.c){
                $("#CPS_exector_msg").html("处理完成,1秒后窗口关闭");
                setTimeout(function(){
                    $("#CPS_tools_container").hide();
                },1000);
            }else{
                setTimeout(fn,1000);
            }
        };
        fn();
    };
    CPS.time.incre = function(){
        CPS.time.i++;
    };
    CPS.time.success = function(){
        CPS.time.incre();
        CPS.time.s++;

    };
    CPS.time.fail = function(){
        CPS.time.incre();
        CPS.time.e++;
    };

    CPS.layout.window = function(){
        var header = "<div class='hd'><p>精准投放平台小助手</p><a href='javascript:void(0)' id='cls-btn'>关闭</a></div>";
        var footer = "<p id='CPS_exector_msg'></p>";

        var other = "<textarea id='adzone_data_json'></textarea>";

        var mainLayout =  "<div id='CPS_tools_container'>" + header + "<div class='content'><div class='panel'></div>"+other+footer+"</div></div>";
        $("body").append(mainLayout);

        $("#cls-btn").click(function(){
            $("#CPS_tools_container").hide();
        });

        CPS.layout.menu();
    };

    CPS.layout.adjust = function(){

        var panel = "<div id='auto_adjust_div' class='row'>"+
        "<table class='table'><tr><td>计划编号：</td><td><input type='text' name='campaignid' value=''/></td><td></td></tr>"+
        "<tr><td>资源位：</td><td colspan='2'><p class='adzone_input'>" +
        "<select name='adzoneId'><option value='34502344,2'>PC_流量包_网上购物_淘宝首页焦点图(34502344)</option></select>"+
        "</p></td></tr>"+
        "<tr><td>出价：</td><td><input type='text' name='bidPrice' value='10'/></td><td></td></tr>"+
        "<tr><td><a class='CPS_bt' id='CPS_auto_adjust'>批量调价</a></td><td></td><td></td></tr>" +
        "</table></div>";

        $("#CPS_exector_msg").html("");

        $("#CPS_tools_container .content .panel").html(panel);
        $("#CPS_tools_container").hide();
        CPS.app.adzoneSelectHtml();

        $("#CPS_auto_adjust").unbind();
        $("#CPS_auto_adjust").one("click",function(){
            var self = $(this);
            self.html("正在处理,请稍候..");

            var campaignid = $("#auto_adjust_div").find("input[name=campaignid]").val();
            var bidPrice =  $("#auto_adjust_div").find("input[name=bidPrice]").val();
            var ad = $("#auto_adjust_div").find("select[name=adzoneId]").val();
            var adzoneId = ad.split(",")[0];

            $.when(CPS.app.findCrowdList(campaignid,1),CPS.app.findCrowdList(campaignid,2),CPS.app.findCrowdList(campaignid,3)).then(function(a,b,c){
                var targets = [];
                if(a[0].data && a[0].data.list){
                    targets = targets.concat(a[0].data.list);
                }
                if(b[0].data && b[0].data.list){
                    targets = targets.concat(b[0].data.list);
                }
                if(c[0].data && c[0].data.list){
                    targets = targets.concat(c[0].data.list);
                }

                CPS.time.start(targets.length);

                var list = targets;

                for(var j in list){
                    var matrixPrice = [{"campaignId":list[j].campaignId,"transId":list[j].transId,"targetId":list[j].targetId,"targetType":list[j].targetType,"bidPrice":bidPrice,"adzoneId":adzoneId}];
                    CPS.app.batchModifyMatrixPrice(matrixPrice);
                }
            });


        });

    };

    CPS.layout.addadzone = function(){
        var panel = "<div id='auto_adjust_div' class='row'>"+
            "<table class='table'><tr><td>计划编号：</td><td><input type='text' name='campaignid' value=''/></td><td></td></tr>"+
            "<tr><td>资源位：</td><td colspan='2'><p class='adzone_input'>" +
            "<select name='adzoneId'><option value='34502344,2'>PC_流量包_网上购物_淘宝首页焦点图(34502344)</option></select>"+
            "</p></td></tr>"+
            "<tr><td>出价：</td><td><input type='text' name='bidPrice' value='10'/></td><td></td></tr>"+
            "<tr><td><a class='CPS_bt' id='CPS_adzone_btn' href='javascript:void(0)'>增加资源位</a></td><td></td><td></td></tr>" +
            "</table></div>";

        $("#CPS_tools_container .content .panel").html(panel);
        $("#CPS_tools_container").hide();
        $("#CPS_exector_msg").html("");
        CPS.app.adzoneSelectHtml();

        $("#CPS_adzone_btn").unbind();
        $("#CPS_adzone_btn").one("click",function(){
            var self = $(this);
            var campaignid = $("#auto_adjust_div").find("input[name=campaignid]").val();
            var bidPrice =  $("#auto_adjust_div").find("input[name=bidPrice]").val();
            var ad = $("#auto_adjust_div").find("select[name=adzoneId]").val();

            var a = ad.split(",");
            var adzoneId = a[0],type = a[1];
            //   var adzones = [{"adzoneId":a[0],"bidPrice":bidPrice,"type":a[1]}];

            self.html("正在处理,请稍候..");
            $.when(CPS.app.findCrowdList(campaignid,1),CPS.app.findCrowdList(campaignid,2),CPS.app.findCrowdList(campaignid,3)).then(function(a,b,c){
                var transList = [];
                if(a[0].data && a[0].data.list){
                    transList = transList.concat(a[0].data.list);
                }
                if(b[0].data && b[0].data.list){
                    transList = transList.concat(b[0].data.list);
                }
                if(c[0].data && c[0].data.list){
                    transList = transList.concat(c[0].data.list);
                }

                CPS.time.start(transList.length);

                for(var i in transList) {
                    var trans = transList[i];
                    CPS.app.targetAddAdzones(trans,adzoneId,type,bidPrice,function(){CPS.time.success()},function(){CPS.time.fail()});
                }

            });
        });
    };

    CPS.layout.deladzone = function(){
        var panel = "<div id='auto_adjust_div' class='row'>"+
            "<table class='table'><tr><td>计划编号：</td><td><input type='text' name='campaignid' value=''/></td><td></td></tr>"+
            "<tr><td>资源位：</td><td colspan='2'><p class='adzone_input'>" +
            "<select name='adzoneId'><option value='34502344,2'>PC_流量包_网上购物_淘宝首页焦点图(34502344)</option></select>"+
            "</p></td></tr>"+
            "<tr><td><a class='CPS_bt' id='CPS_adzone_del_btn'>删除资源位</a></td><td></td><td></td></tr>" +
            "</table></div>";

        $("#CPS_tools_container .content .panel").html(panel);
        $("#CPS_tools_container").hide();
        $("#CPS_exector_msg").html("");
        CPS.app.adzoneSelectHtml();

        $("#CPS_adzone_del_btn").unbind();
        $("#CPS_adzone_del_btn").one("click",function(){
            var self = $(this);
            self.html("正在处理,请稍候..");
            var campaignid = $("#auto_adjust_div").find("input[name=campaignid]").val();
            var ad = $("#auto_adjust_div").find("select[name=adzoneId]").val();
            var a = ad.split(",");
            var adzoneId = a[0];
            $.when(CPS.app.findAdgroupList(campaignid,1),CPS.app.findAdgroupList(campaignid,2),CPS.app.findAdgroupList(campaignid,3)).then(function(a,b,c){
                var transList = [];
                if(a[0].data && a[0].data.list){
                    transList = transList.concat(a[0].data.list);
                }
                if(b[0].data && b[0].data.list){
                    transList = transList.concat(b[0].data.list);
                }
                if(c[0].data && c[0].data.list){
                    transList = transList.concat(c[0].data.list);
                }

                CPS.time.start(transList.length);

                for(var i in transList) {
                    var batchUnbindAdzones = [];
                    var trans = transList[i];
                    batchUnbindAdzones.push({"campaignId":trans.campaignId,"adzoneId":adzoneId,"transId":trans.transId});
                    CPS.app.unbindAdzones(batchUnbindAdzones,function(){
                        CPS.time.success()
                    },function(){
                        CPS.time.fail()
                    });
                }

            });
        });

    };

    CPS.layout.adboard = function(){
        var panel = "<div id='batch_adjust_adboard' class='row'>"+
            "<table class='table'><tr><td>计划编号：</td><td><input type='text' name='campaignid' value=''/></td></tr>"+
            "<tr><td>移除创意：</td><td><input type='text' name='searchid' value=''/></td></tr>"+
            "<tr><td>添加创意：</td><td><input type='text' name='replaceid' value=''/></td></tr>"+
            "<tr><td><a class='CPS_bt' id='CPS_adboard_btn'>替换创意</a></td><td></td></tr></table></div>";

        $("#CPS_tools_container .content .panel").html(panel);
        $("#CPS_tools_container").hide();
        $("#CPS_exector_msg").html("");
        CPS.app.adzoneSelectHtml();

        $("#CPS_adboard_btn").unbind();
        $("#CPS_adboard_btn").one("click",function(){
            var self = $(this);
            var campaignid = $("#batch_adjust_adboard").find("input[name=campaignid]").val();
            var searchid =  $("#batch_adjust_adboard").find("input[name=searchid]").val();
            var replaceid = $("#batch_adjust_adboard").find("input[name=replaceid]").val();
            self.html("正在处理,请稍候..");
            searchid = parseInt(searchid);

            replaceid = parseInt(replaceid);
            $.when(CPS.app.findAdgroupList(campaignid,1),CPS.app.findAdgroupList(campaignid,2),CPS.app.findAdgroupList(campaignid,3)).then(function(a,b,c){
                var transList = [];
                if(a[0].data && a[0].data.list){
                    transList = transList.concat(a[0].data.list);
                }
                if(b[0].data && b[0].data.list){
                    transList = transList.concat(b[0].data.list);
                }
                if(c[0].data && c[0].data.list){
                    transList = transList.concat(c[0].data.list);
                }

                CPS.time.start(transList.length);

                for(var i in transList){
                    var trans = transList[i];
                    if(isNaN(searchid) && replaceid>0){
                        CPS.app.addAdboard2(trans.campaignId,trans.transId,replaceid);
                    }else if(isNaN(replaceid) && searchid>0){
                        CPS.app.delAdboard2(trans.campaignId,trans.transId,searchid);
                    }else
                        CPS.app.replaceAdboard(trans.campaignId,trans.transId,searchid,replaceid);
                }
            });

        });
    };

    CPS.layout.create = function(){
        $("#CPS_tools_container").hide();
        $("#CPS_exector_msg").html("");
        CPS.app.getSetting(function(data){
            var panel = "";
            if(data.campaignid && data.campaignid>0){
                 panel = "<div id='batch_create' class='row'>"+
                    "<table class='table'><tr><td>计划编号：</td><td>"+data.campaignid+"</td></tr>"+
                    "<tr><td><a class='CPS_bt'  id='CPS_auto_create'>批量推广</a></td><td></td></tr></table></div>";
            }else{
                 panel = "<p>未获取到批量推广设置,请到精准平台进行设置.</p>";
            }
            $("#CPS_tools_container .content .panel").html(panel);
            $("#CPS_tools_container").show();

            $("#CPS_auto_create").unbind();
            $("#CPS_auto_create").one("click",function(){
                var self = $(this);
                self.html("正在处理,请稍候..");

                CPS.app.getSetting(function(data2){

                    CPS.app.campaignid = data2.campaignid;
                    CPS.app.creatives =  data2.creatives;
                    CPS.app.adzone =  data2.adzone;

                    if(data2.type==1) {
                        CPS.time.start(data2.dmps.length);
                        for(var i in data2.dmps){
                            CPS.adgroup.createByDmp(data2.dmps[i]);
                        }

                    }else{
                        CPS.app.shopNames = data2.shops;
                        CPS.app.shopLabels = [];
                        for (var i in CPS.app.shopNames) {
                            CPS.app.shopLabels.push(i);
                        }
                        CPS.app.shopInfo2(CPS.app.shopLabels.join(","), function (data) {

                            CPS.time.start(data.length);

                            for (var i in data) {
                                var shop = {
                                    shopId: data[i].shopId,
                                    nickname: data[i].nickname,
                                    cnt: CPS.app.shopNames[data[i].nickname]
                                };
                                CPS.app.createTrans(shop);
                            }

                        });
                    }

                },function(){
                    self.html("低价批量推广失败，请刷新界面重试！");
                });

            });
        })
    };

    CPS.layout.menu = function(){
        var menuHtml = "<div id='CPS_layout_menu'><ul style='display: none'>"+
            "<li><a href='javascript:void(0)' data-target='CPS_layout_create'>批量推广</a></li>"+
            "<li><a href='javascript:void(0)' data-target='CPS_layout_adjust'>批量调价</a></li>"+
            "<li><a href='javascript:void(0)' data-target='CPS_layout_add_ad'>批量添加资源位</a></li>"+
            "<li><a href='javascript:void(0)' data-target='CPS_layout_del_ad'>批量删除资源位</a></li>"+
            "<li><a href='javascript:void(0)' data-target='CPS_layout_adboard'>批量替换创意</a></li>"+
            //"<li><a href='javascript:void(0)' data-target='CPS_layout_update'>更新资源位</a></li>"+
            "</ul><div id='CPS_layout_icon'><div class='img_box'><i class='icon'></i></div></div></div>";
        $("body").append(menuHtml);
        $("#CPS_layout_icon").click(function(){
            $("#CPS_layout_menu ul").toggle();
        });

        $("#CPS_layout_menu a[data-target='CPS_layout_create']").click(function(){
            CPS.layout.create();
        });

        $("#CPS_layout_menu a[data-target='CPS_layout_adjust']").click(function(){
            CPS.layout.adjust();
        });

        $("#CPS_layout_menu a[data-target='CPS_layout_add_ad']").click(function(){
            CPS.layout.addadzone();
        });

        $("#CPS_layout_menu a[data-target='CPS_layout_del_ad']").click(function(){
            CPS.layout.deladzone();
        });

        $("#CPS_layout_menu a[data-target='CPS_layout_adboard']").click(function(){
            CPS.layout.adboard();
        });

    };

    CPS.app.start();

    //
    //    $("#CPS_auto_adzone").click(function(){
    //        for(var page=1;page<=7;page++){
    //            CPS.app.getAdzoneList(page)
    //        }
    //    });


})($);







