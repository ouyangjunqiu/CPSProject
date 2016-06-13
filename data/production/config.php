<?php
return array(
    // ----------------------------  CONFIG ENV  -----------------------------//
    'env' => array(
        'language' => 'zh_cn',
        'theme' => 'default'
    ),
    // ----------------------------  CONFIG DB  ----------------------------- //
    'databases'=>array(

        'db' => array(
            'host' => '10.241.48.213',
            'port' => '3306',
            'dbname' => 'dmcark_cps',
            'username' => 'cps.da-mai.com',
            'password' => 'cps@da-mai.com',
            'tableprefix' => 'cps_',
            'charset' => 'utf8'
        ),

    ),

    'components' => array(
        // URL资源管理器
        'urlManager' => array(
            'urlFormat' => 'path',
            'urlSuffix' => '.html',
            'caseSensitive' => false,
            'showScriptName' => false,
            'rules' => array(
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>', // Not Coding Standard
            )
        ),
    )

);
