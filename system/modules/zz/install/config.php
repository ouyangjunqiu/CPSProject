<?php
return array(
    'param' => array(
        'name' => '智钻2.0',
        'description' => '系统核心模块',
        'author' => 'oShine',
        'version' => '2.0',
		'indexShow' => array(
            'link' => 'zz/default/index',
        ),
    ),
    'config' => array(
        'modules' => array(
            'zz' => array(
                'class' => 'application\modules\zz\ZzModule'
            )
        ),
        'components' => array(
            'messages' => array(
                'extensionPaths' => array(
                    'zz' => 'application.modules.zz.language'
                )
            )
        ),
    ),
);
