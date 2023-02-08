<?php

namespace shiyunUtils\helper;

/**
 * 日期处理
 */
class HelperDate
{
    /**
     * 时间转时长
     * 时间换算时长
     */
    public static function dateToDuration($date1, $date2 = null, $type = 'year')
    {
        if (empty($date2)) {
            $date2 = date('Y-m-d', time());
        }
        $d1 = explode('-', $date1);
        $d2 = explode('-', $date2);
        if (strtotime($date1) - strtotime($date2) > 0) {
            $monthsFromYear   = abs($d1[0] - $d2[0]) * 12;
            $monthsFromMonth  = $d1[1] - $d2[1];
        } else {
            $monthsFromYear   = abs($d2[0] - $d1[0]) * 12;
            $monthsFromMonth  = $d2[1] - $d1[1];
        }

        $monthsLast = $monthsFromYear + $monthsFromMonth;
        $resStr = '';
        switch ($type) {
            case 'month':
                $resStr = $monthsLast;
                break;
            case 'year':
            default:
                $resStr = $monthsLast / 12;
                $resStr = number_format($resStr, 1);
                break;
        }
        return $resStr;
    }
    // 生日转年龄
    public static function birthdayToAge($birthday = null)
    {
        $age = strtotime($birthday);
        if ($age === false) {
            return false;
        }
        list($y1, $m1, $d1) = explode("-", date("Y-m-d", $age));
        $now = strtotime("now");
        list($y2, $m2, $d2) = explode("-", date("Y-m-d", $now));
        $age = $y2 - $y1;
        if ((int)($m2 . $d2) < (int)($m1 . $d1))
            $age -= 1;
        return $age;

        // list($year, $month, $day) = explode("-", $birthday);
        // $year_diff = date("Y") - $year;
        // $month_diff = date("m") - $month;
        // $day_diff  = date("d") - $day;
        // if ($day_diff < 0 || $month_diff < 0)
        //     $year_diff--;
        // return $year_diff;
    }
}
