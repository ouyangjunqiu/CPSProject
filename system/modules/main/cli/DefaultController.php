<?php
namespace application\modules\main\cli;
use cloud\core\cli\Controller;

class DefaultController extends Controller
{
    public function actionIndex(){

    }

    public function actionTest(){
        Test::test();
    }
}