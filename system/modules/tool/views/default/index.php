<div class="index-table-div">

    <div class="search-box">
        <div class="shop-list-cont" id="shop-search">
            <div class="search-left com-list-tit" style="display: block;">
                <span class="shop-list-icon"></span>
                <span class="shop-list-txt">常用工具</span>
                <small>
                    <a href="<?php echo $this->createUrl("/tool/default/index");?>"><span class="label label-info">宝贝详情</span></a>

                </small>
            </div>
            <div class="search-right">

            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-4">

        </div>
        <div class="col-md-8">
            <form action="<?php echo $this->createUrl("/tool/default/getitem");?>" method="post" class="form-inline" id="item-detail-request-form">
                <small>宝贝编号:</small>
                <div class="input-group">
                    <input class="form-control" name="num_iid" value="" />
                        <span class="input-group-addon">
                            <i class="fa fa-search"></i>
                        </span>
                </div>
            </form>
        </div>
    </div>

    <div class="panel" id="item-detail-panel" style="display: none">
        <div class="panel-body">

        </div>
    </div>
</div>

<script type="text/x-jquery-tmpl" id="item-detail-tmpl">
{{if isSuccess}}
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <a href="${data.detail_url}" class="thumbnail">
          <img data-src="${data.pic_url}" alt="${data.title}">
        </a>
      </div>
      <div class="col-md-9">
        <p>${data.title}</p>
        <p>${data.price}</p>
      </div>
    </div>

    <table class="table">
        <thead>
            <tr class="small"><td>类目</td><td>属性</td><td>值</td></tr>

        </thead>
        <tbody>
             {{each(i,v) data.props}}
                 <tr>
                    <td>${data.category_tree}</td>
                    <td>${v[2]}</td>
                    <td>${v[3]}</td>
                 </tr>

            {{/each}}
        </tbody>

    </table>
{{else}}
    <p>${msg}</p>
{{/if}}
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

                      $("#item-detail-panel .panel-body").html($("#item-detail-tmpl").tmpl(resp));
                  }
              });
              return false;

          }
      });

  });
</script>