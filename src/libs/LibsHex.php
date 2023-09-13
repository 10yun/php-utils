<?php

namespace shiyunUtils\libs;

class LibsHex
{
    /**
     *字符串转十六进制函数
     *@pream string $str='abc';
     */
    public function strToHex($str)
    {
        $hex = "";
        for ($i = 0; $i < strlen($str); $i++)
            $hex .= dechex(ord($str[$i]));
        $hex = strtoupper($hex);
        return $hex;
    }
    public static function strTo16($str = '')
    {
        if (empty($str)) {
            return '';
        }
        $send_str = $str;
        $send_str = trim($send_str);
        // 将16进制数据转换成两个一组的数组
        $send_str_arr = str_split(str_replace(' ', '', $send_str), 2);
        $send_str_len = count($send_str_arr);
        $send_str_16 = '';
        for ($i = 0; $i < $send_str_len; $i++) {
            if (isset($send_str_arr[$i])) {
                $send_str_16 .= chr(hexdec($send_str_arr[$i])); // 逐组数据发送
            }
        }
        return $send_str_16;
    }
    /**
     * 十六进制转字符串函数
     * @pream string $hex='616263';
     */
    public function hexToStr($hex = '')
    {
        $str = "";
        for ($i = 0; $i < strlen($hex) - 1; $i += 2) {
            $str .= chr(hexdec($hex[$i] . $hex[$i + 1]));
        }
        return $str;
    }
    /**
     *  2进制 转 字符串
     */
    function binToStr($bin_str)
    {
        $text_str = '';
        $chars = explode("\n", chunk_split(str_replace("\n", '', $bin_str), 8));
        $_I = count($chars);
        for ($i = 0; $i < $_I; $text_str .= chr(bindec($chars[$i])), $i);
        return $text_str;
    }
    /**
     * 字符串 转 2进制
     */
    function strToBin($txt_str)
    {
        $len = strlen($txt_str);
        $bin = '';
        for ($i = 0; $i < $len; $i) {
            $bin .= strlen(decbin(ord($txt_str[$i]))) < 8 ? str_pad(decbin(ord($txt_str[$i])), 8, 0, STR_PAD_LEFT) : decbin(ord($txt_str[$i]));
        }
        return $bin;
    }
}
