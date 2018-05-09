<?php include_once "top.php";
include_once "add_left.php";?>
<div class="addbar">
    <ul>
    <h2>添加版本</h2>
    <form method="post" action="ra_add.php">
    <li><label>中文名称：</label><input name="name" type="text" class="ipt" value="" /></li>
    <li><label>英文名称：</label><input name="ename" type="text" class="ipt" value="" /></li>
    <li><label>缩写：</label><input name="abbr" type="text" class="ipt" value="" /></li>
    <li><label>是否大系列：</label>
        <input onclick="document.getElementById('setit').style.display='none';" name="isroot" type="radio" value="1" checked="checked" /> 是 
        <input onclick="document.getElementById('setit').style.display='inline';" name="isroot" type="radio" value="0" /> 否</li>
    <li id="setit" style="display:none;"><label>大系列：</label>
        <select name="pid">
            <option value="0">请选择</option>
            <?php foreach($db->ig2_select('sets','pid=0 and belong=1 order by id desc') as $sets){?>
            <option value="<?php echo $sets['id'] ?>"><strong><?php echo $sets['name'] ?></strong></option>
            <?php }?>
        </select>
    </li>
    <li><label>大类：</label>
        <select name="belong">
            <option value="2">核心（Core Sets）</option>
            <option value="1">扩展（Expansions）</option>
            <option value="3">其他（Others）</option>
        </select>
    </li>
    <li><label>总牌数：</label><input name="total" type="text" class="ipt" value="" /></li>
    <li><label>发布日期：</label><input name="pub" id="pubdate" type="date" class="ipt" value="" /></li>
    <li><label>说明：</label><textarea name="note" class="ara"></textarea></li>
    <li style="border:none;"><label>&nbsp;</label><input name="subset" type="submit" value="提交" /></li>
    </form>
    <?php /* foreach($db->ig2_select('sets','1') as $cc){
	    echo '<li>'.$cc['ename'].'</li>' ;
	} */?>
    </ul>
</div>

<?php include_once "down.php";?>