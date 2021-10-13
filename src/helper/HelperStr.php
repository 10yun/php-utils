<?php

namespace shiyunUtils\helper;

class HelperStr
{
    // 去除连续空格
    public static function trimSpaceLx($str = '')
    {
        // 去除连续空格
        $str = str_replace("　", ' ', stripslashes($str));
        $str = preg_replace("/[\r\n\t ]{1,}/", ' ', $str);
        return $str;
    }
    // 去除所有空格
    public static function trimSpaceAll($str = '')
    {
        $str = str_replace("　", ' ', stripslashes($str));
        $str = preg_replace("/[\r\n\t ]/", '', $str);
        return $str;
    }
    /**
     * 清除 空格、换行
     * 清除空格--等一些字符,留下纯文本
     */
    public static function trimSpaceEnter($str = '')
    {
        $replace_arr = array(
            " " => "",
            "　" => "",
            "\t" => "",
            "\n" => "",
            "\r" => ""
        );
        $result = str_replace(array_keys($replace_arr), array_values($replace_arr), $str);
        return $result;
    }
}
