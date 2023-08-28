<?php

namespace shiyunUtils\libs;

/**
 * 【ctocode】      核心文件 - 日志
 * ============================================================================
 * @author       作者         ctocode-zhw
 * @version 	  版本	  v5.7.1.20210514
 * @copyright    版权所有   2015-2027，并保留所有权利。
 * @link         网站地址   https://www.10yun.com
 * @contact      联系方式   QQ:343196936
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * 如果商业用途务必到官方购买正版授权, 以免引起不必要的法律纠纷.
 * ============================================================================
 */
// $logsObj = LibsLogger::new实例()->setDir('runtime')->writeLog ( 'SELECT FORM ' );


/**
 * 文件日志
 * @author ctocode-lww
 * @version 2018-10-17
 */
class LibsLogger
{
    protected $dirPath = '';
    public static function setDir($dirPath = '')
    {
        $self = new self();
        self::$dirPath = $dirPath;
        return $self;
    }
    /**
     * 记录数据信息
     * @param string $content 日志内容
     * @param string $file_name 文件名
     */
    public static function info($content, $file_name = 'info.log')
    {
        self::writeLog($content, $file_name);
    }
    /**
     * 记录错误信息
     * @param string $content 日志内容
     * @param string $file_name 文件名
     */
    public static function error($content, $file_name = 'error.log')
    {
        self::writeLog($content, $file_name);
    }
    /**
     * 记录调试信息
     * @param string $content 日志内容
     * @param string $file_name 文件名
     */
    public static function debug($content, $file_name = 'debug.log')
    {
        self::writeLog($content, $file_name);
    }
    /**
     * 写入日志
     * @param string $content 日志内容
     * @param string $file_name 文件名
     */
    public static function writeLog($content, $file_name)
    {
        if (defined("_PATH_RUNTIME_")) {
            $file_name = _PATH_RUNTIME_ . 'ctocode_log/' . $file_name;
        } else {
            $file_name = dirname(__DIR__, 5) . '/runtime/ctocode_log/' . $file_name;
        }
        if (!file_exists(dirname($file_name))) {
            mkdir(dirname($file_name), 0777, true);
        }
        $content = (is_array($content) || is_object($content)) ? print_r($content, 1) : $content;
        @file_put_contents($file_name, PHP_EOL . date('Y-m-d H:i:s') . "============================" . PHP_EOL . $content, FILE_APPEND);
    }

    // 日志LOG
    protected function curlLog($logData = array(), $type = '')
    {
        $date = date("Y-m-d H:i:s", time());
        $logData['log_date'] = $date;
        $logfile = '';
        $txt = '';
        switch ($type) {
            case 'error':
                $logfile = fopen(_PATH_RUNTIME_ . "/logs/logfile_error_" . date("Ymd", time()) . ".txt", "a+");
                $txt = "========== 错误日志 - {$date} ==========\n";
                break;
            case 'debug':
            default:
                $logfile = fopen(_PATH_RUNTIME_ . "/logs/logfile_debug_" . date("Ymd", time()) . ".txt", "a+");
                $txt = "========== 调试日志 - {$date} ==========\n";
                break;
        }
        $txt .= var_export($logData, true) . "\n";
        fwrite($logfile, $txt);
        fclose($logfile);
    }
    // 错误日志LOG
    public static function curlErrorLog($logData = array())
    {
        self::curlLog($logData, 'error');
    }
    // 调试日志LOG
    public static function curlDebugLog($logData = array())
    {
        self::curlLog($logData, 'debug');
    }




    protected static $instance = null;
    const _CTOLOG_LEVEL_FATAL_ = 0;
    const _CTOLOG_LEVEL_ERROR_ = 1;
    const _CTOLOG_LEVEL_WARN_ = 2;
    const _CTOLOG_LEVEL_INFO_ = 3;
    const _CTOLOG_LEVEL_DEBUG_ = 4;
    const _CTOLOG_PATH = ''; // 自定义日志路径，如果没有设置，则使用系统默认路径，在./data/logs/
    const _CTOLOG_OPEN_ = FALSE; // 是否记录日志
    const _CTOLOG_DISPLAY_ = FALSE; // 是否显示LOG输出
    const _CTOLOG_DEBUG = FALSE; // 是否输出DEBUG
    public static $ifWrite = true; // 是否写入
    public static $logFlag = "";
    public static $logPath = "";

    function __construct($logPath, $logFlag)
    {
        self::$logPath = $logPath;
        self::$logFlag = $logFlag;
        if (!is_dir($logPath))
            mkdir($logPath, 0777);
    }
    public function writeLog2($logMsg)
    {
        if (!self::$ifWrite)
            return;
        $logName = self::$logPath . self::$logFlag . date('Ymd') . ".log";
        if (file_exists($logName)) {
            file_put_contents($logName, sprintf("[%s]%s\r\n", date('G:i:s'), $logMsg), FILE_APPEND);
        } else {
            // 如果不存在则创建
            file_put_contents($logName, sprintf("[%s]%s\r\n", date('G:i:s'), date('Y-m-d')));
            if (!is_writeable($logName))
                chmod($logName, 0777);
            file_put_contents($logName, sprintf("[%s]%s\r\n", date('G:i:s'), $logMsg), FILE_APPEND);
        }
    }
    static $LOG_LEVEL_NAMES = array(
        'FATAL',
        'ERROR',
        'WARN',
        'INFO',
        'DEBUG'
    );
    private $level = '_CTOLOG_LEVEL_DEBUG_';
    public static function getInstance($AutoCreate = false)
    {
        if ($AutoCreate === true && !self::$instance) {
            self::init();
        }
        return self::$instance;
    }
    public static function init()
    {
        return self::$instance = new self();
    }
    function setLogLevel($lvl)
    {
        if ($lvl >= count(self::$LOG_LEVEL_NAMES) || $lvl < 0) {
            throw new \Exception('invalid log level:' . $lvl);
        }
        $this->level = $lvl;
    }
    function _log($level, $message, $name)
    {
        if ($level > $this->level) {
            return;
        }
        $log_file_path = LOG_ROOT . $name . '.log';
        $log_level_name = self::$LOG_LEVEL_NAMES[$this->level];
        $content = date('Y-m-d H:i:s') . ' [' . $log_level_name . '] ' . $message . "\n";
        @file_put_contents($log_file_path, $content, FILE_APPEND);
    }
    function debug2($message, $name = 'system')
    {
        $this->_log('_CTOLOG_LEVEL_DEBUG_', $message, $name);
    }
    function info2($message, $name = 'system')
    {
        $this->_log('_CTOLOG_LEVEL_INFO_', $message, $name);
    }
    function warn($message, $name = 'system')
    {
        $this->_log('_CTOLOG_LEVEL_WARN_', $message, $name);
    }
    function error2($message, $name = 'system')
    {
        $this->_log('_CTOLOG_LEVEL_ERROR_', $message, $name);
    }
    function fatal($message, $name = 'system')
    {
        $this->_log('_CTOLOG_LEVEL_FATAL_', $message, $name);
    }
}
