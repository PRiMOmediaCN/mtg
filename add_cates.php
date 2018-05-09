<?php include_once "top.php";
include_once "add_left.php";?>
<div class="addbar">
    <ul>
    <h2>添加卡牌类别</h2>
    <form method="post" action="ra_add.php">
    <li><label>父类别：</label>        
        <select name="pid">
            <option value="0">父类</option>
		    <?php foreach($db->ig2_select('cates','pid=0') as $rcate){?>
            <option value="<?php echo $rcate['id'] ?>"><?php echo $rcate['name'] ?></option>
            <?php }?>
        </select>
        <select name="belong">
            <option value="1">永久物</option>
            <option value="2">非永久物</option>
            <option value="3">前缀</option>
            <option value="0">子类</option>
        </select>
    </li>
    <li><label>中文名称：</label><input name="name" type="text" class="ipt" value="" /></li>
    <li><label>英文名称：</label><input name="ename" type="text" class="ipt" value="" /></li>
    <li><label>说明：</label><textarea name="note" class="ara"></textarea></li>
    <li style="border:none;"><label>&nbsp;</label><input name="subcatesys" type="submit" value="提交" /></li>
    </form>
    </ul>
</div>

<?php include_once "down.php";?>