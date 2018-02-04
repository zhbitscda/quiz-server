<?php
/**
 * Created by PhpStorm.
 * User: shanks
 * Date: 16/8/9
 * Time: 下午10:02
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Charge extends Model {
    private $payRule = array();
    private $enterTime = "";
    private $leaveTime = "";
    private $parkMinutes = 0;

    // 入口函数, 传入收费配置id, 入场时间和出场时间,返回收费记录
    public function handleChargeRequest($payConfigId, $enterTime, $leaveTime) {

        // 得到数据库配置信息,得到收费类型和收费配置
        $payRule = array();

        // 计算分钟数



    }

    // 1、常规收费标准（24H）
//{
//dailyMaxPayAmount: 100,
//timeMaxPayAmount: 100,
//freeParkMinutes: 30,
//calcFreeParkMinutesForPayOption: 0,
//hour1PayAmount: 1,
//hour2PayAmount: 1,
//hour3PayAmount: 1,
//hour4PayAmount: 1,
//hour5PayAmount: 1,
//hour6PayAmount: 1,
//hour7PayAmount: 1,
//...
//hour24PayAmount: 1
//}
    private function commonStandardCharge() {

        $dailyMaxPayAmount = $this->payRule["dailyMaxPayAmount"];
        $timeMaxPayAmount = $this->payRule["timeMaxPayAmount"];
        $freeParkMinutes = $this->payRule["freeParkMinutes"];
        $calcFreeParkMinutesForPayOption = $this->payRule["calcFreeParkMinutesForPayOption"];
        $hourPayAmountList = array();

        $daySumPayAmount = 0;
        for($i = 0; $i < 24; $i++) {
            $hourPayAmountList[] = $this->payRule["hour" . $i . "PayAmount"];
            $daySumPayAmount += $this->payRule["hour" . $i . "PayAmount"];
        }

        if($daySumPayAmount > $dailyMaxPayAmount) {
            $dailyMaxPayAmount = $daySumPayAmount;
        }
        if($this->parkMinutes <= $freeParkMinutes) {
            return 0; //半小时免费
        }
        if($calcFreeParkMinutesForPayOption == 0) { // 免费分钟不参与计算
            $this->parkMinutes = $this->parkMinutes - $freeParkMinutes;
        }

        $hour = 1;
        $payAmount = 0;

        $dayCount = $this->parkMinutes % 24 * 60;

        $payAmount = $dayCount * $dailyMaxPayAmount; //超过一天

        $remaingHours = 0;
        do {
            $payAmount += $hourPayAmountList[$hour % 24];
        } while($hour * 60 >= $this->parkMinutes);



    }

}
