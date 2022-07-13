<?php

namespace shiyunUtils\libs;

class LibEncryptNum
{
    /**
     * 字符串加密
     */
    public static function numberEncode($_str = '')
    {
        function random($min = 0, $max = 1)
        {
            return $min + mt_rand() / mt_getrandmax() * ($max - $min);
        }
        $staticchars = "PXhw7UT1B0a9kQDKZsjIASmOezxYG4CHo5Jyfg2b8FLpEvRr3WtVnlqMidu6cN";
        $encodechars = "";
        for ($i = 0; $i < strlen($_str); $i++) {
            $num0 = strpos($staticchars, $_str[$i]);
            if ($num0 == false) {
                $code = $_str[$i];
            } else {
                $code = $staticchars[($num0 + 3) % 62];
            }
            $num1 = intval(random() * 62, 10);
            $num2 = intval(random() * 62, 10);
            $encodechars .= $staticchars[$num1] . $code . $staticchars[$num2];
        }
        return $encodechars;
    }
    /**
     * 字符串解密
     */
    public static function numberDecode($_str = '')
    {
        $staticchars = "PXhw7UT1B0a9kQDKZsjIASmOezxYG4CHo5Jyfg2b8FLpEvRr3WtVnlqMidu6cN";
        $decodechars = "";
        for ($i = 1; $i < strlen($_str);) {
            $num0 = strpos($staticchars, $_str[$i]);
            if ($num0 !== false) {
                $num1 = ($num0 + 59) % 62;
                $code = $staticchars[$num1];
            } else {
                $code = $_str[$i];
            }
            $decodechars .= $code;
            $i += 3;
        }
        return $decodechars;
    }
}
