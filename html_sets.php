<?php 
$thisTitle='万智牌全系列牌库 - 全站地图 - 爱基兔万智牌 - IG2';
include_once "top.php";
$t2=file_get_contents('t2.txt');
$mdn=file_get_contents('mdn.txt');
?>
<div class="mainlist">
    <h1>版本 sets
        <div class="setlegend">
            <div class="legend" style="background:#f0fbeb;">&nbsp;</div><font class="fl">标准（T2）</font>
            <div class="legend"  style="background:#fdf2ef;">&nbsp;</div><font class="fl">摩登（Mod）</font>
        </div>
    </h1>
    <ul>
    <h2>扩展（Expansions）</h2>    
    <?php foreach($db->ig2_select('sets','belong=1 and isroot=1  order by pub desc') as $list){?>
    <li><?php echo $list['name'] ?></li>
		<?php foreach($db->ig2_select('sets','belong=1 and pid='.$list['id'].' order by pub desc') as $sublist){?>
        <li class="sublist" style="
        <?php echo in_array($sublist['id'],explode(',',$t2))?'background:#f0fbeb':(in_array($sublist['id'],explode(',',$mdn))?'background:#fdf2ef':'')?>
        "><a href="sets_<?php echo $sublist['abbr'] ?>.html"><?php echo $sublist['name'] ?></a> - <?php echo $sublist['ename'] ?>  - <strong><?php echo $sublist['abbr'] ?></strong></li>
        <?php }?>
        <li class="sublist" style="
        <?php echo in_array($list['id'],explode(',',$t2))?'background:#f0fbeb':(in_array($list['id'],explode(',',$mdn))?'background:#fdf2ef':'')?>
        "><a href="sets_<?php echo $list['abbr'] ?>.html"><?php echo $list['name'] ?></a> - <?php echo $list['ename'] ?>  - <strong><?php echo $list['abbr'] ?></strong></li>
    <?php }?>
    </ul>
    
    <ul>
    <h2>核心（Core Sets）</h2>
    <?php foreach($db->ig2_select('sets','belong=2 and isroot=1 order by pub desc') as $list){?>
    <li class="sublist" style="
    <?php echo in_array($list['id'],explode(',',$mdn))?'background:#fdf2ef':''?>
    "><a href="sets_<?php echo $list['abbr'] ?>.html"><?php echo $list['name'] ?></a> - <?php echo $list['ename'] ?>  - <strong><?php echo $list['abbr'] ?></strong></li>
    <?php }?>
    </ul>
    
    <ul>
    <h2>其他（Other Sets）</h2>
    <?php foreach($db->ig2_select('sets','belong=3 order by pub desc') as $list){?>
    <li class="sublist" style="
    <?php echo in_array($list['id'],explode(',',$mdn))?'background:#fdf2ef':''?>
    "><a href="sets_<?php echo $list['abbr']?>.html"><?php echo $list['name'] ?></a> - <?php echo $list['ename'] ?>  - <strong><?php echo $list['abbr'] ?></strong></li>
    <?php }?>
    </ul>
    <img src="images/mtg-top.png" />
</div>
<?php include_once "down.php";
$temp = ob_get_contents(); 
ob_end_clean(); 
//写入文件 
$fp = fopen('sitemap.html','w'); 
fwrite($fp,$temp) or die('写文件错误'); 
tellgoto('ok','add_create.php');
?>