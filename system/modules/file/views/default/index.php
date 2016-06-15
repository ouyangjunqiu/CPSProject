<input type="file" class="dropify" data-height="300" data-max-file-size="2M"/>



<script type="application/javascript">

    $(document).ready(function(){

        $(".top-ul>li").eq(2).addClass("top-li-hover");

        $('.dropify').dropify();

        $(".c-pager").jPager({currentPage: <?php echo $pager["page"]-1;?>, total: <?php echo $pager["count"];?>, pageSize: <?php echo $pager["page_size"];?>,events: function(dp){
            var nick = $("input[data-ename=nick]").val();
            var pic = $("input[data-ename=pic]").val();
            location.href = app.url("<?php echo $this->createUrl('/ztc/default/index');?>",{nick:nick,pic:pic,page:dp.index+1})
        }});

    });

</script>

