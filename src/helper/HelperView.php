<?php

class HelperView
{

    /**
     * @action 分页函数
     * @author ctocode-zhw
     * @copyright Email 343196936@qq.com  
     * @version 2017-06-22
     * @param number $currentPage 当前页
     * @param number $pageTotal 总页数
     * @param number $pageSize 每页个数
     * @param string $url 地址
     * @param string $style  
     * @return mixed 
     */
    function ctoHtmlPagebreak($currentPage = 1, $total = 0, $pageSize = null, $url = null, $style = null)
    {
        /* style风格样式 */
        if ($style == NULL) {
            $style = '<style type="text/css">
    div.zhw_htmlpage{text-align: center;padding: 5px 10px;height: 70px; overflow: hidden;}
    div.zhw_htmlpage a{border:1px solid #e4e4e4; font-family:"Tahoma","Arial"; font-size:14px; height:30px; line-height: 30px; 
        padding:0 12px; margin-left: 2px; display: inline-block; overflow: hidden; background: #FFF; color:#6a6a6a;vertical-align:middle;}
    div.zhw_htmlpage a:hover{background:#0666c5;color:#FFF;text-decoration:none}
    div.zhw_htmlpage a.on{background:#6e2685;color:#FFF}
    div.zhw_htmlpage input#ctoGoDiyPage{padding:5px 8px 5px 8px;margin-left:2px;display:inline-block;
        width: 50px;height:30px;line-height: 22px;font-size:14px;font-weight:bold;border:1px solid #d8d8d8;border-radius:4px;overflow: hidden;vertical-align:middle;}</style>';
        }
        /* javascript设置选中 */
        $javascript = '<script type="text/javascript">
				var zhw_htmlpagea =document.getElementById("ctoGoPage' . $currentPage . '");
				if(zhw_htmlpagea!=undefined){zhw_htmlpagea.setAttribute("class","on");}</script>';
        $javascript .= <<<EOF
			<script type="text/javascript">
			function ctoGoDiyPageFunc(){
				var page = document.getElementById("ctoGoDiyPage").value;
				var url = "$url";
				if(page != '' || page != 0){
					window.location.href = url + page;
				}
			}
			</script>
EOF;
        $pagetotal = ceil($total / $pageSize); // 向上取整,算出分页
        $paging = '<div class="zhw_htmlpage ">';
        if ($pagetotal == 1) {
            $paging .= '<a id="ctoGoPage1" href=" ' . $url . '1" >1</a>';
        } else {
            // 开头部分,是否显示上一页
            if (($currentPage - 3) > 1) {
                $paging .= '<a id="ctoGoPage1" href=" ' . $url . '1" >1...</a>
				<a  href=" ' . $url . ($currentPage - 1) . '" class="next">上一页</a>';
            }
            // 中间部分,输出7个分页
            for ($i = $currentPage - 3; $i < $currentPage + 4; $i++) {
                if ($i < 1 || $i > $pagetotal) {
                    continue;
                }
                $paging .= '<a id="ctoGoPage' . $i . '" href=" ' . $url . $i . '">' . $i . '</a>';
            }
            // 结尾部分,是否显示下一页
            if (($currentPage + 4) <= $pagetotal) {
                $paging .= '<a href=" ' . $url . ($currentPage + 1) . '" class="next">下一页</a>
						<a id="ctoGoPage' . $pagetotal . '" href="' . $url . $pagetotal . '">...' . $pagetotal . '</a>';
            }
        }
        // 是否开启跳转
        $paging .= '&nbsp;&nbsp;<input type="text" id="ctoGoDiyPage" value="' . $currentPage . '"><a href="javascript:ctoGoDiyPageFunc();">跳转</a>';
        $paging .= "<br>(总共" . $pagetotal . "页 共" . $total . "条记录 )</div>";
        return $style . $paging . $javascript;
    }
}
