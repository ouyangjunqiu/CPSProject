<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015-12-16
 * Time: 11:52
 */

namespace application\modules\zuanshi\model;


class AccountRptTotal
{

    public static function fetchByDate($nick,$date){
        $rpt = AccountRpt::model()->fetch("log_date=? AND nick=?",array($date,$nick));
        $rpt2 = AccountRpt2::model()->fetch("log_date=? AND nick=?",array($date,$nick));
        $result = array();
        $result["charge"] = @($rpt["charge"]+$rpt2["charge"]);
        $result["roi"] = ($rpt["charge"]*$rpt["roi"]+$rpt2["charge"]*$rpt2["roi"])/ $result["charge"] ;
        return $result;

    }

}