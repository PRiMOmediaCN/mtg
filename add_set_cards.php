<?php include_once "top.php";
if($_GET['id']) $card=$db->ig2_want('cards','id='.$_GET['id']);
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

//获得该系列总张数
function getsetcounter(cid){
	var url = "ra_ajax.php?setcounter="+cid;
	http.open("GET", url, true); 
	http.onreadystatechange = getsetcounterValue; 
	http.send(null);
}
function getsetcounterValue()  { 
	if (http.readyState == 4)  {
		var backInner = http.responseText; 
		document.getElementById("getsetcounters").innerHTML = backInner;
	}
}
function strreplace(str){
	document.getElementById(str.id).value=str.value.replace(/[\n]+/g, "<br>");
}
</script>
<div class="addbar">
    <ul>
    <h2>添加卡牌其他版本</h2>
    <form method="post" action="ra_add.php">
    <input name="id"           type="hidden" value="<?php echo $card['id'] ?>" />
    <input name="name"         type="hidden" value="<?php echo $card['name'] ?>" />
    <input name="ename"        type="hidden" value="<?php echo $card['ename'] ?>" />
    <input name="side"         type="hidden" value="<?php echo $card['side'] ?>" />
    <input name="legendary"    type="hidden" value="<?php echo $card['legendary'] ?>" />
    <input name="prefix"       type="hidden" value="<?php echo $card['prefix'] ?>" />
    
    <input name="cate"         type="hidden" value="<?php echo $card['cate'] ?>" />
    <input name="subcate"      type="hidden" value="<?php echo $card['subcate'] ?>" />
    <input name="crtcate"      type="hidden" value="<?php echo $card['crtcate'] ?>" />
    <input name="cost"         type="hidden" value="<?php echo $card['cost'] ?>" />
    <input name="costs"        type="hidden" value="<?php echo $card['costs'] ?>" />
    <input name="rarity"       type="hidden" value="<?php echo $card['rarity'] ?>" />
    <input name="power"        type="hidden" value="<?php echo $card['power'] ?>" />
    <input name="toughness"    type="hidden" value="<?php echo $card['toughness'] ?>" />
    <input name="loyalty"      type="hidden" value="<?php echo $card['loyalty'] ?>" />
    <input name="keywords"     type="hidden" value="<?php echo $card['keywords'] ?>" />
    <input name="intext"       type="hidden" value="<?php echo $card['intext'] ?>" />
    <input name="eintext"      type="hidden" value="<?php echo $card['eintext'] ?>" />
    
    <li><label>名称(C/E)：</label><?php echo $card['name'] ?> . <?php echo $card['ename'] ?></li>
    <li><label>版本：</label>
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
    <li><label>背景描述：</label><textarea name="flavor" id="flavor" class="ara" onblur="strreplace(this)"></textarea>&nbsp;
        <textarea name="eflavor" id="eflavor" class="ara" onblur="strreplace(this)"></textarea></li>
    <li><label>收集编号：</label>#&nbsp;<input name="serial" type="text" value="" class="ipt short" />&nbsp;/&nbsp;<span id="getsetcounters">249</span></li>
    <li><label>画家：</label><input name="painter" type="text" value="<?php echo $card['painter']?>" class="ipt" /></li>
    <li><label>其他说明：</label><textarea name="note" class="ara"></textarea></li>
    <li style="border:none;"><label>&nbsp;</label><input name="subcd" type="submit" value="提交" /></li>
    </form>
    </ul>
</div>

<?php include_once "down.php";?>