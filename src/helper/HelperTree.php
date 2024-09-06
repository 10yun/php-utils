<?php

namespace shiyunUtils\helper;

class HelperTree
{
    /**
     * 树形结构转平层
     */
    public static function treeToPeer($data = [], $childrenField = 'tree')
    {
        $array = array();
        foreach ($data as $key => $val) {
            $array[] = $val;
            if (!empty($val[$childrenField]) && is_array($val[$childrenField])) {
                $temp_tree = $data[$key][$childrenField];
                unset($data[$key][$childrenField]);
                $children = self::treeToPeer($val[$childrenField]);

                if ($children) {
                    $array = array_merge($array, $children);
                }
            }
        }
        return $array;
    }
    /**
     * @action 数组 递归 树形 结构
     * @author ctocode-zhw
     * @version 2017-12-28
     * @param $data 原数组
     * @param int $upID 父级IP
     * @param string $upField 父级字段
     * @param string $idField ID字段
     * @param string $childrenField 存储子集的字段
     */
    public static function peerToTree($data = [], $upID = 0, $upField = '', $idField = '', $childrenField = '', &$cache = [])
    {
        if (empty($childrenField)) {
            $childrenField = 'tree';
        }
        $tree = array();
        foreach ($data as $k => $v) {
            if ($v[$upField] == $upID) { // 父亲找到儿子

                // 原有的
                // $v[$childrenField] = self::peerToTree($data, $v[$idField], $upField, $idField, $childrenField);

                // 在缓存中查找已处理的子节点数据
                if (isset($cache[$v[$idField]])) {
                    $v[$childrenField] = $cache[$v[$idField]];
                } else {
                    // 预处理数据，筛选出与当前节点相关的子节点数据
                    $children = array_filter($data, function ($item) use ($v, $upField, $idField) {
                        return $item[$upField] == $v[$idField];
                    });

                    // 递归调用处理子节点
                    $v[$childrenField] = self::peerToTree($children, $v[$idField], $upField, $idField, $childrenField, $cache);

                    // 缓存已处理的子节点数据
                    $cache[$v[$idField]] = $v[$childrenField];
                }
                $tree[] = $v;
                // unset($data[$k]);
            }
        }
        return $tree;
    }
    /**
     * 获取数组的所有相关子集
     */
    public static function peerDoSonIds($data = [], $upID = 0, $upField = '', $idField = '')
    {
        $ids = array();
        foreach ($data as $key => $val) {
            if ($val[$upField] == $upID) {
                $ids[] = $val[$idField];
                $ids_son = self::peerDoSonIds($data, $val[$idField], $upField, $idField);
                $ids = array_merge($ids, $ids_son);
            }
        }
        return $ids;
    }
    /**
     * 一维数组，找出它的所有上级
     * @param $childrenField 存储的key
     * @param $isInSelf 是否包含自身
     */
    public static function peerDoParentIds($data = [], $upID = 0, $upField = '', $idField = '', $childrenField = 'parent', $isInSelf = true)
    {
        $parent_arr = [];
        foreach ($data as $key => $val) {
            if (
                !empty($upID) && ($upID != $val[$idField])
            ) {
                continue;
            }
            $parent_arr[$key] = $val;
            // 是否把自身的id保存
            if ($isInSelf) {
                $parent_arr[$key][$childrenField][] = $val[$idField];
            }
            // 如果存在上级
            if (!empty($val[$upField])) {
                $parent_arr[$key][$childrenField][] = $val[$upField];
                $digui_arr = self::peerDoParentIds($data, $val[$upField], $upField, $idField);
                $parent_arr = array_merge($parent_arr, $digui_arr);
            }
            // 递归下
        }
        return $parent_arr;
    }
}
