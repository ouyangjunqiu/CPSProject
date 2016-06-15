<form action="<?php echo $this->createUrl("/file/default/upload");?>" method="post" enctype="multipart/form-data">
    <input type="file" name="file" class="dropify" data-height="300" data-max-file-size="2M"/>
    <input type="submit" class="btn btn-warning" value="确定">
</form>


<script type="application/javascript">

    $(document).ready(function(){

        $(".top-ul>li").eq(2).addClass("top-li-hover");

        $('.dropify').dropify();

    });

</script>

