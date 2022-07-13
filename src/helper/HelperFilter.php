<?php

namespace shiyunUtils\helper;

class HelperFilter
{
    /**
     * @action 过滤富文本的img,a标签和纯文本
     * @author ctocode-zwj
     * @param $content 需要过滤的内容
     * @return array
     */
    public static function filterHtml($content)
    {
        $content = preg_replace("/<p.*?>|<\/p>/is", "", $content);
        $content = preg_replace("/<span.*?>|<\/span>/is", "", $content); // 过滤span标签
        $pregImgRule = "/<[img|IMG].*?src=[\'|\"](.*?(?:[\.jpg|\.jpeg|\.png|\.gif|\.bmp]))[\'|\"].*?[\/]?>/";
        $content = preg_replace($pregImgRule, '#@#ctocode-img-${1}#@#', $content);
        $pregARule = "/<a[^<>]+href *\= *[\"']?([^ '\"]+).*<\/a>/i";
        $content = preg_replace($pregARule, '#@#ctocode-a-${1}#@#', $content);
        $content = explode('#@#', $content);
        $content = array_filter($content);
        $data = array();
        foreach ($content as $v) {
            $resultImg = explode('ctocode-img-', $v);
            $resultA = explode('ctocode-a-', $v);
            if (!empty($resultImg[1])) {
                // img
                $data[] = array(
                    'img' => $resultImg[1]
                );
            } else if (!empty($resultA[1])) {
                // a
                $data[] = array(
                    'a' => $resultA[1]
                );
            } else {
                $appEmotion = "";
                $appEmotion = preg_replace_callback('/@E(.{6}==)/', function ($r) {
                    return base64_decode($r[1]);
                }, strip_tags($v));
                $data[] = array(
                    'text' => $appEmotion
                );
            }
        }
        return $data;
    }
}
