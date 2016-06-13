<?php
return array(
    'param' => array(
        'name' => '达摩盘模块',
        'description' => '系统核心模块',
        'author' => 'oShine',
        'version' => '1.0',
		'indexShow' => array(
            'link' => 'main/default/index',
        ),
    ),
    'config' => array(
        'modules' => array(
            'dmp' => array(
                'class' => 'application\modules\dmp\DmpModule'
            )
        ),
        'components' => array(
            'messages' => array(
                'extensionPaths' => array(
                    'dmp' => 'application.modules.dmp.language'
                )
            )
        ),
    ),
);
