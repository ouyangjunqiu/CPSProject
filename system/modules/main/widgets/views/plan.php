<div class="shop-plan-wrapper" data-load="overlay" data-url="<?php echo $urls["shop_plan_get"];?>"  data-nick="<?php echo $nick;?>" data-tmpl="shop-plan-tmpl" data-role="shop-plan-list" id="<?php echo $id;?>"></div>

<script type="text/x-jquery-tmpl" id="shop-plan-tmpl">

    <p class="pic_read type">
    <small>直通车预算：</small>
    ${data.plan.ztc_budget}
    <small>钻展预算：</small>
    ${data.plan.zuanshi_budget}
    <span class="editor" style="display: none;"><i class="glyphicon glyphicon-pencil"></i></span>
    </p>
    <p class="pic_input" data-role="budget" style="display: none">
    <small>直通车预算：</small>
    <input type="text" value="${data.plan.ztc_budget}" class="name_writer" name="plan_ztc_budget"/>
        <small>钻展预算：</small>
    <input type="text" value=" ${data.plan.zuanshi_budget}" class="name_writer" name="plan_zuanshi_budget"/>
    <a data-click="save" href="javascript:void(0)"><i class="fa fa-save"></i></a>
    </p>
</script>

<script type="text/javascript">
    $(document).ready(function(){

        $("#<?php echo $id;?>").delegate("span.editor","click",function(event){
            $(event.delegateTarget).find(".pic_read").hide();
            $(event.delegateTarget).find(".pic_input").show();
            $(event.delegateTarget).find(".pic_input input[name=plan_ztc_budget]").focus();
        });

        $("#<?php echo $id;?>").bind("keydown",function(event){
            if(event.which == 13) {
                $("#<?php echo $id;?>").find("a[data-click=save]").trigger("click");
                return false;
            }

        });
        $("#<?php echo $id;?>").delegate("a[data-click=save]","click",function(event){
            var nick = $("#<?php echo $id;?>").attr("data-nick");
            var ztc_budget = $("#<?php echo $id;?>").find("input[name=plan_ztc_budget]").val();
            var zuanshi_budget = $("#<?php echo $id;?>").find("input[name=plan_zuanshi_budget]").val();
            var budget = parseInt(ztc_budget) + parseInt(zuanshi_budget);
            $.ajax({
                url: "<?php echo $urls["shop_plan_set"];?>",
                type: "post",
                data: {nick: nick, budget: budget, ztc_budget: ztc_budget, zuanshi_budget: zuanshi_budget},
                dataType: "json",
                success: function (resp) {
                    if (resp.isSuccess) {
                        $("#<?php echo $id;?>").DataLoad();
                    }
                }
            });
        });

    });

</script>