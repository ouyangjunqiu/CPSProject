<link rel="stylesheet" href="<?php echo STATICURL.'/main/css/index.css'; ?>">

<div class="index-table-div">

    <div class="search-box">
        <div class="shop-list-cont">
            <div class="row">
                <div class="col-md-4">
                    <div class="com-list-tit" style="display: block;">
                        <span class="shop-list-icon"></span>
                        <span class="shop-list-txt">DMP标签汇总</span>
                        <small>
                            <a href="<?php echo $this->createUrl("/zuanshi/adzone/index");?>"><span class="label label-default">钻展资源位</span></a>
                            <a href="<?php echo $this->createUrl("/dmp/tag/index");?>"><span class="label label-info">DMP标签</span></a>
                        </small>
                    </div>
                </div>
                <div class="col-md-4">

                </div>

                <div class="col-md-3">

                </div>
                <div class="col-md-1">
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 10px;margin-bottom: 10px;">
    </div>

    <table class="baby-frame-table" id="table-fixed" style="table-layout: fixed;">
        <thead class="header">
        <tr><th>标签类型</th><th>一级分类</th><th>二级分类</th><th>标签名称</th><th>标签选项</th><th>标签描述</th><th>提供方</th><th>质量分</th><th>有效期</th></tr>
        </thead>
        <tbody>
        <?php foreach($list as $tag):?>
            <tr>
                <td><?php echo $tag["t0"];?></td>
                <td><?php echo $tag["t1"];?></td>
                <td><?php echo $tag["t2"];?></td>
                <td><?php echo $tag["name"];?></td>
                <td><?php echo $tag["radios"];?></td>
                <td><p class="w4" title="<?php echo $tag["remark"];?>"><?php echo $tag["remark"];?></p></td>
                <td><?php echo $tag["provider"];?></td>
                <td><?php echo $tag["qscore"];?></td>
                <td><?php echo $tag["max_date"];?></td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>


    <script type="application/javascript">

        $(document).ready(function(){
            var self = $(this);

            $(".top-ul>li").eq(2).addClass("top-li-hover");

            $("#searchBtn").click(function(){
                window.location.href='<?php echo $this->createUrl("/zuanshi/rpt/index");?>';
            });

            $("#table-fixed").freezeHeader();

        });
    </script>

