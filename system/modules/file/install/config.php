<?php
return array(
    'param' => array(
        'name' => '文件模块',
        'description' => '文件控制核心模块',
        'author' => 'oShine',
        'version' => '1.0',
    ),
    'config' => array(
        'modules' => array(
            'file' => array(
                'class' => 'application\modules\file\FileModule'
            )
        ),
        'components' => array(
            'messages' => array(
                'extensionPaths' => array(
                    'file' => 'application.modules.file.language'
                )
            )
        ),
    ),
);
