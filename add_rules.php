<?php include_once "top.php";
include_once "add_left.php";?>
<div class="addbar">
    <ul>
    <h2>添加规则</h2>
    <form method="post" action="ra_add.php">
    <li><label>大序号：</label>
        <select name="serial">
            <?php for($i=1;$i<=9;$i++){?>
            <option value="<?php echo $i ?>"><?php echo $i ?></option>
            <?php }?>
        </select>
        <span style="margin:0 10px;">子序号</span><input name="code" type="text" class="ipt short" value="" /></li>
    <li><label>内链</label><input name="links" type="text" class="ipt" value="" /></li>
    <li><label>关键词</label><input name="keywords" type="text" class="ipt" value="" /></li>
    <li><label>中文</label><textarea name="content" class="ara"></textarea></li>
    <li><label>英文</label><textarea name="econtent" class="ara"></textarea></li>
    
    <li style="border:none;"><label>&nbsp;</label><input name="subru" type="submit" value="提交" /></li>
    </form>
    </ul>
</div>

<?php include_once "down.php";?>