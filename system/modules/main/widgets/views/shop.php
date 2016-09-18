<div class="shop-info-wrap">
    <a name="<?php echo $row["nick"];?>" class="_anchor"></a>
    <div class="tab">
        <ul class="nav nav-tabs shop-nav" role="tablist">
            <li role="presentation" class="active"><a href="#home_<?php echo $row["id"];?>" title="基本信息" aria-controls="home_<?php echo $row["id"];?>" role="tab" data-toggle="tab"><i class="fa fa-home"></i><span>基本信息</span></a></li>
            <li role="presentation"><a href="#zhanghuo_<?php echo $row["id"];?>" title="帐号信息" aria-controls="zhanghuo_<?php echo $row["id"];?>" role="tab" data-toggle="tab"><i class="fa fa-user"></i><span>帐号信息</span></a></li>
            <li role="presentation"><a href="#budget_<?php echo $row["id"];?>" title="推广设置" aria-controls="budget_<?php echo $row["id"];?>" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-usd"></i><span>推广设置</span></a></li>
            <li role="presentation"><a href="#contact_<?php echo $row["id"];?>" title="联系方式" aria-controls="contact_<?php echo $row["id"];?>" role="tab" data-toggle="tab"><i class="fa fa-phone"></i><span>联系方式</span></a></li>
            <li role="presentation"><a href="#op_<?php echo $row["id"];?>" title="店铺操作" aria-controls="op_<?php echo $row["id"];?>" role="tab" data-toggle="tab"><i class="fa fa-cog"></i><span>店铺操作</span></a></li>
            <li role="presentation"><a href="#more_<?php echo $row["id"];?>" title="快捷登录" aria-controls="op_<?php echo $row["id"];?>" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-option-horizontal"></i><span>更多应用</span></a></li>

        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home_<?php echo $row["id"];?>" data-role="shop-base-info">
                <form>
                    <input type="hidden" value="<?php echo $row["nick"];?>"  name="nick"/>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="babyinfor-frame-tit">

                                    <a href="<?php echo $row["shopurl"];?>" target="_blank"><?php echo $row["nick"];?> </a>
                                    <?php if(!empty($row["shopcatname"])):?>
                                    <o class="tit"><?php echo $row["shopcatname"];?></o>
                                    <?php endif;?>

                                </p>
                                <?php if($row["shopname"] !=  $row["nick"]):?>
                                <small>(<?php echo $row["shopname"];?>)</small>
                                <?php endif;?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4"><small>运营顾问:</small></div>
                            <div class="col-md-6">
                                <span class="pic_read">
                                    <strong><?php echo $row["pic"];?></strong>
                                </span>
                                <span class="pic_input form_writer" style="display: none">
                                    <input type="text" value="<?php echo $row["pic"];?>" name="pic"/>
                                </span>
                            </div>
                            <div class="col-md-2">
                                <span class="pic_read">
                                    <span class="editor"><i class="glyphicon glyphicon-pencil"></i></span>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><small>智钻顾问:</small></div>
                            <div class="col-md-6">
                                <span class="pic_read">
                                    <strong><?php echo $row["zuanshi_pic"];?></strong>
                                </span>
                                <span class="pic_input form_writer" style="display: none">
                                    <input type="text" value="<?php echo $row["zuanshi_pic"];?>" name="zuanshi_pic"/>
                                </span>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><small>直通车顾问:</small></div>
                            <div class="col-md-6">
                                <span class="pic_read">
                                    <strong><?php echo $row["ztc_pic"];?></strong>
                                </span>
                                <span class="pic_input form_writer" style="display: none">
                                    <input type="text" value="<?php echo $row["ztc_pic"];?>" name="ztc_pic"/>
                                </span>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><small>数据顾问:</small></div>
                            <div class="col-md-6">
                                <span class="pic_read">
                                    <strong><?php echo $row["bigdata_pic"];?></strong>
                                </span>
                                <span class="pic_input form_writer" style="display: none">
                                    <input type="text" value="<?php echo $row["bigdata_pic"];?>" name="bigdata_pic"/>
                                </span>
                            </div>
                            <div class="col-md-2">
                                <span class="pic_input" style="display: none">
                                    <button type="button" class="btn btn-primary" data-click="pic-save" data-url="<?php echo Yii::app()->urlManager->createUrl('/main/shop/pic');?>">保存</button>
                                </span>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-2"><small>交谈:</small></div>
                            <div class="col-md-10">
                                <a href="http://www.taobao.com/webww/ww.php?ver=3&touid=<?php echo $row["nick"];?>&siteid=cntaobao&status=1&charset=u8" target="_blank"><i class="contact contact-wangwang"></i></a>
                                <?php if(!empty($row["qq"])):?><a href="tencent://message/?uin=<?php echo $row["qq"];?>&Site=QQ交谈&Menu=yes"><i class="contact contact-qq"></i></a><?php endif;?>
                                <?php if(!empty($row["email"])):?><a href="mailto:<?php echo $row["email"];?>"><i class="contact contact-email"></i></a><?php endif;?>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <span class="label label-info"><?php echo $row["shoptype"];?></span>
                                <?php echo empty($row["ztc_budget"])?"<span class=\"label label-disable\">直通车暂停</span>":"<span class=\"label label-info\">直通车推广</span>";?>
                                <?php echo empty($row["zuanshi_budget"])?"<span class=\"label label-disable\">智钻暂停</span>":"<span class=\"label label-info\">智钻推广</span>";?>
                                <?php
                                if(!empty($row["tags"])){
                                    $tags = explode(",",$row["tags"]);
                                    $i = 1;
                                    foreach($tags as $tag){
                                        if($i%2==0){
                                            echo "<span class=\"label label-info\">{$tag}</span> ";
                                        }else{
                                            echo "<span class=\"label label-warning\">{$tag}</span> ";
                                        }
                                        $i++;
                                    }
                                }
                                ?>
                            </div>
                        </div>

                        <?php if(!empty($rpt) && $rpt["total"]["charge"]>0):?>
                            <div class="row" style="margin-top: 10px;">
                                <div class="col-md-12">
                                    <small><strong>智钻上周状况</strong></small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <small>消耗:</small>
                                </div>
                                <div class="col-md-2">
                                    <small><strong><?php echo $rpt["total"]["charge"];?></strong></small>
                                </div>
                                <div class="col-md-3">
                                    <small>日均消耗:</small>
                                </div>
                                <div class="col-md-2">
                                    <small><strong><?php echo @round($rpt["total"]["charge"]/count($rpt["list"]),2);?></strong></small>
                                </div>
                                <div class="col-md-2">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <small>成交单数:</small>
                                </div>
                                <div class="col-md-2">
                                    <small><strong><?php echo $rpt["total"]["alipayInShopNum"];?></strong></small>
                                </div>
                                <div class="col-md-3">
                                    <small>转化成本:</small>
                                </div>
                                <div class="col-md-2">
                                    <small><strong><?php echo @round($rpt["total"]["charge"]/$rpt["total"]["alipayInShopNum"],2);?></strong></small>
                                </div>
                                <div class="col-md-2">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <small>加购数:</small>
                                </div>
                                <div class="col-md-2">
                                    <small><strong><?php echo $rpt["total"]["cartNum"];?></strong></small>
                                </div>
                                <div class="col-md-3">
                                    <small>加购成本:</small>
                                </div>
                                <div class="col-md-2">
                                    <small><strong><?php echo @round($rpt["total"]["charge"]/$rpt["total"]["cartNum"],2);?></strong></small>
                                </div>
                                <div class="col-md-2">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <small>收藏数:</small>
                                </div>
                                <div class="col-md-2">
                                    <small><strong><?php echo ($rpt["total"]["dirShopColNum"]+$rpt["total"]["inshopItemColNum"]);?></strong></small>
                                </div>
                                <div class="col-md-3">
                                    <small>收藏成本:</small>
                                </div>
                                <div class="col-md-2">
                                    <small><strong><?php echo @round($rpt["total"]["charge"]/($rpt["total"]["dirShopColNum"]+$rpt["total"]["inshopItemColNum"]),2);?></strong></small>
                                </div>
                                <div class="col-md-2">
                                </div>
                            </div>
                        <?php endif;?>
                        <div class="row">
                            <div class="babyinfor-interface">
                                <a href="javascript:void(0);" class="zuanshi quick_login_btn" extension="uninstall" login-type="zuanshi" data-nick="<?php echo $row["nick"];?>" data-password="<?php echo $row["login_password"];?>" data-username="<?php echo $row["login_nick"];?>">智·钻</a>
                                <a href="javascript:void(0);" class="shenyicanmou quick_login_btn" extension="uninstall" login-type="shenyicanmou" data-nick="<?php echo $row["nick"];?>" data-password="<?php echo $row["login_password"];?>" data-username="<?php echo $row["login_nick"];?>">生意参谋</a>
                                <a href="javascript:void(0);" class="zhitongche quick_login_btn" extension="uninstall" login-type="zhitongche" data-nick="<?php echo $row["nick"];?>" data-password="<?php echo $row["login_password"];?>" data-username="<?php echo $row["login_nick"];?>">直通车</a>
                                <a href="javascript:void(0);" class="dmp quick_login_btn" extension="uninstall" login-type="dmp" data-nick="<?php echo $row["nick"];?>" data-password="<?php echo $row["login_password"];?>" data-username="<?php echo $row["login_nick"];?>">达摩盘</a>
                            </div>

                        </div>

                    </div>
                </form>
            </div>
            <div role="tabpanel" class="tab-pane" id="zhanghuo_<?php echo $row["id"];?>" data-role="shop-taobao-info">
                <form>
                    <input type="hidden" value="<?php echo $row["nick"];?>"  name="nick"/>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="babyinfor-frame-tit"><a href="<?php echo $row["shopurl"];?>" target="_blank"><?php echo $row["nick"];?> </a>
                                    <?php if(!empty($row["shoptype"])):?>
                                        <o class="tit"><?php echo $row["shoptype"];?></o>
                                    <?php endif;?>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"><small>店铺名称:</small></div>
                            <div class="col-md-7">
                                <span class="pic_read">
                                    <strong><?php echo $row["shopname"];?></strong>
                                </span>
                                <span class="pic_input form_writer" style="display: none">
                                    <input type="text" value="<?php echo $row["shopname"];?>"  name="shopname"/>
                                </span>
                            </div>
                            <div class="col-md-2">
                                <span class="pic_read">
                                    <span class="editor"><i class="glyphicon glyphicon-pencil"></i></span>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"><small>主营行业:</small></div>
                            <div class="col-md-7">
                                <span class="pic_read">
                                    <strong><?php echo $row["shopcatname"];?></strong>
                                </span>
                                <span class="pic_input form_writer" style="display: none">
                                    <input type="text" value="<?php echo $row["shopcatname"];?>"  name="shopcatname"/>
                                </span>
                            </div>
                            <div class="col-md-2">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"><small>淘宝账号:</small></div>
                            <div class="col-md-7">
                                <span class="pic_read">
                                    <strong><?php echo $row["login_nick"];?></strong>
                                </span>
                                <span class="pic_input form_writer" style="display: none">
                                    <input type="text" value="<?php echo $row["login_nick"];?>"  name="login_nick"/>
                                </span>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"><small>淘宝密码:</small></div>
                            <div class="col-md-7">
                                <span class="pic_read">
                                    <strong><?php echo $row["login_password"];?></strong>
                                </span>
                                <span class="pic_input form_writer" style="display: none">
                                    <input type="text" value="<?php echo $row["login_password"];?>" name="login_password"/>
                                </span>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"><small>合作业务:</small></div>
                            <div class="col-md-7">
                                <span class="pic_read">
                                    <strong><?php echo $row["shoptype"];?></strong>
                                </span>
                                <span class="pic_input" style="display: none">
                                    <?php echo CHtml::dropDownList("shoptype", $row["shoptype"],\application\modules\main\model\Shop::$saleTypes);?>
                                </span>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"><small>店铺地址:</small></div>
                            <div class="col-md-7">
                                <span class="pic_read w2">
                                   <a href="<?php echo $row["shopurl"];?>" target="_blank" title="<?php echo $row["shopurl"];?>"><?php echo empty($row["shopurl"])?"":(strlen($row["shopurl"])>32?substr($row["shopurl"],0,32)."...":$row["shopurl"]);?></a>
                                </span>
                                <span class="pic_input form_writer" style="display: none">
                                    <input type="text" value="<?php echo $row["shopurl"];?>" name="shopurl"/>
                                </span>
                            </div>
                            <div class="col-md-2">
                                <span class="pic_input" style="display: none">
                                    <button type="button" class="btn btn-primary" data-click="pic-save" data-url="<?php echo Yii::app()->urlManager->createUrl('/main/shop/modify');?>">保存</button>
                                </span>
                            </div>

                        </div>

                        <div class="row">
                            <div class="babyinfor-interface">
                                <a href="javascript:void(0);" class="zuanshi quick_login_btn" extension="uninstall" login-type="zuanshi" data-nick="<?php echo $row["nick"];?>" data-password="<?php echo $row["login_password"];?>" data-username="<?php echo $row["login_nick"];?>">智·钻</a>
                                <a href="javascript:void(0);" class="shenyicanmou quick_login_btn" extension="uninstall" login-type="shenyicanmou" data-nick="<?php echo $row["nick"];?>" data-password="<?php echo $row["login_password"];?>" data-username="<?php echo $row["login_nick"];?>">生意参谋</a>
                                <a href="javascript:void(0);" class="zhitongche quick_login_btn" extension="uninstall" login-type="zhitongche" data-nick="<?php echo $row["nick"];?>" data-password="<?php echo $row["login_password"];?>" data-username="<?php echo $row["login_nick"];?>">直通车</a>
                                <a href="javascript:void(0);" class="dmp quick_login_btn" extension="uninstall" login-type="dmp" data-nick="<?php echo $row["nick"];?>" data-password="<?php echo $row["login_password"];?>" data-username="<?php echo $row["login_nick"];?>">达摩盘</a>
                            </div>

                        </div>

                    </div>
                </form>
            </div>
            <div role="tabpanel" class="tab-pane" id="budget_<?php echo $row["id"];?>" data-role="shop-budget">
                <form action="<?php echo Yii::app()->urlManager->createUrl('/main/budget/set');?>" method="post">
                    <input type="hidden" value="<?php echo $row["nick"];?>"  name="nick"/>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="babyinfor-frame-tit">
                                    <a href="<?php echo $row["shopurl"];?>" target="_blank"><?php echo $row["nick"];?> </a>
                                </p>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-4"><small>总预算:</small></div>
                            <div class="col-md-6">
                                <strong><?php echo @($row["ztc_budget"]+$row["zuanshi_budget"]);?></strong>
                            </div>
                            <div class="col-md-2">
                                <span class="pic_read">
                                    <span class="editor"><i class="glyphicon glyphicon-pencil"></i></span>
                                </span>
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-md-4"><small>直通车预算:</small></div>
                            <div class="col-md-6">
                                <span class="pic_read">
                                    <strong><?php echo $row["ztc_budget"];?></strong>
                                </span>
                                <span class="pic_input form_writer" style="display: none">
                                    <input type="text" value="<?php echo $row["ztc_budget"];?>"  name="ztc_budget"/>
                                </span>
                            </div>
                            <div class="col-md-2">
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4"><small>钻展预算:</small></div>
                            <div class="col-md-6">
                                <span class="pic_read"><strong><?php echo $row["zuanshi_budget"];?></strong></span>
                                <span class="pic_input form_writer" style="display: none">
                                    <input type="text" value="<?php echo $row["zuanshi_budget"];?>"  name="zuanshi_budget"/>
                                </span>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4"><small>标签:</small></div>
                            <div class="col-md-6">
                                <span class="pic_read">
                                    <?php
                                    $tags = explode(",",$row["tags"]);
                                    $i = 1;
                                    foreach($tags as $tag){
                                        if($i%2==0){
                                            echo "<span class=\"label label-info\">{$tag}</span> ";
                                        }else{
                                            echo "<span class=\"label label-warning\">{$tag}</span> ";
                                        }
                                        $i++;
                                    }
                                    ?>
                                </span>
                                <span class="pic_input form_writer" style="display: none">
                                    <input type="text" value="<?php echo $row["tags"];?>"  name="tags"/>
                                </span>
                            </div>
                            <div class="col-md-2">
                                <span class="pic_input" style="display: none">
                                    <button type="button" class="btn btn-primary" data-click="budget-save">保存</button>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="babyinfor-interface">
                                <a href="javascript:void(0);" class="zuanshi quick_login_btn" extension="uninstall" login-type="zuanshi" data-nick="<?php echo $row["nick"];?>" data-password="<?php echo $row["login_password"];?>" data-username="<?php echo $row["login_nick"];?>">智·钻</a>
                                <a href="javascript:void(0);" class="shenyicanmou quick_login_btn" extension="uninstall" login-type="shenyicanmou" data-nick="<?php echo $row["nick"];?>" data-password="<?php echo $row["login_password"];?>" data-username="<?php echo $row["login_nick"];?>">生意参谋</a>
                                <a href="javascript:void(0);" class="zhitongche quick_login_btn" extension="uninstall" login-type="zhitongche" data-nick="<?php echo $row["nick"];?>" data-password="<?php echo $row["login_password"];?>" data-username="<?php echo $row["login_nick"];?>">直通车</a>
                                <a href="javascript:void(0);" class="dmp quick_login_btn" extension="uninstall" login-type="dmp" data-nick="<?php echo $row["nick"];?>" data-password="<?php echo $row["login_password"];?>" data-username="<?php echo $row["login_nick"];?>">达摩盘</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div role="tabpanel" class="tab-pane" id="contact_<?php echo $row["id"];?>" data-role="shop-contact">
                <form action="<?php echo Yii::app()->urlManager->createUrl('/main/contact/set');?>" method="post">
                    <input type="hidden" value="<?php echo $row["nick"];?>"  name="nick"/>
                    <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="babyinfor-frame-tit">
                                <a href="<?php echo $row["shopurl"];?>" target="_blank"><?php echo $row["nick"];?> </a>
                            </p>
                        </div>
                    </div>
                    <div class="row">

                            <div class="col-md-3"><small>QQ:</small></div>
                            <div class="col-md-7">
                                <span class="pic_read">
                                    <strong><?php echo $row["qq"];?></strong>
                                </span>
                                <span class="pic_input form_writer" style="display: none">
                                    <input type="text" value="<?php echo $row["qq"];?>"  name="qq"/>
                                </span>
                            </div>
                            <div class="col-md-2">
                                <span class="pic_read">
                                    <span class="editor"><i class="glyphicon glyphicon-pencil"></i></span>
                                </span>
                            </div>

                    </div>
                    <div class="row">
                        <div class="col-md-3"><small>Email:</small></div>
                        <div class="col-md-7">
                            <span class="pic_read"><strong><?php echo $row["email"];?></strong></span>
                            <span class="pic_input form_writer" style="display: none">
                                <input type="text" value="<?php echo $row["email"];?>"  name="email"/>
                            </span>
                        </div>
                        <div class="col-md-2">

                        </div>
                    </div>
                        <div class="row">
                            <div class="col-md-3"><small>联系电话:</small></div>
                            <div class="col-md-7">
                                <span class="pic_read"><strong><?php echo $row["phone"];?></strong></span>
                                <span class="pic_input form_writer" style="display: none">
                                    <input type="text" value="<?php echo $row["phone"];?>"  name="phone"/>
                                </span>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3"><small>微信:</small></div>
                            <div class="col-md-7">
                                <span class="pic_read"><strong><?php echo $row["weixin"];?></strong></span>
                                <span class="pic_input form_writer" style="display: none">
                                    <input type="text" value="<?php echo $row["weixin"];?>"  name="weixin"/>
                                </span>
                            </div>
                            <div class="col-md-2">
                                <span class="pic_input" style="display: none">
                                    <button type="button" class="btn btn-primary" data-click="contact-save">保存</button>
                                </span>
                            </div>
                        </div>

                    <div class="row">
                        <div class="babyinfor-interface">
                            <a href="javascript:void(0);" class="zuanshi quick_login_btn" extension="uninstall" login-type="zuanshi" data-nick="<?php echo $row["nick"];?>" data-password="<?php echo $row["login_password"];?>" data-username="<?php echo $row["login_nick"];?>">智·钻</a>
                            <a href="javascript:void(0);" class="shenyicanmou quick_login_btn" extension="uninstall" login-type="shenyicanmou" data-nick="<?php echo $row["nick"];?>" data-password="<?php echo $row["login_password"];?>" data-username="<?php echo $row["login_nick"];?>">生意参谋</a>
                            <a href="javascript:void(0);" class="zhitongche quick_login_btn" extension="uninstall" login-type="zhitongche" data-nick="<?php echo $row["nick"];?>" data-password="<?php echo $row["login_password"];?>" data-username="<?php echo $row["login_nick"];?>">直通车</a>
                            <a href="javascript:void(0);" class="dmp quick_login_btn" extension="uninstall" login-type="dmp" data-nick="<?php echo $row["nick"];?>" data-password="<?php echo $row["login_password"];?>" data-username="<?php echo $row["login_nick"];?>">达摩盘</a>
                        </div>
                    </div>
                </div>
                </form>
            </div>
            <div role="tabpanel" class="tab-pane" id="op_<?php echo $row["id"];?>" data-role="shop-op">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="babyinfor-frame-tit">
                                <a href="<?php echo $row["shopurl"];?>" target="_blank"><?php echo $row["nick"];?> </a>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <small> <strong>店铺相关</strong></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="javascript:void(0)"  data-click="stop" data-nick="<?php echo $row["nick"];?>" data-url="<?php echo Yii::app()->urlManager->createUrl('/main/shop/stop');?>"><small>1. 服务流失..</small></a>
                        </div>
                    </div>
<!--                    <div class="row">-->
<!--                        <div class="col-md-12">-->
<!--                            <a href="javascript:void(0)" data-click="off" data-nick="--><?php //echo $row["nick"];?><!--" data-url="--><?php //echo Yii::app()->urlManager->createUrl('/main/shop/off');?><!--"><small>2. 终止合作..</small></a>-->
<!--                        </div>-->
<!--                    </div>-->
                    <div class="row">
                        <div class="col-md-12">
                            <small><strong>推广相关</strong></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="<?php echo Yii::app()->urlManager->createUrl('/zuanshi/vie/index',array("nick"=>$row["nick"]));?>" target="_blank"><small>1. 查看竞品店铺..</small></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="<?php echo Yii::app()->urlManager->createUrl('/zuanshi/setting/index2',array("nick"=>$row["nick"]));?>" target="_blank"><small>2. 智·钻批量推广设置..</small></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="http://yj.da-mai.com/index.php?r=milestone/campaign/campaign&nick=<?php echo $row["nick"];?>" target="_blank"><small>3. 大麦优驾推广设置..</small></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="babyinfor-interface">
                            <a href="javascript:void(0);" class="zuanshi quick_login_btn" extension="uninstall" login-type="zuanshi" data-nick="<?php echo $row["nick"];?>" data-password="<?php echo $row["login_password"];?>" data-username="<?php echo $row["login_nick"];?>">智·钻</a>
                            <a href="javascript:void(0);" class="shenyicanmou quick_login_btn" extension="uninstall" login-type="shenyicanmou" data-nick="<?php echo $row["nick"];?>" data-password="<?php echo $row["login_password"];?>" data-username="<?php echo $row["login_nick"];?>">生意参谋</a>
                            <a href="javascript:void(0);" class="zhitongche quick_login_btn" extension="uninstall" login-type="zhitongche" data-nick="<?php echo $row["nick"];?>" data-password="<?php echo $row["login_password"];?>" data-username="<?php echo $row["login_nick"];?>">直通车</a>
                            <a href="javascript:void(0);" class="dmp quick_login_btn" extension="uninstall" login-type="dmp" data-nick="<?php echo $row["nick"];?>" data-password="<?php echo $row["login_password"];?>" data-username="<?php echo $row["login_nick"];?>">达摩盘</a>
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="more_<?php echo $row["id"];?>" data-role="shop-more">

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="babyinfor-frame-tit">
                                <a href="<?php echo $row["shopurl"];?>" target="_blank"><?php echo $row["nick"];?> </a>
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="babyinfor-interface">
                            <a href="javascript:void(0);" class="zuanshi quick_login_btn" extension="uninstall" login-type="zuanshi" data-nick="<?php echo $row["nick"];?>" data-password="<?php echo $row["login_password"];?>" data-username="<?php echo $row["login_nick"];?>">智·钻</a>
                            <a href="javascript:void(0);" class="shenyicanmou quick_login_btn" extension="uninstall" login-type="shenyicanmou" data-nick="<?php echo $row["nick"];?>" data-password="<?php echo $row["login_password"];?>" data-username="<?php echo $row["login_nick"];?>">生意参谋</a>
                            <a href="javascript:void(0);" class="zhitongche quick_login_btn" extension="uninstall" login-type="zhitongche" data-nick="<?php echo $row["nick"];?>" data-password="<?php echo $row["login_password"];?>" data-username="<?php echo $row["login_nick"];?>">直通车</a>
                            <a href="javascript:void(0);" class="dmp quick_login_btn" extension="uninstall" login-type="dmp" data-nick="<?php echo $row["nick"];?>" data-password="<?php echo $row["login_password"];?>" data-username="<?php echo $row["login_nick"];?>">达摩盘</a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="babyinfor-interface">
                            <a href="javascript:void(0);" class="branding quick_login_btn" extension="uninstall" login-type="branding" data-nick="<?php echo $row["nick"];?>" data-password="<?php echo $row["login_password"];?>" data-username="<?php echo $row["login_nick"];?>">品销宝</a>
                       </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>