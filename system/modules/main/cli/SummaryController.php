<?php

namespace application\modules\main\cli;

use cloud\core\cli\Controller;
use application\modules\main\model\Summary;
use application\modules\main\model\SummaryDetailForZtc;
use application\modules\main\model\SummaryDetailForZuanshi;

class SummaryController extends Controller
{
    public function actionIndex(){
        Summary::cal();
    }

    public function actionDetail(){
        SummaryDetailForZtc::cal();
        SummaryDetailForZuanshi::cal();
    }

}