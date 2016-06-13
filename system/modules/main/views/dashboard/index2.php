<link rel="stylesheet" href="<?php echo STATICURL.'/base/css/index.css'; ?>">
<link rel="stylesheet" href="<?php echo STATICURL.'/main/css/index.css'; ?>">
<div class="index-table-div">

<section class="content-header shop-list-cont">
    <div class="com-list-tit" style="display: block;">
        <i class="shop-list-icon"></i>
        <span class="shop-list-txt">我的店铺</span>
        <small>
            <a href="<?php echo $this->createUrl("/main/shop/index");?>"><span class="label label-default">新增店铺</span></a>
            <a href="<?php echo $this->createUrl("/main/default/index");?>"><span class="label label-default">我的店铺</span></a>
            <a href="<?php echo $this->createUrl("/main/default/stoplist");?>"><span class="label label-default">流失店铺</span></a>
            <!--                    <a href="--><?php //echo $this->createUrl("/main/case/index");?><!--"><span class="label label-default">CASE列表</span></a>-->
            <a href="<?php echo $this->createUrl("/main/dashboard/index");?>"><span class="label label-info">总览</span></a>

        </small>
    </div>
</section>

<section class="content">

    <div class="row">
        <div class="col-lg-3 col-xs-6">

            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>
                        <?php echo $summary["total"];?>
                    </h3>
                    <p>
                        总店铺数
                    </p>

                </div>
                <a href="javascript:void(0)" class="small-box-footer">
                    查看详细 <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">

            <div class="small-box bg-green">
                <div class="inner">
                    <h3>
                        <?php echo $summary["opentotal"];?>
                    </h3>
                    <p>
                       合作中店铺数
                    </p>
                </div>

                <a href="<?php echo $this->createUrl("/main/default/index");?>" class="small-box-footer">
                    查看详细 <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">

            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>
                        <?php echo $summary["stoptotal"];?>
                    </h3>
                    <p>
                        暂停店铺数
                    </p>
                </div>

                <a href="<?php echo $this->createUrl("/main/default/stoplist");?>" class="small-box-footer">
                    查看详细 <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">

            <div class="small-box bg-red">
                <div class="inner">
                    <h3>
                        <?php echo $summary["offtotal"];?>
                    </h3>
                    <p>
                        流失店铺数
                    </p>

                </div>
                <a href="<?php echo $this->createUrl("/main/default/stoplist");?>" class="small-box-footer">
                    查看详细 <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-xs-6">

            <div class="small-box bg-blue">
                <div class="inner">
                    <h3>
                        <?php echo $summary["ztc_zuanshi_total"];?>
                    </h3>
                    <p>
                        直钻业务
                    </p>

                </div>
                <a href="<?php echo $this->createUrl("/main/default/index",array("shoptype"=>"直钻业务","q"=>"","pic"=>"","page"=>1));?>" class="small-box-footer">
                    查看详细 <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">

            <div class="small-box bg-purple">
                <div class="inner">
                    <h3>
                        <?php echo $summary["ztc_total"];?>
                    </h3>
                    <p>
                        直通车业务
                    </p>
                </div>

                <a href="<?php echo $this->createUrl("/main/default/index",array("shoptype"=>"直通车业务","q"=>"","pic"=>"","page"=>1));?>" class="small-box-footer">
                    查看详细 <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">

            <div class="small-box bg-teal">
                <div class="inner">
                    <h3>
                        <?php echo $summary["zuanshi_total"];?>
                    </h3>
                    <p>
                        钻展业务
                    </p>
                </div>

                <a href="<?php echo $this->createUrl("/main/default/index",array("shoptype"=>"钻展业务","q"=>"","pic"=>"","page"=>1));?>" class="small-box-footer">
                    查看详细 <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">

            <div class="small-box bg-maroon">
                <div class="inner">
                    <h3>
                        <?php echo $summary["opentotal"]-$summary["ztc_zuanshi_total"]-$summary["zuanshi_total"]-$summary["ztc_total"];?>
                    </h3>
                    <p>
                        其它业务
                    </p>

                </div>
                <a href="javascript:void(0)" class="small-box-footer">
                    查看详细 <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="baby-frame-h3">
                        <i class="tit-frame-icon"></i>
                    直通车
                        </h3>
                </div>

                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>负责人</th>
                                <th>操作店铺数</th>
                                <th>直钻业务店铺数</th>
                                <th>实际直钻业务店铺数</th>
                                <th>暂停店铺数</th>
                                <th>流失店铺数</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php foreach($detail["ztc"] as $log):?>
                                <tr>
                                    <td><a href="<?php echo $this->createUrl("/main/default/index",array("q"=>$log["pic"],"pic"=>"","page"=>1));?>" class="btn-link"><?php echo $log["pic"];?></strong> </a></td>
                                    <td><?php echo $log["opentotal"];?></td>
                                    <td> <?php echo $log["typetotal1"];?></td>
                                    <td> <?php echo $log["typetotal4"];?></td>
                                    <td> <?php echo $log["stoptotal"];?></td>
                                    <td> <?php echo $log["offtotal"];?></td>
                                </tr>

                            <?php endforeach;?>


                            </tbody>
                        </table>
                    </div>

                </div>

            </div>

        </div>
        <div class="col-lg-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="baby-frame-h3">
                        <i class="tit-frame-icon"></i>
                        钻展
                    </h3>
                </div>

                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>负责人</th>
                                <th>操作店铺数</th>
                                <th>直钻业务店铺数</th>
                                <th>实际直钻业务店铺数</th>
                                <th>暂停店铺数</th>
                                <th>流失店铺数</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php foreach($detail["zuanshi"] as $log):?>
                                <tr>
                                    <td><a href="<?php echo $this->createUrl("/main/default/index",array("q"=>$log["pic"],"pic"=>"","page"=>1));?>" class="btn-link"><?php echo $log["pic"];?></strong> </a></td>
                                    <td><?php echo $log["opentotal"];?></td>
                                    <td> <?php echo $log["typetotal1"];?></td>
                                    <td> <?php echo $log["typetotal4"];?></td>
                                    <td> <?php echo $log["stoptotal"];?></td>
                                    <td> <?php echo $log["offtotal"];?></td>
                                </tr>

                            <?php endforeach;?>


                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>


        </section>

    </div>

<script type="text/javascript">
    $(document).ready(function(){
        $(".top-ul>li").eq(0).addClass("top-li-hover");
    })

</script>