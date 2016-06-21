<?php

use cloud\Cloud;

include dirname(dirname(__FILE__))."/library/cloud/bootstrap.php";

error_reporting( E_ALL | E_STRICT );

header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, Authorization, ISCORS');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS, DELETE');
header('Access-Control-Allow-Origin:*');
if( $_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit();
}

$app = Cloud::createWebApplication();
$app->run();

exit;