<?php

namespace shiyunUtils\helper;

/**
 * 随机码
 */
class HelperRandom
{
    /**
     * 生成随机码【 数字】 
     * @param string $length 长度，默认4
     */
    public static function doNumBase($length = 4)
    {
        $num = "";
        for ($i = 0; $i < $length; $i++) {
            $id = rand(0, 9);
            $num = $num . $id;
        }
        return $num;
    }

    /**
     * 生成随机码【 大小写字母】 
     * @param string $length 长度，默认4
     */
    public static function doLetterBase($length = 4)
    {
        $random_code = "";
        $strChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $max = strlen($strChars) - 1;
        mt_srand((float) microtime() * 1000000);
        for ($i = 0; $i < $length; $i++) {
            $random_code .= $strChars[mt_rand(0, $max)];
        }
        return $random_code;
    }
    /**
     * 生成随机码【 大小写字母 + md5 】 
     * @param string $length 长度，默认4
     */
    public static function doLetterMd5($length = 4)
    {
        $str = self::doLetterBase($length);
        return md5($str);
    }
}
