<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh-cn" lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="renderer" content="webkit">
    <meta name="language" content="zh-cn"/>
    <link href="<?php echo THEME_URL;?>css/default.css" type="text/css" rel="stylesheet"/>

    <title>广州大麦信息科技有限公司</title>
    <script type="text/javascript" src="<?php echo THEME_URL;?>js/jquery-1.3.2.js"></script>

    <script type="text/javascript">

        function login_form() {
            document.getElementById('current-login-user').style = "display:none";
            document.getElementById('div-login').style = "inline";
        }
        $(function () {
            var username = $('#LoginForm_username');
            var password = $('#LoginForm_password');

            $('.sub').css('margin-top', '43px');

            username.attr('placeholder', 'OA帐号').css('font-size', '16px');
            password.attr('placeholder', 'OA密码').css('font-size', '16px');

            $('.sub').hover(function () {
                $(this).css('background', '#0A6B9E');
            }, function () {
                $(this).css('background', '#0182C6');
            });


            $('.sub').click(function (event) {
                if (username.val() == '') {
                    $('#code_msg').text('亲，OA帐号不能为空');
                    $('.sub').css('margin-top', '12px');
                    return false;
                }
                if (password.val() == '') {
                    $('#code_msg').text('亲，OA密码不能为空');
                    return false;
                }


            });


        });
    </script>
</head>
<body>
<center>
    <div class="login_container">
        <div class="login-form">
            <div id="div-login">

                <form id="login-form" action="<?php echo BASE_URL.'do2.php';?>" method="post">
                    <div class="login_title">广州大麦信息科技有限公司</div>

                    <dl>
                        <input name="LoginForm[username]" id="LoginForm_username" type="text" />
                    </dl>

                    <dl>
                        <input name="LoginForm[password]" id="LoginForm_password" type="password" />
                    </dl>

                    <div class="login_foot">
                        <dl>
                        </dl>
                        <dl id="code_msg">
                            <?php if(isset($_REQUEST["retry"]) && $_REQUEST["retry"]):?>
                            <div class="errorMessage" id="LoginForm_username_em_">用户名或者密码错误，请重试!</div>
                            <?php endif;?>

                        </dl>
                        <dl>
                            <input autofocus="autofocus" class="sub" type="submit" name="yt0" value="登录" />
                        </dl>
                    </div>
                </form>

                <span class="user_img"></span> <span class="pwd_img"></span>
            </div>
        </div>
    </div>
    <!-- form -->

    <div id="login_footer">
        <div>大麦电商OA系统版本-V1.0</div>
        <div>版权所有&copy; 广州大麦信息科技有限公司 粤ACP备 11088538号-1</div>
    </div>
</center>
</body>
</html>