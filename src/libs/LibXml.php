<?php

namespace shiyunUtils\libs;

class LibXml
{

    /**
     * 	作用：将xml转为array
     */
    public static function xmlToArr($xml = '')
    {
        // 先把xml转换为simplexml对象，再把simplexml对象转换成 json，再将 json 转换成数组。

        $simple_xml = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $array_data = json_decode(json_encode($simple_xml), true);
        // $array_data = json_decode(json_encode($simple_xml), true);

        return $array_data;
    }
    /**
     * 	作用：array转xml
     * 将数组解析XML
     */
    public static function arrToXml($arr = null)
    {
        // if (is_null($arr)) {
        //     $arr = $this->parameters;
        // }
        // if (!is_array($arr) || empty($arr)) {
        //     die("参数不为数组无法解析");
        // }

        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }

    // 遍历数组方法
    public static function arrToXml2($data)
    {
        $str = '<xml>';
        foreach ($data as $k => $v) {
            $str .= '<' . $k . '>' . $v . '</' . $k . '>';
        }
        $str .= '</xml>';
        return $str;
    }

    public static function xmlSafeStr($str)
    {
        return '<![CDATA[' . preg_replace("/[\\x00-\\x08\\x0b-\\x0c\\x0e-\\x1f]/", '', $str) . ']]>';
    }

    /**
     * 数据XML编码
     * @param mixed $data 数据
     * @return string
     */
    public static function data_to_xml($data)
    {
        $xml = '';
        foreach ($data as $key => $val) {
            is_numeric($key) && $key = "item id=\"$key\"";
            $xml .= "<$key>";
            $xml .= (is_array($val) || is_object($val)) ? self::data_to_xml($val) : self::xmlSafeStr($val);
            list($key,) = explode(' ', $key);
            $xml .= "</$key>";
        }
        return $xml;
    }

    /**
     * XML编码
     * @param mixed $data 数据
     * @param string $root 根节点名
     * @param string $item 数字索引的子节点名
     * @param string $attr 根节点属性
     * @param string $id   数字索引子节点key转换的属性名
     * @param string $encoding 数据编码
     * @return string
     */
    public static function xml_encode($data, $root = 'xml', $item = 'item', $attr = '', $id = 'id', $encoding = 'utf-8')
    {
        if (is_array($attr)) {
            $_attr = array();
            foreach ($attr as $key => $value) {
                $_attr[] = "{$key}=\"{$value}\"";
            }
            $attr = implode(' ', $_attr);
        }
        $attr = trim($attr);
        $attr = empty($attr) ? '' : " {$attr}";
        $xml = "<{$root}{$attr}>";
        $xml .= self::data_to_xml($data, $item, $id);
        $xml .= "</{$root}>";
        return $xml;
    }
    public static function xmlToJson()
    {
    }
    public static function jsonToXml()
    {
    }
}
