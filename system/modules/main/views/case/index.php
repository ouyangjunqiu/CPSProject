<link rel="stylesheet" href="<?php echo STATICURL.'/base/css/index.css'; ?>">
<link rel="stylesheet" href="<?php echo STATICURL.'/main/css/index.css'; ?>">

<div class="index-table-div">

    <div class="search-box">
        <div class="shop-list-cont" id="shop-search">
            <div class="search-left com-list-tit" style="display: block;">
                <span class="shop-list-icon"></span>
                <span class="shop-list-txt">店铺:</span>
                <small>
                    <a href="<?php echo $this->createUrl("/main/shop/index");?>"><span class="label label-default">新增店铺</span></a>
                    <a href="<?php echo $this->createUrl("/main/default/index");?>"><span class="label label-default">合作中</span></a>
                    <a href="<?php echo $this->createUrl("/main/default/stoplist");?>"><span class="label label-default">暂停中</span></a>
                    <a href="<?php echo $this->createUrl("/main/case/index");?>"><span class="label label-info">CASE列表</span></a>

                </small>
            </div>
            <div class="search-right">
                <form action="<?php echo $this->createUrl("/main/case/index");?>" method="post" class="form-inline">
                    <input placeholder="店铺名称" type="text" class="form-control" name="nick" value="<?php echo $query['nick'];?>">
                    <?php echo CHtml::dropDownList("casetype",$query["casetype"],$casetypes,array("class"=>"form-control"));?>
                    <input type="button" class="btn btn-warning" value="搜索" id="searchBtn">
                </form>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 10px;margin-bottom: 10px;">
    </div>

    <table class="baby-frame-table" id="table-fixed" style="table-layout: fixed;">
        <thead class="header">
        <tr>
            <th><small>店铺名</small></th>
            <th><small>CASE类型</small></th>
            <th><small>落地页</small></th>
            <th><small>CASE预算(元/天)</small></th>
            <th><small>直通车预算(元/天)</small></th>
            <th><small>钻展预算(元/天)</small></th>
            <th><small>操作</small></th>
        </tr>

        </thead>
        <tbody>

        <?php foreach($cases as $row):?>
            <tr>
                <td><strong><?php echo $row["nick"];?></strong></td>
                <td>
                    <?php echo $row["casetype"];?>
                </td>
                <td>
                    <a href="<?php echo $row["luodiye"];?>" target="_blank">
                        <small>[<?php echo $row["luodiye_type"];?>]</small>

                        <?php echo !empty($row["luodiye_alias"])?$row["luodiye_alias"]:(strlen($row["luodiye"])>100?substr($row["luodiye"],0,100)."...":$row["luodiye"]);?></a>
                </td>
                <td>
                    <?php echo round($row["budget"]);?>
                </td>
                <td>
                    <?php echo !empty($row["run"]["直通车"])?round($row["run"]["直通车"]["budget"]):0;?>
                </td>
                <td>
                    <?php echo !empty($row["run"]["钻展"])?round($row["run"]["钻展"]["budget"]):0;?>
                </td>
                <td>
                    <a href="<?php echo $this->createUrl("/dmp/group/view",array("nick"=>$row["nick"],"caseid"=>$row["id"]));?>" target="_blank">达摩盘标签应用>></a>
                </td>
            </tr>

        <?php endforeach;?>
        </tbody>
    </table>

    <div class="c-pager">
    </div>
</div>

<script type="application/javascript">

    $(document).ready(function(){

        $("#table-fixed").freezeHeader();

        $("#searchBtn").click(function(){
            $(this).parents("form").submit();
        });

        $(".c-pager").jPager({currentPage: <?php echo $pager["page"]-1;?>, total: <?php echo $pager["count"];?>, pageSize: <?php echo $pager["page_size"];?>,events: function(dp){
            location.href = app.url("<?php echo $this->createUrl('/main/case/index');?>",{page:dp.index+1})
        }});

    });

</script>
