<?php include_once "top.php";
include_once "add_left.php";?>
<div class="addbar">
    <ul>
    <h2>添加赛制</h2>
    <form name="addcard" method="post" action="ra_add.php" enctype="multipart/form-data">
    <li><label>中文</label><input name="name" value="" class="ipt" /></li>
    <li><label>英文</label><input name="enname" class="ipt" value="" /></li>
    <li><label>缩写</label><input name="abbr" class="ipt" value="" /></li>
    <li><label>说明</label><textarea name="mime" class="ara"></textarea></li>
    <li style="border:none;"><label>&nbsp;</label><input name="subgame" type="submit" value="提交" /></li>
    </form>
    <?php foreach($db->ig2_select('games','1') as $list){?>
    <li><label><?php echo $list['abbr']?></label><?php echo $list['name'].' - '.$list['enname']?></li>
    <?php }?>
    </ul>
</div>

<?php include_once "down.php";?>