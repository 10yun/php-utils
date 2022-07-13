<?php

namespace shiyunUtils\helper;

class HelperTree
{
    /**
     * 树形结构转平层
     */
    public static function treeToPeer($data = [], $saveField = 'tree')
    {
        $array = array();
        foreach ($data as $key => $val) {
            $array[] = $val;
            if (!empty($val[$saveField]) && is_array($val[$saveField])) {
                $temp_tree = $data[$key][$saveField];
                unset($data[$key][$saveField]);
                $children = self::treeToPeer($val[$saveField]);

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
     */
    public static function peerToTree($data = [], $pId = '', $upField = '', $idField = '', $saveField = '')
    {
        if (empty($saveField)) {
            $saveField = 'tree';
        }
        $tree = array();
        foreach ($data as $k => $v) {
            if ($v[$upField] == $pId) { // 父亲找到儿子
                $v[$saveField] = self::peerToTree($data, $v[$idField], $upField, $idField, $saveField);
                $tree[] = $v;
                // unset($data[$k]);
            }
        }
        return $tree;
    }
    /**
     * 获取数组的所有相关子集
     */
    public static function peerDoSonIds($data = [], $upID, $upField, $idField)
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
     * @param $saveField 存储的key
     * @param $isInSelf 是否包含自身
     */
    public static function peerDoParentIds($data = [], $upID = 0, $upField, $idField, $saveField = 'parent', $isInSelf = true)
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
                $parent_arr[$key][$saveField][] = $val[$idField];
            }
            // 如果存在上级
            if (!empty($val[$upField])) {
                $parent_arr[$key][$saveField][] = $val[$upField];
                $digui_arr = self::peerDoParentIds($data, $val[$upField], $upField, $idField);
                $parent_arr = array_merge($parent_arr, $digui_arr);
            }
            // 递归下
        }
        return $parent_arr;
    }
}
