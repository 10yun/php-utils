<?php

/**
 * 去除逗号
 */
function _cc_replace_comma($str = '')
{
    $str = preg_replace('/,{2,}/', ',', $str);
    $str = preg_replace('/,$/', '', $str);
    return $str;
}
