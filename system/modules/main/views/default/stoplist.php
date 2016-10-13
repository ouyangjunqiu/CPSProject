<script src='<?php echo STATICURL."/main/js/shop.js"; ?>'></script>

<link rel="stylesheet" href="<?php echo STATICURL.'/main/css/index.css'; ?>">

<div class="index-table-div">

    <div class="search-box">
        <div class="shop-list-cont" id="shop-search">
            <div class="search-left com-list-tit" style="display: block;">
                <span class="shop-list-icon"></span>
                <span class="shop-list-txt">我的店铺</span>
                <small>
                    <a href="<?php echo $this->createUrl("/main/default/index");?>"><span class="label label-default">我的店铺</span></a>
                    <a href="<?php echo $this->createUrl("/main/default/beinglost");?>"><span class="label label-default">当月流失店铺</span></a>
                    <a href="<?php echo $this->createUrl("/main/default/stoplist");?>"><span class="label label-info">流失店铺</span></a>
                </small>
            </div>
            <div class="search-right">
                <?php $this->widget("application\\modules\\main\\widgets\\ShopSearchWidget",array("url"=>$this->createUrl("/main/default/stoplist",array("page"=>1)),"query"=>$query));?>
            </div>
        </div>
    </div>
    <table>
        <tbody>
        <?php foreach($list as $row):?>
            <tr>
                <td class="babyInforTb-td-left">
                    <?php $this->widget("application\\modules\\main\\widgets\\ShopStopManagerWidget",array("shop"=>$row));?>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
    <div class="c-pager">
    </div>
</div>

<?php $this->widget("application\\modules\\main\\widgets\\ShopTodoWidget");?>
<script type="application/javascript">

    $(document).ready(function(){

        $(".top-ul>li").eq(0).addClass("top-li-hover");


        $(".c-pager").jPager({currentPage: <?php echo $pager["page"]-1;?>, total: <?php echo $pager["count"];?>, pageSize: <?php echo $pager["page_size"];?>,events: function(dp){
            location.href = app.url("<?php echo $this->createUrl('/main/default/stoplist');?>",{page:dp.index+1})
        }});

    });


</script>

