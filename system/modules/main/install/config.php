<?php
return array(
    'param' => array(
        'name' => '核心模块',
        'description' => '系统核心模块',
        'author' => 'oShine',
        'version' => '1.0',
		'indexShow' => array(
            'link' => 'main/default/index',
        ),
    ),
    'config' => array(
        'modules' => array(
            'main' => array(
                'class' => 'application\modules\main\MainModule'
            )
        ),
        'components' => array(

            'errorHandler' => array(
                'errorAction' => 'main/default/error',
            ),
            'messages' => array(
                'extensionPaths' => array(
                    'main' => 'application.modules.main.language'
                )
            )
        ),
    ),
);
