<link rel="stylesheet" href="<?php echo STATICURL.'/base/css/index.css'; ?>">
<link rel="stylesheet" href="<?php echo STATICURL.'/main/css/index.css'; ?>">
<div class="index-table-div">

<section class="content-header shop-list-cont">
    <div class="com-list-tit" style="display: block;">
        <i class="shop-list-icon"></i>
        <span class="shop-list-txt">总览</span>
    </div>
    <ol class="breadcrumb">
        <li><a href="<?php echo Yii::app()->baseUrl;?>"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li class="active">总览</li>
    </ol>
</section>

<section class="content">

    <div class="row">
        <div class="col-lg-3 col-xs-6">

            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>
                        <?php echo $summary["shoptotal"];?>
                    </h3>
                    <p>
                        总店铺数
                    </p>
                </div>

                <a href="<?php echo $this->createUrl("/main/default/index");?>" class="small-box-footer">
                    查看详细 <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">

            <div class="small-box bg-green">
                <div class="inner">
                    <h3>
                        <?php echo $summary["casetotal"];?>
                    </h3>
                    <p>
                       CASE总数
                    </p>
                </div>

                <a href="<?php echo $this->createUrl("/main/case/index");?>" class="small-box-footer">
                    查看详细 <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">

            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>
                        <?php echo $summary["caseruntotal_ztc"];?>
                    </h3>
                    <p>
                        直通车投放的CASE总数
                    </p>
                </div>

                <a href="<?php echo $this->createUrl("/main/case/index");?>" class="small-box-footer">
                    查看详细 <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">

            <div class="small-box bg-red">
                <div class="inner">
                    <h3>
                        <?php echo $summary["caseruntotal_zuanshi"];?>
                    </h3>
                    <p>
                        钻展投放的CASE总数
                    </p>
                </div>

                <a href="<?php echo $this->createUrl("/main/case/index");?>" class="small-box-footer">
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
                                <th>投放的店铺数</th>
                                <th>投放的CASE总数</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php foreach($detail["ztc"] as $log):?>
                                <tr>
                                    <td><a href="<?php echo $this->createUrl("/main/default/index",array("pic"=>$log["pic"]));?>" class="btn-link"><?php echo $log["pic"];?></strong> </a></td>
                                    <td><?php echo $log["shoptotal"];?></td>
                                    <td> <?php echo $log["casetotal"];?></td>
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
                                <th>投放的店铺数</th>
                                <th>投放的CASE总数</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php foreach($detail["zuanshi"] as $log):?>
                                <tr>
                                    <td><a href="<?php echo $this->createUrl("/main/default/index",array("pic"=>$log["pic"]));?>" class="btn-link"><?php echo $log["pic"];?></strong> </a></td>
                                    <td><?php echo $log["shoptotal"];?></td>
                                    <td> <?php echo $log["casetotal"];?></td>
                                </tr>

                            <?php endforeach;?>


                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="baby-frame-h3">
                        <i class="tit-frame-icon"></i>
                        历史记录   <small>(<?php echo date("Y-m-d",strtotime("-7 days"));?>~<?php echo date("Y-m-d",strtotime("-1 days"));?>)</small>
                    </h3>

                </div>
            </div>

        </div>

        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>日期</th>
                        <th>总店铺数</th>
                        <th>CASE总数</th>
                        <th>直通车投放的CASE总数</th>
                        <th>钻展投放的CASE总数</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach($logs as $log):?>
                    <tr>
                        <td><a href="#" class="btn-link"><?php echo $log["log_date"];?></strong> </a></td>
                        <td><?php echo $log["shoptotal"];?></td>
                        <td> <?php echo $log["casetotal"];?></td>
                        <td><?php echo $log["caseruntotal_ztc"];?></td>
                        <td>
                            <?php echo $log["caseruntotal_zuanshi"];?>
                        </td>
                    </tr>

                    <?php endforeach;?>


                    </tbody>
                </table>
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