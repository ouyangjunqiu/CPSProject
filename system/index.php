<?php
/**
 * damai@ubuntu:system$ php index.php main:default:index
 * damai@ubuntu:system$ php index.php main:default:index --nick=xx
 */
use cloud\Cloud;

include dirname(dirname(__FILE__))."/library/cloud/bootstrap.php";

Cloud::createApplication( 'cloud\core\cli\Application', $config )->run();
exit;
