<?php
return array(
    'param' => array(
        'name' => '用户模块',
        'description' => '核心模块。提供用户管理，登录验证等功能',
        'author' => 'banyanCheung @ ERP Team Inc',
        'version' => '1.0'
    ),
    'config' => array(
        'modules' => array(
            'user' => array(
                'class' => 'application\modules\user\UserModule'
            )
        ),
//        'components' => array(
//            'user' => array(
//                'allowAutoLogin' => 1,
//                'class' => 'application\modules\user\components\User',
//                'loginUrl' => array( 'user/default/login' )
//            ),
//            'messages' => array(
//                'extensionPaths' => array(
//                    'user' => 'application.modules.user.language'
//                )
//            )
//        ),
    )
);

