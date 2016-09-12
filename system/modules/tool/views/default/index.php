<div class="index-table-div">

    <div class="search-box">
        <div class="row">
            <div class="col-md-4">
                <small>宝贝编号:</small>
            </div>
            <div class="col-md-8">
                <form action="<?php echo $this->createUrl("/tool/default/getitem");?>" method="post" class="form-inline" id="item-detail-request-form">
                    <div class="input-group">
                        <input class="form-control" name="num_iid" value="" />
                        <span class="input-group-addon">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="panel" id="item-detail-panel" style="display: none">
        <div class="panel-body">

        </div>
    </div>
</div>

<script type="text/x-jquery-tmpl" id="item-detail-tmpl">
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <a href="${detail_url}" class="thumbnail">
          <img data-src="${pic_url}" alt="${title}">
        </a>
      </div>
      <div class="col-md-9">
        <p>${title}</p>
        <p>${price}</p>
      </div>
    </div>

    <table class="">
    </table>
</script>



<script type="text/javascript">
  $(document).ready(function(){

      var self = $(this);

      $(".top-ul>li").eq(3).addClass("top-li-hover");

      $("#item-detail-request-form").keydown(function(event){
          var self = $(this);
          if(event.which == 13){
              $.ajax({
                  url: self.attr("action"),
                  data: self.serialize(),
                  type:"post",
                  dataType:"json",
                  success:function(resp){
                      $("#item-detail-panel").show();

                      $("#item-detail-panel .panel-body").html(JSON.stringify(resp));
                  }
              });
              return false;

          }
      });

  });
</script>