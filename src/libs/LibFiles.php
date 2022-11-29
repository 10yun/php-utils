<?php

namespace shiyunUtils\libs;
// 模式 描述
// r 打开文件为只读。文件指针在文件的开头开始。
// w 打开文件为只写。删除文件的内容或创建一个新的文件，如果它不存在。文件指针在文件的开头开始。
// a 打开文件为只写。文件中的现有数据会被保留。文件指针在文件结尾开始。创建新的文件，如果文件不存在。
// x 创建新文件为只写。返回 FALSE 和错误，如果文件已存在。
// r+ 打开文件为读/写、文件指针在文件开头开始。
// w+ 打开文件为读/写。删除文件内容或创建新文件，如果它不存在。文件指针在文件开头开始。
// a+ 打开文件为读/写。文件中已有的数据会被保留。文件指针在文件结尾开始。创建新文件，如果它不存在。
// x+ 创建新文件为读/写。返回 FALSE 和错误，如果文件已存在。
class LibFiles
{
    public string $path = '';
    public function setPath($str = '')
    {
        $this->path = $str;
        return $this;
    }
    // 写入内容
    public function writeContent($content = '')
    {
        $fileHandle = fopen($this->path, "w+") or die("无法打开文件！");
        $put_content = "<?php \n";

        if (is_array($content)) {
            foreach ($content as $val) {
                $put_content .= $val . "\n";
            }
        } else if (is_string($content)) {
            $put_content .= $content . "\n";
        }
        // 写入
        fwrite($fileHandle, $put_content);
        // 关闭
        fclose($fileHandle);
    }
    public function readContent()
    {
        $fileHandle = fopen($this->path, "r+") or die("无法打开文件！");
        // fread() 函数读取打开的文件。第一个参数包含待读取文件的文件名，第二个参数规定待读取的最大字节数。
        echo fread($fileHandle, filesize($this->path));
        // 读取单行文件 - fgets()文件的首行：
        echo fgets($fileHandle);
        // 输出单行直到 end-of-file
        while (!feof($fileHandle)) {
            echo fgets($fileHandle) . "<br>";
        }
        // 输出单字符直到 end-of-file
        while (!feof($fileHandle)) {
            echo fgetc($fileHandle);
        }
        // 关闭
        fclose($fileHandle);
    }
}
