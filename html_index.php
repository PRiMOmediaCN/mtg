<?php 
include_once "top.php";?>
<div class="inbar">
    <div class="inschbar">
        <li>直接输入中/英文牌名 - <a href="#">搜索建议</a></li>
        <form action="sch.php" method="get">
        <input name="n" type="text" value="" class="ipt" />
        <input name="sch" type="submit" value="搜索" class="bt" />
        </form>
        <li>高级搜索示例 
        - <a href="sch.php?n=&h=1&c=&cs=&in=&st=1&r=4&r=3&crtcate=&fv=&p=&schfull=搜索">T2所有秘稀和金</a> 
        - <a href="sch.php?n=&h=1&c=BBB&cs=&in=&st=2&crtcate=&fv=&p=&schfull=搜索">摩登提供3点黑献力的牌</a> 
        - <a href="sch.php?n=&cr%5B%5D=g&c=&cs=&in=&st=0&ct%5B%5D=4&crtcate=&lg=1&fv=&p=&schfull=搜索">所有绿色的传奇生物</a> 
        - <a href="schfull.php"><strong>高级搜索</strong></a>
        </li>
    </div>
</div>
<?php include_once "down.php";
$temp = ob_get_contents(); 
ob_end_clean(); 
//写入文件 
$fp = fopen('index.html','w'); 
fwrite($fp,$temp) or die('写文件错误'); 
tellgoto('ok','add_create.php');
?>