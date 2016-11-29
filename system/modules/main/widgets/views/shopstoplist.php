<div class="shop-info-wrap">
    <a name="<?php echo $row["nick"];?>" class="_anchor"></a>
    <div class="tab">
        <ul class="nav nav-tabs shop-nav" role="tablist">
            <li role="presentation" class="active"><a href="#home_<?php echo $row["id"];?>" title="基本信息" aria-controls="home_<?php echo $row["id"];?>" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-home"></i><span>基本信息</span></a></li>
            <li role="presentation"><a href="#op_<?php echo $row["id"];?>" title="店铺操作" aria-controls="op_<?php echo $row["id"];?>" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-cog"></i><span>店铺操作</span></a></li>
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
                                <?php if(!empty($row["shopcatname"])):?>
                                    <o class="tit"><?php echo $row["shopcatname"];?></o>
                                <?php endif;?>
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

                </div>
            </div>

        </div>

    </div>
</div>