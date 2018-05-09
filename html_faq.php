<?php 
$thisTitle='问答FAQ - 爱基兔万智牌 - IG2';
include_once "top.php";
include_once "about_left.php";?>
<div class="addbar">
    <ul>
    <h2>FAQ</h2>
    <li><strong>Q：有些老牌本身就没有中文翻译，网站上的翻译是哪儿来的？</strong></li>
    <li>A：是我个人翻的，可能会有些错误的地方，希望大家发现后指正。</li>
    <li><strong>Q：你不是说非商业行为么，为什么开淘宝店？</strong></li>
    <li>A：我们为了自己测试套牌方便印刷套牌，开个店为了给大家一个快速便宜的方式打印自己的测试套牌。</li>
    <li><strong>Q：是否在淘宝店消费跟使用网站有关系么？</strong></li>
    <li>A：是否在淘宝购物与使用本网站并无任何关系。</li>
    <li><strong>Q：淘宝店地址？</strong></li>
    <li>A：请访问：<a href="https://ig2cc.taobao.com">https://ig2cc.taobao.com</a>。</li>
    <li><strong>Q：如何注册会员？</strong></li>
    <li>A：请参阅<a href="volunteer.html">志愿者计划</a>。</li>
    <li><strong>Q：上哪儿去找成型的套牌？</strong></li>
    <li>A：在<a href="decks.php">构筑</a>版块。可以搜索中文套牌名称功能查询套牌。</li>
    </ul>
</div>

<?php include_once "down.php";
$temp = ob_get_contents(); 
ob_end_clean(); 
//写入文件 
$fp = fopen('faq.html','w'); 
fwrite($fp,$temp) or die('写文件错误'); 
tellgoto('ok','add_create.php');
?>