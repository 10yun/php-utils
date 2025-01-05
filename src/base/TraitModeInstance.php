<?php

namespace shiyunUtils\base;

/**
 * 设计模式 - 单例模式
 */
trait TraitModeInstance
{
    /**
     * 单例实例
     */
    protected static $instance;
    /**
     * 存储单例
     */
    protected array $instances = [];
    /**
     * 获取当前容器的实例（单例）
     * @access public
     * @return static
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;

        // if (is_null(static::$instance)) {
        //     static::$instance = new static();
        // }
        // return static::$instance;
    }
    /**
     * 每次都创建新的单例
     */
    public static function newInstance(): static
    {
        return new static();
    }
    // public static function __callStatic($method, $params)
    // {
    //     $query = new self();
    //     return call_user_func_array([$query, $method], $params);
    // }
}
