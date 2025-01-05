<?php

namespace shiyunUtils\helper;

/**
 * 日期处理
 */
class HelperDate
{
    /**
     * 获取指定日期段内每一天的日期
     * @param  String|Date  $startDate 开始日期
     * @param  String|Date  $endDate   结束日期
     * @return Array
     */
    public static function getDateFromRange($startDate = '', $endDate = '')
    {
        $stimestamp = strtotime($startDate);
        $etimestamp = strtotime($endDate);
        // 计算日期段内有多少天
        $days = ($etimestamp - $stimestamp) / 86400 + 1;
        // 保存每天日期
        $date = array();
        for ($i = 0; $i < $days; $i++) {
            $date[] = date('Y-m-d', $stimestamp + (86400 * $i));
        }
        return $date;
    }
    /**
     * 获取日期，获取本月所有天数
     */
    public static function getDateArr1($curr_date)
    {
        // 日期配置
        $weekname = array('星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六',);
        //星期日排到末位
        if (empty($week)) {
            $week = 7;
        }
        // 总天数
        $day_num = date("t", strtotime($curr_date));
        $head_arr = [];
        for ($i = 1; $i <= $day_num; $i++) {
            $for_date = Date("Y-m-{$i}", strtotime($curr_date));
            $xingqi = Date("w", strtotime($for_date));
            $head_arr['day'][] = $i . "日";
            $head_arr['week'][] = $weekname[$xingqi];
        }
        return $head_arr;
    }
    /**
     * 获取日期区间
     */
    public static function getDateArr2($date_arr)
    {
        // 日期配置
        $weekname = array('星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六',);
        //星期日排到末位
        if (empty($week)) {
            $week = 7;
        }
        $head_arr = [];
        foreach ($date_arr as $val) {
            // 
            $day_str = date("d", strtotime($val));
            $month_day_str = date("m-d", strtotime($val));
            $month_day_str2 = date("m月d日", strtotime($val));
            $xingqi = Date("w", strtotime($val));
            $head_arr['day'][] = $day_str . "日";
            $head_arr['month_day'][] = $month_day_str;
            $head_arr['month_day2'][] = $month_day_str2;
            $head_arr['week'][] = $weekname[$xingqi];
        }
        return $head_arr;
    }
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
