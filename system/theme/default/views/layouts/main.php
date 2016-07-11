<!doctype html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="edge" />
	<meta charset=<?php echo CHARSET; ?> />
	<title>精准投放管理平台</title>

	<link rel="shortcut icon" href="<?php echo STATICURL; ?>/base/image/icon.png">
	<meta name="generator" content="" />
	<meta name="author" content="" />
	<meta name="copyright" content="" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <?php
    /** @var \CClientScript $cs */
   // $cs = Yii::app()->clientScript;
   // $cs->registerCoreScript("jquery");
    ?>

	<!-- load css -->
	<link rel="stylesheet" href="<?php echo STATICURL.'/base/css/bootstrap.min.css'; ?>" />
    <link rel="stylesheet" href="<?php echo STATICURL.'/base/js/plugins/datatables/dataTables.bootstrap.css'; ?>" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo STATICURL.'/base/css/font-awesome.min.css'; ?>" />
    <link rel="stylesheet" href="<?php echo STATICURL.'/base/css/ionicons.min.css'; ?>" />

    <link rel="stylesheet" href="<?php echo STATICURL.'/base/css/common.css'; ?>">
    <link rel="stylesheet" href="<?php echo STATICURL.'/base/css/style.css'; ?>">
    <link rel="stylesheet" href="<?php echo STATICURL.'/base/css/layout.css'; ?>">

    <!-- jQuery 2.1.4 -->
    <script src='<?php echo STATICURL.'/base/js/plugins/jQuery/jQuery-2.1.4.min.js'; ?>'></script>
    <script src='<?php echo STATICURL.'/base/js/plugins/jQuery/jquery.cookie.js'; ?>'></script>
    <script src='<?php echo STATICURL."/base/js/layout.js"; ?>'></script>
    <script src='<?php echo STATICURL."/base/js/app.js"; ?>'></script>

    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo STATICURL.'/base/js/plugins/select2/select2.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo STATICURL.'/base/js/plugins/select2/select2-bootstrap.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo STATICURL.'/base/js/plugins/datepicker/datepicker3.css'; ?>">
    <link rel="stylesheet" href="<?php echo STATICURL.'/base/js/plugins/daterangepicker/daterangepicker-bs3.css';?>">

    <link rel="stylesheet" href="<?php echo STATICURL.'/base/js/plugins/jquery-artDialog/artDialog-simple.css'; ?>">
    <link rel="stylesheet" href="<?php echo STATICURL.'/base/js/plugins/jquery-showLoading/showLoading.css'; ?>">
    <link rel="stylesheet" href="<?php echo STATICURL.'/base/js/plugins/dropify/css/dropify.min.css'; ?>">

    <?php if(!\cloud\core\utils\Env::isLogin()):?>
        <script src='<?php echo STATICURL.'/main/js/login.js'; ?>'></script>
        <script type="text/javascript">

                $.user.login("http://login.da-mai.com/", function (data) {

                    $.ajax({
                        type: "post",
                        url: "<?php echo $this->createUrl("/user/default/login");?>",
                        data: {user: data},
                        dataType: "json",
                        success: function () {
                            window.location.reload();
                        }
                    });
                });

        </script>

    <?php endif;?>
    <!-- AdminLTE App -->
    <!--    <script src="dist/js/app.min.js"></script>-->
</head>

<body class="hold-transition skin-blue sidebar-mini">
<noscript>抱歉！该网页需要JavaScript脚本的支持，请启用JavaScript脚本</noscript>
<?php if(\cloud\core\utils\Env::isLogin()):?>
<div class="wrapper">

<!-- Main Header -->
<header class="main-header">


    <!-- Header Navbar -->
    <nav class="navbar" role="navigation">

        <!-- Navbar Right Menu -->

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown">  <a href="<?php echo $this->createUrl("/main/dashboard/index");?>"><i class="fa fa-dashboard"></i> 店铺总览</a></li>
                <?php $tool = \application\modules\main\model\Plugin::fetchVersion();?>
<!--                <li class="dropdown"><a href="--><?php //echo Yii::app()->baseUrl;?><!--/upload/CPSTools.crx"><i class="fa fa-download"></i> 下载2.8.3</a></li>-->
                <li class="dropdown"><a href="<?php echo $this->createUrl("/file/default/down",array("md5"=>$tool["file_md5"]));?>">
                        <i class="fa fa-download"></i> 下载插件
                        <span class="label label-warning"><?php echo $tool["version"];?></span>
                    </a></li>
                <!-- User Account: style can be found in dropdown.less -->
                <li class="user user-menu">
                    <a href="#"> <i class="fa fa-user"></i>
                        <span class="hidden-xs">
                            <?php $user =\cloud\core\utils\Env::getUser();if(!empty($user)){echo $user["username"];}else{echo "游客";}?></span>
                    </a>
                </li>
                <li class="dropdown browser-plugin">
                    <a class="plugin-version" data-version="<?php echo $tool["version"];?>">
                        <i class="fa fa-windows"></i>
                        <span class="label label-danger">0</span>
                    </a>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <!--<li>
                    <a href="#" data-toggle="sidebar"><i class="fa fa-gears"></i></a>
                </li>-->
            </ul>
        </div>

    </nav>

    <div class="top-nav ">
        <div class="top container">
            <div class="logo">
                <img src="<?php echo STATICURL.'/base/image/logo.png';?>" alt="精准投放管理平台">
            </div>
            <ul class="top-ul tab-tit">
                <li class="">
                    <a href="<?php echo $this->createUrl("/main/default/index");?>">
                        <p class="top-icon-p"><i class="index-icon"></i></p>

                        <p>我的店铺</p>
                    </a>
                </li>
                <li><a href="<?php echo $this->createUrl("/zuanshi/dashboard/index");?>" target="_blank">

                        <p class="top-icon-p"><i class="zuanshi-icon"></i></p>

                        <p>智·钻</p>
                    </a>
                </li>
             
                <li>
                    <a href="<?php echo $this->createUrl("/ztc/default/index");?>" target="_blank">

                        <p class="top-icon-p"><i class="ztc-icon"></i></p>

                        <p>直通车</p>
                    </a>
                </li>
                <li>
                    <a href="http://yunying.da-mai.com/" target="_blank">

                        <p class="top-icon-p"><i class="yunying-icon"></i></p>

                        <p>运营规划</p>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</header>

<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
    <div class="tips-wrapper"></div>

    <?php echo $content; ?>

</div>
<!-- /.content-wrapper -->

<!-- Main Footer -->
<footer class="main-footer">
</footer>

</div>

    <div class="scroll-top-box" style="display: none;">  </div>
<!-- REQUIRED JS SCRIPTS -->



<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
<script src='<?php echo STATICURL."/base/js/bootstrap.min.js?".VERSION; ?>'></script>
<script src='<?php echo STATICURL."/base/js/plugins/tmpl/jquery.tmpl.min.js"; ?>'></script>
<script src='<?php echo STATICURL."/base/js/plugins/draggable/jquery-ui-1.10.4.custom.min.js"; ?>'></script>
<script src='<?php echo STATICURL."/base/js/plugins/jquery-artDialog/jquery.artDialog.js"; ?>'></script>
<script src='<?php echo STATICURL."/base/js/plugins/jquery-showLoading/jquery.showLoading.min.js"; ?>'></script>
<script src='<?php echo STATICURL."/base/js/plugins/highcharts.js"; ?>'></script>
<script src='<?php echo STATICURL."/base/js/plugins/select2/select2.min.js"; ?>'></script>
<script src='<?php echo STATICURL."/base/js/plugins/datepicker/bootstrap-datepicker.js"; ?>'></script>
<script src='<?php echo STATICURL."/base/js/plugins/datepicker/locales/bootstrap-datepicker.zh-CN.js"; ?>'></script>

    <script src='<?php echo STATICURL."/base/js/plugins/daterangepicker/moment.min.js"; ?>'></script>
    <script src='<?php echo STATICURL."/base/js/plugins/daterangepicker/daterangepicker.js"; ?>'></script>

<script src='<?php echo STATICURL."/base/js/plugins/datatables/jquery.dataTables.min.js"; ?>'></script>
<script src='<?php echo STATICURL."/base/js/plugins/datatables/dataTables.bootstrap.min.js"; ?>'></script>
    <script src='<?php echo STATICURL."/base/js/plugins/jquery-shiftcheckbox/jquery.shiftcheckbox.js"; ?>'></script>

<script src='<?php echo STATICURL."/base/js/plugins/freezeheader/jquery.freezeheader.js"; ?>'></script>

    <script src='<?php echo STATICURL."/base/js/plugins/dropify/js/dropify.min.js"; ?>'></script>

<!--    <script src='--><?php //echo STATICURL."/base/js/plugins/tinymce/tinymce.min.js"; ?><!--'></script>-->


    <script src='<?php echo STATICURL."/base/js/score.js"; ?>'></script>
    <script type="text/javascript">
        $(document).ready(function(){
            var plugininstall = false;
            window.addEventListener('message',function(event){
                if(event && event.data && event.data.type){
                    switch (event.data.type){
                        case "CPSTOOLS_EXTENSION_INSTALL":
                            plugininstall = true;
                            if(event.data.upgrade)
                                app.confirm("精准投放平台小助手有新的版本发布,是否立刻下载安装?",function(){
                                    window.location.href="<?php echo $this->createUrl("/file/default/down",array("md5"=>$tool["file_md5"]));?>";
                                },function(){});
                            break;
                    }
                }

            });

            setTimeout(function(){
                if(!plugininstall){
                    app.confirm("精准投放平台小助手有新的版本发布,是否立刻下载安装?",function(){
                        window.location.href="<?php echo $this->createUrl("/file/default/down",array("md5"=>$tool["file_md5"]));?>";
                    },function(){});
                }
            },15000);
        })
    </script>


<?php endif;?>
</body>

</html>