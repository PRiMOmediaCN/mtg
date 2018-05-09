<?php include_once "top.php";
include_once "add_left.php";?>
<script language="javascript">
var http = createXMLHTTP(); 

//版本选择
function getsubsets(cid){
	var url = "ra_ajax.php?subset="+cid;
	http.open("GET", url, true); 
	http.onreadystatechange = getValue; 
	http.send(null);
}
function getValue()  { 
    if (http.readyState == 4)  {
        var backInner = http.responseText; 
        document.getElementById("subset").innerHTML = backInner;
    }
}
</script>
<div class="addbar">
    <ul>
    <h2>添加关键词</h2>
    <form method="post" action="ra_add.php">
    <li><label>中文名称：</label><input name="name" type="text" class="ipt" value="" /> <input name="ename" type="text" class="ipt" value="" /></li>
    <li><label>异能类型：</label>
        <select name="type">
             <option value="1">静止式</option>
             <option value="2">启动式</option>
             <option value="3">触发式</option>
             <option value="4">躲避式</option>
             <option value="5">替代式</option>
        </select>
    </li>
    <li><label>最早出现：</label>
        <label style="width:60px;">
        <select name="getsubset" onchange="getsubsets(this.value)">
            <option value="1">扩展</option>
            <option value="2">核心</option>
            <option value="3">其他</option>
        </select>
        </label>
        <label id="subset">
        <select name="sets" onchange="getsetcounter(this.value)">
        <?php foreach($db->ig2_select('sets','isroot=1 and belong=1') as $rset){?>
            <option value="<?php echo $rset['id'] ?>"> - <?php echo $rset['name'] ?> (<?php echo substr($rset['pub'],0,4) ?>)</option>
            <?php foreach($db->ig2_select('sets','pid='.$rset['id']) as $sset){?>
            <option value="<?php echo $sset['id'] ?>">&nbsp;&nbsp;<?php echo $sset['name'] ?></option>
            <?php }?>
        <?php }?>
        </select>
        </label>
    </li>
    <li><label>说明：</label><textarea name="note" class="ara"></textarea> <textarea name="enote" class="ara"></textarea></li>
    <li style="border:none;"><label>&nbsp;</label><input name="subkw" type="submit" value="提交" /></li>
        <li><label>已有类别：</label><label style="width:800px; line-height:24px;"><?php foreach($db->ig2_select('keywords','1') as $crtcate){ echo '<div style="float:left;width:80px;">'.$crtcate['id'],',',$crtcate['name'].'</div>';} ?></label></li>
    </form>
    </ul>
</div>

<?php include_once "down.php";?>