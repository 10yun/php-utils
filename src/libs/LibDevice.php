<?php


class LibDevice
{
    function IsWeixinOrAlipay()
    {
        //判断是不是微信
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            return "WeiXIN";
        }
        //判断是不是支付宝
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'AlipayClient') !== false) {
            return "Alipay:true";
        }
        //哪个都不是
        return "false";
    }
}
