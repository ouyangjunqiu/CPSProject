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
            'bigdata' => array(
                'class' => 'application\modules\bigdata\BigdataModule'
            )
        ),
        'components' => array(
            'messages' => array(
                'extensionPaths' => array(
                    'bigdata' => 'application.modules.bigdata.language'
                )
            )
        ),
    ),
);
