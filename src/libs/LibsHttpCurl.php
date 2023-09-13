<?php

namespace shiyunUtils\libs;

use Exception;

class LibsHttpCurl
{
    use \shiyunUtils\base\TraitModeInstance;

    protected $chHandle = null;
    protected $chCookie = '';
    protected $chTimeout = 20;

    // 私有化构造函数，防止直接创建实例
    private function __construct()
    {
        $this->initHandle();
        $this->setTimeout();
    }
    /**
     * 启动一个CURL会话
     */
    public function initHandle()
    {
        if (empty($this->chHandle)) {
            $this->chHandle = curl_init();
        }
        return $this;
    }
    /**
     * 设置 Cookie信息
     * 读取储存的Cookie信息
     */
    public function setCookie($str = '')
    {
        $this->chCookie = $str;
        curl_setopt($this->chHandle, CURLOPT_COOKIE, $str);
        return $this;
    }
    /**
     * 设置超时限制防止死循环
     */
    public function setTimeout($time = 20)
    {
        $this->chTimeout = $time;
        curl_setopt($this->chHandle, CURLOPT_TIMEOUT, $this->chTimeout);
        return $this;
    }
    /**
     * 模拟用户使用的浏览器
     */
    public function setUserAgent()
    {
        $useragent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:23.0) Gecko/20100101 Firefox/23.0';
        curl_setopt($this->chHandle, CURLOPT_USERAGENT, $useragent);
        return $this;
    }
    /**
     * 设置HTTP头字段的数组
     */
    public function setHeader($header = [])
    {
        // 模拟获取内容函数
        $header = array(
            // 'Accept: */*',
            // 'Connection: keep-alive',
            // 'Host: mp.weixin.qq.com',
            // 'Referer: ' . $this->referer,
            // 'X-Requested-With: XMLHttpRequest',
            // 'Accept-Charset: GBK,utf-8;q=0.7,*;q=0.3',
            // 'Accept-Encoding: gzip,deflate,sdch',
            // 'Accept-Language: zh-CN,zh;q=0.8',
            // 'Host:' . $this->host,
            // 'Origin:' . $this->origin,
            // 'Referer:' . $this->referer,
        );
        curl_setopt($this->chHandle, CURLOPT_HTTPHEADER, $header);
    }

    /**
     * GET 请求
     * @param string $url
     * @return mixed
     */
    public function get($url)
    {
        curl_setopt($this->chHandle, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($this->chHandle, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($this->chHandle, CURLOPT_FAILONERROR, false);
        curl_setopt($this->chHandle, CURLOPT_RETURNTRANSFER, true); // 获取的信息以文件流的形式返回
        curl_setopt($this->chHandle, CURLOPT_HEADER, false);

        // curl_setopt($this->chHandle, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        // curl_setopt($this->chHandle, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        // curl_setopt($this->chHandle, CURLOPT_HTTPGET, 1); // 发送一个常规的GET请求
        // curl_setopt($this->chHandle, CURLOPT_HEADER, $this->getHeader); // 显示返回的Header区域内容

        if (str_contains('$' . $url, 'https://')) {
            curl_setopt($this->chHandle, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
            // curl_setopt($this->chHandle, CURLOPT_SSL_VERIFYHOST, true); // 从证书中检查SSL加密算法是否存在
            // curl_setopt($this->chHandle, CURLOPT_SSLVERSION, true); // CURL_SSLVERSION_TLSv1
        }
        /**
         * 执行请求并获取响应
         */
        $curlResponse = curl_exec($this->chHandle);
        $curlInfo = curl_getinfo($this->chHandle);
        if ($curlResponse === false || $curlInfo['http_code'] != 200) {
            $curlError = curl_error($this->chHandle);
            throw new Exception($curlError);
        }
        curl_close($this->chHandle);
        if (is_string($curlResponse) && $this->isJson($curlResponse)) {
            return json_decode($curlResponse, true);
        }
        return $curlResponse;
    }

    /**
     * post请求
     * @param string $url
     * @param array $params
     * @return mixed|array|string $json
     */
    public function post($url, $params = [])
    {
        // $chObj = curl_init(); // 启动一个curl会话

        $this->chHandle = curl_init();
        curl_setopt($this->chHandle, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($this->chHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->chHandle, CURLOPT_HEADER, false);
        if (str_contains('$' . $url, 'https://')) {
            curl_setopt($this->chHandle, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
            curl_setopt($this->chHandle, CURLOPT_SSL_VERIFYHOST, true); // 从证书中检查SSL加密算法是否存在
        }
        curl_setopt($this->chHandle, CURLOPT_POST, true); // 发送一个常规的Post请求
        curl_setopt($this->chHandle, CURLOPT_POSTFIELDS, $params); // Post提交的数据包

        // curl_setopt($this->chHandle, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        // curl_setopt($this->chHandle, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        // curl_setopt($this->chHandle, CURLOPT_HEADER, $this->getHeader); // 显示返回的Header区域内容
        // curl_setopt($this->chHandle, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        // curl_setopt($this->chHandle, CURLOPT_HTTPHEADER, array(
        //     'Content-Type: application/json; charset=utf-8',
        //     'Content-Length: ' . strlen($sendData)
        // ));
        /**
         * 执行请求并获取响应
         */
        $curlResponse = curl_exec($this->chHandle);
        $curlInfo = curl_getinfo($this->chHandle);
        if ($curlResponse === false || $curlInfo['http_code'] != 200) {
            $curlError = curl_error($this->chHandle);
            throw new Exception($curlError);
        }
        curl_close($this->chHandle);
        if (is_string($curlResponse) && $this->isJson($curlResponse)) {
            return json_decode($curlResponse, true);
        }
        return $curlResponse;
    }
    private function isJson($string)
    {
        json_decode($string, true);
        return json_last_error() === JSON_ERROR_NONE;
    }
}
