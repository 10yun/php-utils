<?php

namespace shiyunUtils\helper;

class HelperUI
{
    /**
     * 根据内容输出 js
     */
    public static function outputJs($uiContent = '')
    {
        // $url = $this->getConfig ()->url ();
        // $content = "var url={ base:'{$url->base}',css:'{$url->css}',js:'{$url->js}',img:'{$url->img}',current:window.location};";
        ob_end_clean();
        header('Accept-Ranges: bytes');
        $expire = 604800;
        header('Cache-Control: max-age=' . $expire);
        header('Pragma: cache');
        // header('Content-Type: application/javascript;charset=UTF-8');
        header('Content-Type: text/javascript;charset=UTF-8');
        header('Content-Length: ' . strlen($uiContent));
        echo $uiContent;
    }
    public static function outputJsFromPath(string $path)
    {
        $uiContent = '';
        if (!empty($path) && file_exists($path)) {
            $uiContent = file_get_contents($path);
        }
        self::outputCss($uiContent);
    }
    /**
     * 根据内容输出 css
     */
    public static function outputCss($uiContent = '')
    {
        ob_end_clean();
        header('X-Powered-By:ctocode');
        header('Accept-Ranges: bytes');
        $expire = 604800;
        header('Cache-Control: max-age=' . $expire);
        header('Pragma: cache');
        header('Content-Type: text/css;charset=UTF-8');
        header('Content-Length: ' . strlen($uiContent));
        echo $uiContent;
    }
    public static function outputCssFromPath(string $path)
    {
        $uiContent = '';
        if (!empty($path) && file_exists($path)) {
            $uiContent = file_get_contents($path);
        }
        self::outputCss($uiContent);
    }

    /**
     * 根据内容输出 图片
     */
    public static function outputImage(string $uiContent = '', $houzhui)
    {
        $houzui_arr = array(
            'jpg' => 'jpeg',
            'jpeg' => 'jpeg',
            'png' => 'png',
            'gif' => 'gif',
            'ico' => 'ico',
        );
        ob_end_clean();
        header('X-Powered-By:ctocode');
        // $fp = fopen ( $uiContent, 'rb' );
        header('Accept-Ranges: bytes');
        $expire = 604800;
        header('Cache-Control: max-age=' . $expire);
        header('Pragma: cache');
        header('Content-type: image/' . $houzui_arr[strtolower($houzhui)]);
        header('Content-Length: ' . strlen($uiContent));
        // fpassthru ( $fp );
        echo $uiContent;
    }
    /**
     * 根据路径输出 图片
     */
    public static function outputImageFromPath(string $path)
    {
        $uiContent = '';
        if (!empty($path) && file_exists($path)) {
            $uiContent = file_get_contents($path);
        }
        $pathinfoArr = pathinfo($path);
        $pathinfoName = $pathinfoArr['basename'];
        //
        $houzhui = substr(strrchr($pathinfoName, '.'), 1);
        self::outputImage($uiContent, $houzhui);
    }
}
