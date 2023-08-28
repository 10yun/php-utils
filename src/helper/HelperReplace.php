<?php

namespace shiyunUtils\helper;

class HelperReplace
{
    /**
     * 去除逗号
     */
    public static  function replaceComma(string $str = ''): string
    {
        $str = preg_replace('/,{2,}/', ',', $str);
        $str = preg_replace('/,$/', '', $str);
        return $str;
    }
}
