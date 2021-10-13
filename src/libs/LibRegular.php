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

    public static function html_a_link($url)
    {
        preg_match_all("/<a(s*[^>]+s*)href=([\"|']?)([^\"'>\s]+)([\"|']?)/ies", $html, $out);
        $arrLink = $out[3];
        $arrUrl = parse_url($url);
        $dir = '';
        if (isset($arrUrl['path']) && !empty($arrUrl['path'])) {
            $dir = str_replace("\\", "/", $dir = dirname($arrUrl['path']));
            if ($dir == "/") {
                $dir = "";
            }
        }
        if (is_array($arrLink) && count($arrLink) > 0) {
            // $arrLink=array_unique($arrLink); //函数移除数组中的重复的值，并返回结果数组。
            foreach ($arrLink as $key => $val) {
                $val = strtolower($val);
                if (preg_match('/nofollow/', $val)) {
                    unset($arrLink[$key]);
                } elseif (preg_match('/^#*$/isU', $val)) { // 过滤特殊字符的链接
                    unset($arrLink[$key]);
                } elseif (!preg_match('/html/', $val)) { // 过滤.html除外的链接
                    unset($arrLink[$key]);
                } elseif (preg_match('/^\//isU', $val)) {
                    $arrLink[$key] = 'http://' . $arrUrl['host'] . $val;
                } elseif (preg_match('/^javascript/isU', $val)) {
                    unset($arrLink[$key]);
                } elseif (preg_match('/^mailto:/isU', $val)) { // 过滤邮件链接
                    unset($arrLink[$key]);
                } elseif (!preg_match('/^\//isU', $val) && strpos($val, 'http://') === FALSE) {

                    $arrLink[$key] = 'http://' . $arrUrl['host'] . $dir . '/' . $val;
                }
            }
        }
        sort($arrLink);
        return $arrLink;
    }

    function html_a_link1($document)
    {
        preg_match_all("'<\s*a\s.*?href\s*=\s*([\"\'])?(?(1)(.*?)\\1|([^\s\>]+))[^>]*>?(.*?)</a>'isx", $document, $links);

        while (list($key, $val) = each($links[2])) {
            if (!empty($val))
                $match['link'][] = $val;
        }
        while (list($key, $val) = each($links[3])) {
            if (!empty($val))
                $match['link'][] = $val;
        }
        while (list($key, $val) = each($links[4])) {
            if (!empty($val))
                $match['content'][] = $val;
        }
        while (list($key, $val) = each($links[0])) {
            if (!empty($val))
                $match['all'][] = $val;
        }
        return $match;
    }


    // 常见正则处理
    function ctoRegularHtml($type = '', $content)
    {
        if (empty($type) || empty($content)) {
            return '';
        }
        $type = strtoupper($type);
        $reg = '';

        $arr = [
            'html_head_title_text' => '|<title>(.*?)<\/title>|i',
            'html_h1_text' => '/<h1[\s\S]*?>([\s\S]*?)/<\/h1>/i',
            'html_div_html' => '/<div\s+[^>]*>[^<>]*<\/div>(?:\s*<a\s+[^<>]*>[^<>]*<\/a>)*/',
            'html_li_html' => '/<li>(.*?)<\/li>*/',
            'script_src' => '/<script +.*src="([^"]+)"/i',
            // link 的href
            'link_href' => '/<link.+?href=(\'|")(.+?)\\1/s',
            'link_href1' => '/<link +.*href="([^"]+)"/i'
        ];

        switch ($type) {
            case 'a_href':
            case 'a_html':
                $reg = '|<a href="(.*?)">(.*?)</a>|';
                break;
            case 'a_href_html': // a 的 herf,html ===后续可根据需求添加 class
                $reg = '/<a.*?(?: |\\t|\\r|\\n)?href=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>(.+?)<\/a.*?>/sim';
                preg_match_all($reg, $content, $matches, PREG_PATTERN_ORDER);
                return $matches;
            case 'img_src': // img 的 src 链接
                $reg = '/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim';
                preg_match_all($reg, $content, $matches, PREG_PATTERN_ORDER);
                return $matches;
                break;
            default:
                return '';
        }
        // preg_match 函数用于进行正则表达式匹配，成功返回 1 ，否则返回 0 。
        // 第一次匹配成功后就会停止匹配，如果要实现全部结果的匹配，即搜索到subject结尾处，则需使用 preg_match_all()
        // preg_match ( $reg, $content, $matches );
        preg_match_all($reg, $content, $matches);
        return $matches;

        $reg = '/^(#|javascript.*?|ftp://.+|http://.+|.*?href.*?|play.*?|index.*?|.*?asp)+$/i';
        //
        $reg = '/^(down.*?.html|d+_d+.htm.*?)$/i';
        $rex = "/([hH][rR][eE][Ff])s*=s*['\"]*([^>'\"s]+)[\"'>]*s*/i";
        $reg = '/^(down.*?.html)$/i';
    }
}
