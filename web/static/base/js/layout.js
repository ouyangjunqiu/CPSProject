(function ($) {


    var Pager = function (obj, setting) {
        this.obj = obj;
        this.setting = setting;
        this.init();
    };

    Pager.prototype = {
        init: function () {
            this.setting = $.extend({ currentPage: 0, total: 0, pageSize: 20 }, this.setting);
            this.total = this.setting.total;
            this.yushu = this.setting.total / this.setting.pageSize;
            this.pageindex = this.setting.currentPage;
            this.yeshuInt = Math.ceil(this.yushu);
            this.pageSize = this.setting.pageSize;
            if(this.setting.currentPage > this.yeshuInt) {
                this.setting.currentPage = 0;
            }

            if(this.total<=0){
                this.obj.hide();
                return;
            }

            this.buildHtml();
            this.show();
        },
        buildHtml:function(){
            var self = this;
            var pageronestr = "",pagerlistr = "";
            for (var j = 0; j < self.yeshuInt; j++) {
                pageronestr = "<li class='pagerli'>" + (j + 1) + "</li>";
                pagerlistr = pagerlistr + pageronestr;
            }
            var html = '<div class="pager" data-status="loading">'+
                '<div class="pages-pre pager-pn"><span class="pages-pre-span jPag-first">第一页</span><span class="pages-pre-span jPag-prev">上一页</span><span class="jPag-sprevious">&lt;&lt;</span></div>'+
            '<div class="pagerol-div">'+
                '<ol class="pagerol">'+pagerlistr+'</ol>'+
                '</div>'+
                '<div class="pages-next pager-pn"><span class="jPag-snext">&gt;&gt;</span>'+
                '<span class="jPag-snext-span jPag-next">下一页</span><span class="jPag-snext-span jPag-last">最后页</span></div>'+
            '<div class="pager-label">共<span class="total-y">'+self.yeshuInt+'</span>页<span class="total-l">'+self.total+'</span>条数据</div>'+
            '</div>';
            this.obj.html(html);
        },

        //创建html标签
        show: function () {
            var self = this;
            var panel = self.obj.find(".pager");
            if (panel.attr("data-status") == "loading") {
                var pli = self.obj.find(".pagerol li");
                var liw = pli.outerWidth();
                var preWidth = self.obj.find(".pager .pages-pre").outerWidth();
                var labelw = self.obj.find(".pager .pager-label").outerWidth();
                var liwM = pli.css("marginRight");
                if (liwM) {
                    liwM = Number(liwM.replace(/px/, ""));
                }
                var awi = parseInt(liw) + parseInt(liwM);
                self.obj.find(".pagerol-div").css({ "width": self.yeshuInt * awi + "px", "max-width": awi * 10 });
                // alert(self.obj.find(".pagerol-div").width());
                self.obj.find(".pager").css("width", self.yeshuInt * awi + (preWidth * 2) + labelw+5 + "px");
                if (self.total > 10) {
                    self.obj.find(".pager").css("width", 10 * awi + (preWidth * 2) + labelw+5 + "px");
                }
                panel.attr("data-status","done");
            }

            var pg = Math.ceil((self.setting.currentPage+1) / 10) - 1;

            if(!isNaN(pg) && pg>0) {
                var mlw = self.obj.find(".pagerol");
                var cpx = self.obj.find(".pagerol-div").outerWidth();
                var mlwL = mlw.css("marginLeft");
                mlwL = Number(mlwL.replace("px", ""));

                mlw.css("marginLeft", -cpx * pg - (mlwL));
            }

            pli.eq(this.pageindex).addClass("p-click").siblings().removeClass("p-click");//分页选中
            self.click();
            self.scroll();
        },
        click: function () {
            var self = this;
            var pli = $(this.obj).find(".pagerol-div li");
            var ppn = $(this.obj).find(".pager-pn");
            pli.unbind();
            pli.click(function (e) {
                var index = $(this).index();
                if (typeof self.setting.events == "function") {
                    self.setting.events({ index: index })
                }
                self.obj.find(".pagerol li").eq(index).addClass("p-click").siblings().removeClass("p-click");//分页选中

            });

            //第一页
            ppn.find(".jPag-first").click(function(e){

                var mlw = self.obj.find(".pagerol");

                if (mlw.is(':animated')) { mlw.stop(true, true);}

                var mlwL = mlw.css("marginLeft");
                mlwL = Number(mlwL.replace("px", ""));
                //if (mlwL < 0) {
                    mlw.animate({ "marginLeft": 0 }, "linear", function () {

                        var index = 0;
                        self.setting.events({ index: index });

                        self.obj.find(".pagerol li").eq(index).addClass("p-click").siblings().removeClass("p-click");//分页选中

                    })
                //}

            });


            //最后一页
            ppn.find(".jPag-last").click(function(e){
                var mlw = self.obj.find(".pagerol");

                if (mlw.is(':animated')) { mlw.stop(true, true);}

                var mlwL = mlw.css("marginLeft");
                mlwL = Number(mlwL.replace("px", ""));
                var cpx = self.obj.find(".pagerol-div").outerWidth();
                //if (mlwL <= 0 && parseInt(cpx) < parseInt(licontWidth) && mlwL > -cpx * (Math.ceil(self.yeshuInt / 10) - 1)) {

                    //if (mlwL <= 0 && parseInt($(".pagesol-div").outerWidth()) >= parseInt(425) & mlwL > -cpx * Math.floor(yeshuInt / 10)) {
                    mlw.animate({ "marginLeft": -cpx * (Math.ceil(self.yeshuInt / 10) - 1) }, "linear", function () {

                        var index = self.yeshuInt - 1;
                        self.setting.events({ index: index }) ;
                        self.obj.find(".pagerol li").eq(index).addClass("p-click").siblings().removeClass("p-click");//分页选中
                    })
                //}
            });

            //上一页
            ppn.find(".jPag-prev").click(function(e){

                var num = parseInt($(".pagerol .p-click").text()) - 1;
                if (num == 0) {
                    return;
                }
                var index = (num - 1);
                self.setting.events({ index: index });
                self.obj.find(".pagerol li").eq(index).addClass("p-click").siblings().removeClass("p-click");//分页选中
            });


            //下一页
            ppn.find(".jPag-next").click(function(e){

                var num = parseInt($(".pagerol .p-click").text()) -1;
                if (num == self.yeshuInt - 1) {
                    return;
                }
                var index = (num + 1);

                self.setting.events({ index: index });
                self.obj.find(".pagerol li").eq(index).addClass("p-click").siblings().removeClass("p-click");//分页选中
            });

        },
        scroll: function () {
            var self = this;
            var ppn = $(self.obj).find(".pager-pn");

            ppn.find(".jPag-snext").click(function(e){

                var cpx = self.obj.find(".pagerol-div").outerWidth();
                // alert(cpx);
                var pagerli = self.obj.find(".pagerli");
                var liw = pagerli.outerWidth();
                var licontWidth = (liw + 5) * self.total;

                var mlw = self.obj.find(".pagerol");

                if (mlw.is(':animated')) { mlw.stop(true, true);}

                var mlwL = mlw.css("marginLeft");
                mlwL = Number(mlwL.replace("px", ""));
                // alert(mlwL + ".." + -cpx * (Math.ceil(self.yeshuInt / 10) - 1));
                if (mlwL <= 0 && parseInt(cpx) < parseInt(licontWidth) && mlwL > -cpx * (Math.ceil(self.yeshuInt / 10) - 1)) {

                    //if (mlwL <= 0 && parseInt($(".pagesol-div").outerWidth()) >= parseInt(425) & mlwL > -cpx * Math.floor(yeshuInt / 10)) {
                    mlw.animate({ "marginLeft": -(cpx - mlwL) }, "linear", function () {
                        // mlw.stop(true, true)
                    })

                }

            });

            ppn.find(".jPag-sprevious").click(function(e){
                var cpx = self.obj.find(".pagerol-div").outerWidth();

                var pagerli = self.obj.find(".pagerli");
                var liw = pagerli.outerWidth();
                var licontWidth = (liw + 5) * self.total;

                var mlw = self.obj.find(".pagerol");
                if (mlw.is(':animated')) { mlw.stop(true, true);}

                var mlwL = mlw.css("marginLeft");
                mlwL = Number(mlwL.replace("px", ""));
                // alert(-(cpx - mlwL));
                if (mlwL < 0) {
                    mlw.animate({ "marginLeft": mlwL + cpx }, "linear", function () {
                        //  mlw.stop(true, true);

                    })

                }

            });

        }
    };

    $.fn.extend({
        jPager: function (setting) {
            var jPager = new Pager($(this), setting);
            return jPager;
        }
    })
})($);

(function ($) {

    $.fn.extend({
        DataLoad:function(){

            var self = $(this);
            var tmpl = $("#"+self.data("tmpl"));
            $.ajax({
                url:self.data("url"),
                dataType:"json",
                type:"get",
                success:function(resp){
                    self.html(tmpl.tmpl(resp));
                    self.removeClass("overlay-wrapper");
                    self.attr("load","loaded");
                },
                beforeSend:function(){
                    self.html("<div class='loading-img'></div>");
                    self.addClass("overlay-wrapper");
                    self.attr("load","loading");
                }
            })

        }
    });

})($);


$(document).ready(function(){
    $("[data-load=overlay]").each(function(){
        var load = $(this).attr("load");
        if(load && (load == "loaded" || load == "loading") ) {

        }else {

            if ($(window).height() >= $(this).offset().top) {
                $(this).DataLoad();

            }else {

                var a = $(this).offset().top;
                var b = $(window).height() + $(window).scrollTop();

                if (a >= $(window).scrollTop() && a <= b) {
                    $(this).DataLoad();
                }
            }

            $(this).one("appear", function () {
                $(this).DataLoad();
            });
        }
    });

    $(window).bind("scroll", function(event){
        $("[data-load=overlay]").each(function(){
            var load = $(this).attr("load");
            if(load && (load == "loaded" || load == "loading")) {

            }else{
                var a = $(this).offset().top;
                var b = $(window).height() + $(window).scrollTop();
                if (a >= $(window).scrollTop() && a<=b) {
                    $(this).trigger("appear");
                }else {

                    if ($(window).height() >= $(this).offset().top) {
                        $(this).trigger("appear");
                    }
                }
            }
        });
    });

    $("body").delegate(".scroll-top-box","click",function(){
        $(".scroll-top-box").hide();
        window.scrollTo(0, 0);

    });

    function scroll( fn ) {
        var beforeScrollTop = document.body.scrollTop,
            fn = fn || function() {};
        window.addEventListener("scroll", function() {
            var afterScrollTop = document.body.scrollTop,
                delta = afterScrollTop - beforeScrollTop;
            if( delta === 0 ) return false;
            fn( delta > 0 );
            beforeScrollTop = afterScrollTop;
        }, false);
    }

    scroll(function(direction) {
        if(!direction){
            $(".scroll-top-box").show();
            //  $(".main-header").show();
        }else{
            $(".scroll-top-box").hide();
            //  $(".main-header").hide();
        }
    });

});





