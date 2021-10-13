<?php

namespace shiyunUtils\helper;

/**
 * 字符串
 */
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
    /**
     * 清除html
     */
    public static function trimHtmlcodeAll($str = '')
    {
        // 用于替换
        $replace_arr1 = array(
            "'<script[^>]*?>.*?<!-- </script> -->'si" => "", // 去掉 javascript
            "'<script[^>]*?>.*?</script>'si" => "", // 去掉 javascript
            "'javascript[^>]*?>.*?'si" => "", // 去掉 javascript
            "'<style[^>]*?>.*?</style>'si" => "", // 去掉 css
            "'<[/!]*?[^<>]*?>'si" => "", // 去掉 HTML 标记
            "'<[\/\!]*?[^<>]*?>'si" => "", // 去掉 HTML 标记
            "'<!--[/!]*?[^<>]*?>'si" => "", // 去掉 注释标记
            "'([rn])[s]+'" => "", // 去掉空白字符
            "'([\r\n])[\s]+'" => "", // 去掉空白字符

            // "\1",
            // "\\1",
            // 替换 HTML 实体
            "'&(quot|#34);'i" => "\"",
            "'&(amp|#38);'i" => "&",
            "'&(lt|#60);'i" => "<",
            "'&(gt|#62);'i" => ">",
            "'&(nbsp|#160);'i" => " ",
            "'&(iexcl|#161);'i" => chr(161),
            "'&(cent|#162);'i" => chr(162),
            "'&(pound|#163);'i" => chr(163),
            "'&(copy|#169);'i" => chr(169),
            "'&#(d+);'e" => "chr(\1)",
            "'&#(\d+);'e" => "chr(\\1)",


        );

        $out = preg_replace(array_keys($replace_arr1), array_values($replace_arr1), $str);

        $replace_arr2 = [
            "<" => "",
            ">" => "",
            "alert" => "",
            "java" => "",
            "script" => "",
            "(" => "",
            ")" => "",
        ];
        $out = str_replace(array_keys($replace_arr2), array_values($replace_arr2), $out);
        return $out;
    }



    /**
     * 字符串符号转html
     * 字符串,替换
     * 符号 - html转义符
     * @param string $str
     * @return mixed
     */
    public static function symbolToHtmlcode($str = '')
    {
        $replace_arr = array(
            '&' => '&amp;',
            '"' => '&quot;',
            "'" => '&#039;',
            '<' => '&lt;',
            '>' => '&gt;'
        );
        $result = str_replace(array_keys($replace_arr), array_values($replace_arr), $str);
        return $result;
    }

    // htmlcode 转 字符串符号
    // html转义符 - 符号
    public static function htmlcodeToSymbol($str = '')
    {
        $replace_arr = array(
            '&nbsp;' => ' ',
            '&amp;' => '&',
            '&quot;' => '"',
            '&#039;' => "'",
            '&ldquo;' => '“',
            '&rdquo;' => '”',
            '&mdash;' => '—',
            '&lt;' => '<',
            '&gt;' => '>',
            '&middot;' => '·',
            '&hellip;' => '…'
        );
        $result = str_replace(array_keys($replace_arr), array_values($replace_arr), $str);
        return $result;
    }
}
