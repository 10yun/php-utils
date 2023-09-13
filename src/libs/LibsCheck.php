<?php

namespace shiyunUtils\libs;

/**
 * 验证
 */
class LibsCheck
{


    protected static array $preg_rule = [

        // 验证用户名是否以字母开头
        'user_name' => "/^[a-za-z]{1}([a-za-z0-9]|[._]){3,19}$/",
        // 验证密码只能为数字和字母的组合
        'password' => "/^(w){4,20}$/"
    ];
    public static function checkType($type = '', $str = '')
    {
        if (empty(self::$preg_rule[$type])) {
            throw new \Exception(' LibsCheck rule type 不存在');
        }
        // preg_match(self::$preg_rule[$type], $str, $username)
        return preg_match(self::$preg_rule[$type], $str) ? true : false;
    }
}
