<?php

namespace shiyunUtils\helper;

class HelperType
{
    /**
     * 判断是否是json字符串
     * 校验json字符串
     * @param string $str 
     * @return bool
     */
    public static function isJson($str = '')
    {
        if (empty($str)) {
            return false;
        }
        try {
            //校验json格式
            json_decode($str, true);
            return JSON_ERROR_NONE === json_last_error();
        } catch (\Exception $e) {
            return false;
        }
    }
    public static function isDate()
    {
    }
    public static function isTime()
    {
    }
    public static function isDateTime()
    {
    }
}
