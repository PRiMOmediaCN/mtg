<?php 
$thisTitle='联系我 - 爱基兔万智牌 - IG2';
include_once "top.php";
include_once "about_left.php";?>
<div class="addbar">
    <ul>
    <h2>联系我</h2>
    <li>我的QQ号：153864211，加好友请注明IG2（切记）。</li>
    <li>或者给我写邮件：bt@rams.cc</li>
    </ul>
</div>

<?php include_once "down.php";
$temp = ob_get_contents(); 
ob_end_clean(); 
//写入文件 
$fp = fopen('contact.html','w'); 
fwrite($fp,$temp) or die('写文件错误'); 
tellgoto('ok','add_create.php');
?>