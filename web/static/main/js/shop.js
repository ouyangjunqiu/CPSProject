$(document).ready(function(){

$("div[data-role=shop-base-info]").delegate("span.editor","click",function(event){
    $(event.delegateTarget).find(".pic_read").hide();
    $(event.delegateTarget).find(".pic_input").show();
    $(event.delegateTarget).find(".pic_input input[name=pic]").focus();
});

    $("div[data-role=shop-taobao-info]").delegate("span.editor","click",function(event){
        $(event.delegateTarget).find(".pic_read").hide();
        $(event.delegateTarget).find(".pic_input").show();
        $(event.delegateTarget).find(".pic_input input[name=login_nick]").focus();
    });

    $("div[data-role=shop-contact]").delegate("span.editor","click",function(event){
        $(event.delegateTarget).find(".pic_read").hide();
        $(event.delegateTarget).find(".pic_input").show();
        $(event.delegateTarget).find(".pic_input input[name=qq]").focus();
    });

    $("div[data-role=shop-budget]").delegate("span.editor","click",function(event){
        $(event.delegateTarget).find(".pic_read").hide();
        $(event.delegateTarget).find(".pic_input").show();
        $(event.delegateTarget).find(".pic_input input[name=ztc_budget]").focus();
    });

$("div[data-role=shop-base-info] form [data-click=pic-save]").click(function(event){
    var url = $(this).attr("data-url");
    var self = $(this).parents("form");
    $.ajax({
        url:url,
        type:"post",
        data:self.serialize(),
        dataType:"json",
        success:function(resp){
            if(resp.isSuccess) {
                location.reload();
            }
        }
    });
    return false;
});

    $("div[data-role=shop-taobao-info] form [data-click=pic-save]").click(function(event){
        var url = $(this).attr("data-url");
        var self = $(this).parents("form");
        $.ajax({
            url:url,
            type:"post",
            data:self.serialize(),
            dataType:"json",
            success:function(resp){
                if(resp.isSuccess) {
                    location.reload();
                }
            }
        });
        return false;
    });

    $("div[data-role=shop-contact] form [data-click=contact-save]").click(function(event){

        var self = $(this).parents("form");
        var url = self.attr("action");

        $.ajax({
            url:url,
            type:"post",
            data:self.serialize(),
            dataType:"json",
            success:function(resp){
                if(resp.isSuccess) {
                    location.reload();
                }
            }
        });
        return false;
    });


    $("div[data-role=shop-budget] form [data-click=budget-save]").click(function(event){

        var self = $(this).parents("form");
        var url = self.attr("action");

        $.ajax({
            url:url,
            type:"post",
            data:self.serialize(),
            dataType:"json",
            success:function(resp){
                if(resp.isSuccess) {
                    location.reload();
                }
            }
        });
        return false;
    });

$("div[data-role=shop-base-info] form").keydown(function(event){
    var self = $(this);
    if(event.which == 13){
        self.find("[data-click=pic-save]").trigger("click");
        return false;
    }

});

$("button[data-click=jingzheng]").click(function(){
    var url = $(this).attr("data-url");
    var form = $(this).parent().parent();
    $.ajax({
        url:url,
        type:"post",
        data:form.serialize(),
        dataType:"json",
        success:function(resp){
            if(resp.isSuccess) {
                location.reload();
            }
        }
    })
});

$("a[data-click=stop]").click(function(){
    var url = $(this).attr("data-url");
    var nick = $(this).attr("data-nick");

    $.dialog({title:"提示", lock: true,content:'是否确定要暂停合作!',ok:function(){
        $.ajax({
            url:url,
            type:"post",
            data:{nick:nick},
            dataType:"json",
            success:function(resp){
                if(resp.isSuccess) {
                    location.reload();
                }
            }
        })
    },cancel:function(){
    }});

});

    $("a[data-click=off]").click(function(){
        var url = $(this).attr("data-url");
        var nick = $(this).attr("data-nick");

        $.dialog({title:"提示", lock: true,content:'是否确定要终止合作!',ok:function(){
            $.ajax({
                url:url,
                type:"post",
                data:{nick:nick},
                dataType:"json",
                success:function(resp){
                    if(resp.isSuccess) {
                        location.reload();
                    }
                }
            })
        },cancel:function(){
        }});

    });

    $("a[data-click=restart]").click(function(){
        var url = $(this).attr("data-url");
        var nick = $(this).attr("data-nick");

        $.dialog({title:"提示", lock: true,content:'是否确定要恢复合作!',ok:function(){
            $.ajax({
                url:url,
                type:"post",
                data:{nick:nick},
                dataType:"json",
                success:function(resp){
                    if(resp.isSuccess) {
                        location.reload();
                    }
                }
            })
        },cancel:function(){
        }});

    });


    $("a[data-click=shoprpt]").click(function(){
        var source_url = $(this).attr("data-ztcrpt-href");
        var post_url = $(this).attr("data-post-ztcrpt-href");
        $.ajax({
            url:source_url,
            dataType:"json",
            success:function(resp){

                $.ajax({
                    url:post_url,
                    dataType:"json",
                    data:{
                        effectType:"click",
                        effect:15,
                        data:JSON.stringify(resp.data.reports)
                    },
                    type:"post",
                    success:function(){
                        app.confirm("更新成功");
                    }
                })

            }
        })

    });


    $("#babyInforTb tr").hover(function(){
        $(this).find("span.editor").show();
    },function(){
        $(this).find("span.editor").hide();
    });

    $("body").delegate(".quick_login_btn[extension=uninstall]","click",function(){
        CPS.app.alert("你还没有安装浏览器插件，无法完成自动登录！");
        return false;
    });


})

