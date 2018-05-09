<?php include_once "top.php";
include_once "add_left.php";?>
<div class="addbar">
    <ul>
    <h2>添加生物类别</h2>
    <form method="post" action="ra_add.php">
    <li><label>中文名称</label><input name="name" type="text" class="ipt" value="" /></li>
    <li><label>英文名称</label><input name="ename" type="text" class="ipt" value="" /></li>
    <li><label>类别</label>
        <input name="type" type="radio" value="1" checked="checked" /> 种族
        <input name="type" type="radio" value="2" /> 职业
        <input name="type" type="radio" value="3" /> 动物
        <input name="type" type="radio" value="4" /> 物件
    <li><label>说明</label><textarea name="note" class="ara"></textarea></li>
    <li style="border:none;"><label>&nbsp;</label><input name="subcrtcate" type="submit" value="提交" /></li>
    <li style="border:none;"><label>已有类别：</label>
        <label style=" width:820px;">
		<?php foreach($db->ig2_select('crtcates','1') as $crtcate){ echo '<span class="ablk">'.$crtcate['id'].','.$crtcate['name'].' - '.$crtcate['ename'].'</span>';} ?>
        </label>
    </li>
    </form>
    </ul>
</div>

<?php include_once "down.php";?>