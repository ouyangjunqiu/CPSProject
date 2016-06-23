<?php
/**
 * @file PluginController.php
 * @author ouyangjunqiu
 * @version Created by 16/5/6 11:33
 */

namespace application\modules\main\controllers;


use cloud\core\controllers\Controller;
use cloud\core\utils\File;

class PluginController extends Controller
{

    public function actionDownload(){
        $path = PATH_ROOT.'/CPSTools/target';
        $filename = "CPSTools3.1.0.crx";

        File::downloadCrxFile($path."/".$filename,$filename);
    }

}