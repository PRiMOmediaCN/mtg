<?php 
include_once "ra_global.php";
include_once "class/simple_html_dom.php";
ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; SV1; .NET CLR 1.1.4322)');
$url='https://s.taobao.com/search?q=%E5%85%88%E5%85%86%E5%A8%9C%E5%B8%8C%E4%B8%BD+%E4%B8%87%E6%99%BA%E7%89%8C';
$html=file_get_html($url);
var_dump($html);
?>