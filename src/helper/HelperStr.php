<?php

namespace shiyunUtils\helper;

/**
 * 字符串
 */
class HelperStr
{
    protected static $snakeCache = [];
    protected static $camelCache = [];
    protected static $studlyCache = [];



    /**
     * 检查字符串是否以某些字符串开头
     *
     * @param  string       $haystack 
     * @param  string|array $needles
     * @return bool
     */
    public static function startsWith(string $haystack, $needles): bool
    {
        foreach ((array) $needles as $needle) {
            if ('' != $needle && mb_strpos($haystack, $needle) === 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * 获取指定长度的随机字母数字组合的字符串
     *
     * @param  int $length
     * @param  int $type
     * @param  string $addChars
     * @return string
     */
    public static function random(int $length = 6, int $type = null, string $addChars = ''): string
    {
        $str = '';
        switch ($type) {
            case 0:
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' . $addChars;
                break;
            case 1:
                $chars = str_repeat('0123456789', 3);
                break;
            case 2:
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' . $addChars;
                break;
            case 3:
                $chars = 'abcdefghijklmnopqrstuvwxyz' . $addChars;
                break;
            case 4:
                $chars = "们以我到他会作时要动国产的一是工就年阶义发成部民可出能方进在了不和有大这主中人上为来分生对于学下级地个用同行面说种过命度革而多子后自社加小机也经力线本电高量长党得实家定深法表着水理化争现所二起政三好十战无农使性前等反体合斗路图把结第里正新开论之物从当两些还天资事队批点育重其思与间内去因件日利相由压员气业代全组数果期导平各基或月毛然如应形想制心样干都向变关问比展那它最及外没看治提五解系林者米群头意只明四道马认次文通但条较克又公孔领军流入接席位情运器并飞原油放立题质指建区验活众很教决特此常石强极土少已根共直团统式转别造切九你取西持总料连任志观调七么山程百报更见必真保热委手改管处己将修支识病象几先老光专什六型具示复安带每东增则完风回南广劳轮科北打积车计给节做务被整联步类集号列温装即毫知轴研单色坚据速防史拉世设达尔场织历花受求传口断况采精金界品判参层止边清至万确究书" . $addChars;
                break;
            default:
                $chars = 'ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789' . $addChars;
                break;
        }
        if ($length > 10) {
            $chars = $type == 1 ? str_repeat($chars, $length) : str_repeat($chars, 5);
        }
        if ($type != 4) {
            $chars = str_shuffle($chars);
            $str = substr($chars, 0, $length);
        } else {
            for ($i = 0; $i < $length; $i++) {
                $str .= mb_substr($chars, floor(mt_rand(0, mb_strlen($chars, 'utf-8') - 1)), 1);
            }
        }
        return $str;
    }

    /**
     * 字符串转小写
     *
     * @param  string $value
     * @return string
     */
    public static function lower(string $value): string
    {
        return mb_strtolower($value, 'UTF-8');
    }

    /**
     * 字符串转大写
     *
     * @param  string $value
     * @return string
     */
    public static function upper(string $value): string
    {
        return mb_strtoupper($value, 'UTF-8');
    }

    /**
     * 获取字符串的长度
     *
     * @param  string $value
     * @return int
     */
    public static function length(string $value): int
    {
        return mb_strlen($value);
    }

    /**
     * 截取字符串
     *
     * @param  string   $string
     * @param  int      $start
     * @param  int|null $length
     * @return string
     */
    public static function substr(string $string, int $start, int $length = null): string
    {
        return mb_substr($string, $start, $length, 'UTF-8');
    }

    /**
     * 驼峰转下划线
     *
     * @param  string $value
     * @param  string $delimiter
     * @return string
     */
    public static function snake(string $value, string $delimiter = '_'): string
    {
        $key = $value;

        if (isset(static::$snakeCache[$key][$delimiter])) {
            return static::$snakeCache[$key][$delimiter];
        }

        if (!ctype_lower($value)) {
            $value = preg_replace('/\s+/u', '', ucwords($value));

            $value = static::lower(preg_replace('/(.)(?=[A-Z])/u', '$1' . $delimiter, $value));
        }

        return static::$snakeCache[$key][$delimiter] = $value;
    }

    /**
     * 下划线转驼峰(首字母小写)
     *
     * @param  string $value
     * @return string
     */
    public static function camel(string $value): string
    {
        if (isset(static::$camelCache[$value])) {
            return static::$camelCache[$value];
        }

        return static::$camelCache[$value] = lcfirst(static::studly($value));
    }

    /**
     * 下划线转驼峰(首字母大写)
     *
     * @param  string $value
     * @return string
     */
    public static function studly(string $value): string
    {
        $key = $value;

        if (isset(static::$studlyCache[$key])) {
            return static::$studlyCache[$key];
        }

        $value = ucwords(str_replace(['-', '_'], ' ', $value));

        return static::$studlyCache[$key] = str_replace(' ', '', $value);
    }

    /**
     * 转为首字母大写的标题格式
     *
     * @param  string $value
     * @return string
     */
    public static function title(string $value): string
    {
        return mb_convert_case($value, MB_CASE_TITLE, 'UTF-8');
    }









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
