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

    /**
     * 产生随机字符串，不长于32位
     * @param int $length
     */
    public static function doNumLetter($length = 32)
    {
        // 密码字符集，可任意添加你需要的字符
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            // $str .= $chars[mt_rand(0, strlen($chars) - 1)];
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
    /**
     * 生成随机字符串 - 不长于32位
     * 生成随机字符串 - 最长为32位字符串
     * @param number $length 长度，默认为32，最长为32字节
     * @return string
     */
    public static function createNoncestr($length = 32, $type = false)
    {
        $str = self::doNumLetter($length);
        if ($type == true) {
            return strtoupper(md5(time() . $str));
        } else {
            return $str;
        }
    }
}
