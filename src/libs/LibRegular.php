<?php

namespace shiyunUtils\libs;

class LibRegular
{
    // 判断含有中文
    public static function isChStr($str = '')
    {
        $pattern = '/[^\x00-\x80]/';
        $pattern = '/[\x7f-\xff]/';
        if (preg_match($pattern, $str)) {
            return true;
        } else {
            return false;
        }
        // $array = array( 'Name' => '希亚', 'Age' => 20 );
        // echo JSON ( $array );
        // $str="'324是";
        // if(!eregi("[^\x80-\xff]","$str")){
        // echo "全是中文";
        // }else{
        // echo "不是";
        // }

    }
}
