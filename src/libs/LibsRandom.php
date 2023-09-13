<?php

/**
 * 随机串
 */
class LibsRandom
{
    // 随机 字符串
    protected $chars = '';
    // 密钥 key
    protected $key = 'ctocode!@$=#=%+#com';
    // 是否 md5
    protected $isMd5 = false;


    public function setType($type = '')
    {
        switch ($type) {
            case 'str':
                $this->chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                break;
            case 'int':
                $this->chars = '0123456789';
                break;
            default:
                $this->chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
                break;
        }
        return $this;
    }
    public function setMd5($isBool = true)
    {
        $this->isMd5 = $isBool;
        return $this;
    }
    public function setKey($key = '')
    {
        $this->key = $key;
        return $this;
    }

    /**
     * 生成指定长度的随机字符串
     * @param int $len 长度
     * @param string $type
     * @return string
     */
    public function getRandom($len = 8)
    {
        if (empty($this->chars)) {
            $this->setType('str');
        }
        $chars = str_shuffle($this->chars);
        return substr($chars, 0, $len);

        $n = $this->chars;

        $vstr_a = '';
        $vstr = '';
        for ($i = 0; $i < 25; $i++) {
            $j = mt_rand(0, (strlen($n) - 1));
            $vstr_a .= $n[$j];
        }
        $vstr_b = md5($this->key . $vstr_a);
        $vstr = $vstr_b . '-' . $vstr_a;
        return $vstr;
    }

    // MD5加密截取 默认24位
    public function getMd5Str($str, $len = 24, $start = 5)
    {
        $hash = $this->key;
        return substr(md5($str . $hash), $start, $len);
    }
}
