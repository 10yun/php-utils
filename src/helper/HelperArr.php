<?php

namespace shiyunUtils\helper;

/**
 * 数组
 */
class HelperArr
{
    /**
     * 数组筛选自己想要的字段
     * @author ctocode-zhw
     * @version 2017-07-20
     * @return mixed
     */
    public static function columnsNeed($input, $column_keys = null, $index_key = null)
    {
        $result = array();
        $keys = $column_keys;
        if ($input) {
            foreach ($input as $v) {
                // 指定返回列
                if ($keys) {
                    $tmp = array();
                    foreach ($keys as $key) {
                        $tmp[$key] = !empty($v[$key]) ? $v[$key] : '';
                    }
                } else {
                    $tmp = $v;
                }
                // 指定索引列
                if (isset($index_key)) {
                    $result[$v[$index_key]] = $tmp;
                } else {
                    $result[] = $tmp;
                }
            }
        }
        return $result;
    }

    /**
     * 二维数组删除不要的字段
     * @param array $originalArray 原有的数组
     * @param array $delKeyArr 需要删除字段数组
     * @return array 返回删除不需要Key后的新数组
     * @author ctocode-zhw
     * @version 2019-03-07
     */
    public static function columnsDel(array $originalArray = [], array $delKeyArr = []): array
    {
        // 使用array_map()函数处理数组
        $modifiedArray = array_map(function ($item) use ($delKeyArr) {
            foreach ($delKeyArr as $field) {
                unset($item[$field]);
            }
            return $item;
        }, $originalArray);
        return $modifiedArray;
    }

    /**
     * @action 多维数组排序
     * @author ctocode-zhw
     * @version 2017-07-20
     * @param array $multi_array   多维数组
     * @param string $sort_key        二维数组的键名
     * @param string $sort_order   排序常量  SORT_ASC || SORT_DESC
     * @param string $sort_type
     * @return mixed
     */
    public static function multiArrSort(&$multi_array = array(), $sort_key = '', $sort_order = SORT_DESC, $sort_type = SORT_NUMERIC)
    {
        if (is_array($multi_array)) {
            $key_array = [];
            // $key_array = array_column($multi_array,$sort_key);
            foreach ($multi_array as $row_array) {
                if (is_array($row_array)) {
                    // 把要排序的字段放入一个数组中，
                    $key_array[] = $row_array[$sort_key];
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
        // 对多个数组或多维数组进行排序
        array_multisort($key_array, $sort_order, $multi_array);
        // array_multisort ( $key_arrays, $sort_order, $sort_type, $arrays );
        return $multi_array;
    }

    /**
     * @action 数组 递归 树形 结构
     * @author ctocode-zhw
     * @version 2017-12-28
     */
    public static function treeEn($data = [], $pId = '', $upid_field = '', $id_field = '', $sava_key = '')
    {
        if (empty($sava_key)) {
            $sava_key = 'tree';
        }
        $tree = array();
        foreach ($data as $k => $v) {
            if ($v[$upid_field] == $pId) { // 父亲找到儿子
                $v[$sava_key] = self::treeEn($data, $v[$id_field], $upid_field, $id_field, $sava_key);
                $tree[] = $v;
                // unset($data[$k]);
            }
        }
        return $tree;
    }

    /**
     * @action 判断多维数组是否存在某个值
     * @author ctocode-zhw
     * @version 2017-07-20
     * @param array $value 需要的值
     * @param array $array 多维数组
     */
    public static function inExistStr($value = null, $array = array(), $echo = null)
    {
        foreach ($array as $item) {
            if (!is_array($item)) {
                if ($item == $value) {
                    return true;
                } else {
                    continue;
                }
            }
            if (in_array($value, $item)) {
                return true;
            } else if (self::inExistStr($value, $item)) {
                return true;
            }
        }
        return false;
    }

    // @action:数组 object 和 array 互转 即: $arr->k 转 $arr[k]
    // @param $type 1.o转a ,后面自动判断
    // @param $arr 需要转换的数组
    function objectToArray222($type = 1, $arr = array())
    {
        // 调用这个函数，将其幻化为数组，然后取出对应值
        $return_data = array();
        // object 转 array
        if ($type == 1) {
            if (empty($arr)) {
                $return_data = $arr;
            } elseif (count($arr) == 1) {
                $return_data = (array) $arr[0];
            } else {
                foreach ($arr as $val) {
                    $return_data[] = (array) $val;
                }
            }
        } // 不转
        else {
            $return_data = $arr;
        }
        return $return_data;
    }
    public static function objectToArray($array)
    {
        if (is_object($array)) {
            // 方法1
            $array = (array) $array;
            // 方法2
            // $array = get_object_vars ( $array );
        }
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $array[$key] = self::objectToArray($value);
            }
        }
        return $array;
    }
    public static function addToMerge($oldData = [], $addArr = [])
    {
        $newArr = [];
        foreach ($oldData as $val) {
            $newArr[] = array_merge($val, $addArr);
        }
        return $newArr;
    }
    /**
     * 去除空的
     * @param string $arr
     * @return string
     */
    public static function unsetNull($arr = '')
    {
        if ($arr !== null) {
            if (is_array($arr)) {
                if (!empty($arr)) {
                    foreach ($arr as $key => $value) {
                        if ($value === null) {
                            $arr[$key] = '';
                        } else {
                            $arr[$key] = self::unsetNull($value); // 递归再去执行
                        }
                    }
                } else {
                    $arr = '';
                }
            } else {
                if ($arr === null) {
                    $arr = '';
                } // 注意三个等号
            }
        } else {
            $arr = '';
        }
        return $arr;
    }

    /**
     * 判断是否是 键值对，一维
     */
    public static function isArrayObject($data)
    {
        // $filteredArray = array_filter(array_keys($data), 'is_string');
        $filteredArray = array_filter($data, 'is_string', ARRAY_FILTER_USE_KEY);
        if (count($filteredArray) === count($data)) {
            // 判断为一维键值对数组的逻辑
            return true;
        }
        return false;
    }
}
