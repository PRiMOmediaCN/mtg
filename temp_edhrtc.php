<?php 
include_once "ra_global.php";
include_once "class/simple_html_dom.php";
ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; SV1; .NET CLR 1.1.4322)');

$url='deck/edhrtc.html';
$html=file_get_html($url);

foreach($html->find('div[class=nwname]') as $list){
    echo '1 '.$list->plaintext.'<br>';
}
?>