<div class="shop-info-wrap">
    <a name="<?php echo $row["nick"];?>" class="_anchor"></a>
    <div class="tab">
        <ul class="nav nav-tabs shop-nav" role="tablist">
            <li role="presentation" class="active"><a href="#home_<?php echo $row["id"];?>" title="基本信息" aria-controls="home_<?php echo $row["id"];?>" role="tab" data-toggle="tab"><i class="fa fa-home"></i><span>基本信息</span></a></li>
            <li role="presentation"><a href="#op_<?php echo $row["id"];?>" title="店铺操作" aria-controls="op_<?php echo $row["id"];?>" role="tab" data-toggle="tab"><i class="fa fa-cog"></i><span>店铺操作</span></a></li>
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
                            <div class="col-md-4"><small>运营对接人:</small></div>
                            <div class="col-md-6">
                                <span class="pic_read">
                                    <strong><?php echo $row["pic"];?></strong>
                                </span>

                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><small>钻展负责人:</small></div>
                            <div class="col-md-6">
                                <span class="pic_read">
                                    <strong><?php echo $row["zuanshi_pic"];?></strong>
                                </span>

                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><small>直通车负责人:</small></div>
                            <div class="col-md-6">
                                <span class="pic_read">
                                    <strong><?php echo $row["ztc_pic"];?></strong>
                                </span>

                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><small>大数据负责人:</small></div>
                            <div class="col-md-6">
                                <span class="pic_read">
                                    <strong><?php echo $row["bigdata_pic"];?></strong>
                                </span>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"><small>快速交谈:</small></div>
                            <div class="col-md-9">
                                <a href="http://www.taobao.com/webww/ww.php?ver=3&touid=<?php echo $row["nick"];?>&siteid=cntaobao&status=1&charset=u8" target="_blank"><i class="contact contact-wangwang"></i></a>
                                <?php if(!empty($row["qq"])):?><a href="tencent://message/?uin=<?php echo $row["qq"];?>&Site=QQ交谈&Menu=yes"><i class="contact contact-qq"></i></a><?php endif;?>
                                <?php if(!empty($row["email"])):?><a href="mailto:<?php echo $row["email"];?>"><i class="contact contact-email"></i></a><?php endif;?>

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
                            <a href="javascript:void(0)"  data-click="restart" data-nick="<?php echo $row["nick"];?>" data-url="<?php echo Yii::app()->urlManager->createUrl('/main/shop/restart');?>"><small>1. 恢复服务..</small></a>
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
                            <a href="<?php echo Yii::app()->urlManager->createUrl('/zuanshi/setting/index2',array("nick"=>$row["nick"]));?>" target="_blank"><small>2. 智·钻低价推广设置..</small></a>
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

        </div>

    </div>
</div>