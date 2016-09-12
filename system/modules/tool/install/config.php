<?php
return array(
    'param' => array(
        'name' => '工具模块',
        'description' => '工具模块',
        'author' => 'oShine',
        'version' => '1.0',
		'indexShow' => array(
            'link' => '/tool/default/index',
        ),
    ),
    'config' => array(
        'modules' => array(
            'tool' => array(
                'class' => 'application\modules\tool\ToolModule'
            )
        ),
        'components' => array(
            'messages' => array(
                'extensionPaths' => array(
                    'tool' => 'application.modules.tool.language'
                )
            )
        ),
    ),
);
