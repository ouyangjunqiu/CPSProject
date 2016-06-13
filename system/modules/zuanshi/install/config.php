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
            'zuanshi' => array(
                'class' => 'application\modules\zuanshi\ZuanshiModule'
            )
        ),
        'components' => array(
            'messages' => array(
                'extensionPaths' => array(
                    'zuanshi' => 'application.modules.zuanshi.language'
                )
            )
        ),
    ),
);
