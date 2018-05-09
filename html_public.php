<?php 
$thisTitle='公益 - 爱基兔万智牌 - IG2';
$thisKeywords='万智牌 牌库 中文 百科 查牌 公益';
$thisDescription='万智牌中文数据百科网站。提供查牌、查套牌、百科和各种中文万智牌工具。爱基兔万智牌致力于环境保护、动物保护的公益项目，同时愿意为偏远地区的万智玩家提供帮助。详情请发邮件至：bt@rams.cc索取资料。';
include_once "top.php";?>
</div>
<div class="publicbar"><img src="images/public.jpg" /></div>
<div class="main">
<?php include_once "down.php";
$temp = ob_get_contents(); 
ob_end_clean(); 
//写入文件 
$fp = fopen('public.html','w'); 
fwrite($fp,$temp) or die('写文件错误'); 
tellgoto('ok','add_create.php');
?>