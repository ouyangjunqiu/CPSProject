<?php
return array(
    'param' => array(
        'name' => '核心模块',
        'description' => '直通车模块',
        'author' => 'oShine',
        'version' => '1.0',
		'indexShow' => array(
            'link' => 'main/default/index',
        ),
    ),
    'config' => array(
        'modules' => array(
            'ztc' => array(
                'class' => 'application\modules\ztc\ZtcModule'
            )
        ),
        'components' => array(
            'messages' => array(
                'extensionPaths' => array(
                    'ztc' => 'application.modules.ztc.language'
                )
            )
        ),
    ),
);
