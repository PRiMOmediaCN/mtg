<?php include_once "top.php";
include_once "add_left.php";?>
<div class="addbar">
    <ul>
    <h2>添加赛制</h2>
    <form method="post" action="ra_add.php">
    <li><label>代号：</label><input name="code" type="text" class="ipt" value="" /></li>
    <li><label>中文名称：</label><input name="name" type="text" class="ipt" value="" /></li>
    <li><label>英文名称：</label><input name="ename" type="text" class="ipt" value="" /></li>
    <li><label>说明：</label><textarea name="note" class="ara"></textarea></li>
    <li style="border:none;"><label>&nbsp;</label><input name="subset" type="submit" value="提交" /></li>
    </form>
    </ul>
</div>

<?php include_once "down.php";?>