<?php
$user = \cloud\core\utils\Env::getUser();
$username = empty($user)?"游客":$user["username"];
?>

<link rel="stylesheet" href="<?php echo STATICURL.'/main/css/index.css'; ?>">

<div class="index-table-div">

    <div class="search-box">
        <div class="shop-list-cont" id="shop-search">
            <div class="search-log" style="display: none;"> </div>
            <div class="search-left com-list-tit" style="display: block;">
                <span class="shop-list-icon"></span>
                <span class="shop-list-txt">我的店铺</span>
                <small>
                    <a href="<?php echo $this->createUrl("/main/shop/index");?>"><span class="label label-default">新增店铺</span></a>
                    <a href="<?php echo $this->createUrl("/main/default/index");?>"><span class="label label-info">我的店铺</span></a>
                    <a href="<?php echo $this->createUrl("/main/default/beinglost");?>"><span class="label label-default">当月流失店铺</span></a>
                    <a href="<?php echo $this->createUrl("/main/default/stoplist");?>"><span class="label label-default">流失店铺</span></a>
                    <a href="<?php echo $this->createUrl("/main/dashboard/index");?>"><span class="label label-default">总览</span></a>

                </small>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <strong>
                            未完成事项
                        </strong>
                    </div>

                    <div class="panel-body">
                        <div data-role="my-todo" class="" data-load="overlay" data-tmpl="my-todo-list-tmpl" data-url="<?php echo $this->createUrl("/main/todo/my",array("pic"=>$username));?>"></div>

                    </div>

                </div>

            </div>
            <div class="col-lg-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <strong>
                            计划事项
                        </strong>
                    </div>

                    <div class="panel-body">
                        <div class="table-responsive">

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>