<?php 
$thisTitle='关于我们 - 爱基兔万智牌 - IG2';
$thisKeywords='爱基兔 万智牌 牌库 中文 百科 查牌 关于我们';
include_once "top.php";
include_once "about_left.php";?>
<div class="addbar">
    <ul>
    <h2>关于我们</h2>
    <li>我们是一些万智牌的个人爱好者。</li>
    <li>本站希望做一个中文万智牌的数据网站，便于在中国大陆地区的牌手使用和查阅。</li>
    <li>如果你发现网站上收录的数据有什么错误的话，请点击右下角的报错按钮告诉我们。</li>
    <li>我们给你准备了一份小小的礼物表示感谢。</li>
    <li>愿意长期帮助网站建立更全面的数据，请参阅<a href="volunteer.html">志愿者计划</a>。</li>
    </ul>
</div>

<?php include_once "down.php";
$temp = ob_get_contents(); 
ob_end_clean(); 
//写入文件 
$fp = fopen('aboutus.html','w'); 
fwrite($fp,$temp) or die('写文件错误'); 
tellgoto('ok','add_create.php');
?>