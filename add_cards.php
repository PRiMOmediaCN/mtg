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

//选择类别
function getcate(id){
  var url = "ra_ajax.php?getcate="+id;
  http.open("GET", url, true); 
  http.onreadystatechange = getcatevalue; 
  http.send(null);
  
}
function getcatevalue()  { 
  if (http.readyState == 4)  {
    var backInner = http.responseText; 
    document.getElementById("catevalue").innerHTML = backInner;
  }
}

//选择子类别
function getsubcate(id){
  var url = "ra_ajax.php?getsubcate="+id;
  http.open("GET", url, true); 
  http.onreadystatechange = getsubcateValue; 
  http.send(null);
  
}
function getsubcateValue()  { 
  if (http.readyState == 4)  {
    var backInner = http.responseText; 
    document.getElementById("subcateValue").innerHTML = backInner;
  }
}

//添加生物类别
function addcreature(add){
  
  var url = "ra_ajax.php?addcreature="+add;
  http.open("GET", url, true); 
  http.onreadystatechange = addcreatureValue; 
  http.send(null);
  
}
function addcreatureValue(){
  //alert(http.readyState);
  if (http.readyState == 4){
    var backInner = http.responseText; 
    document.getElementById("addcreaturebar").innerHTML = backInner;
  }
}

//添加关键词异能
function addalertit(add,currentk){
    //alert(add+','+current);
	var url = "ra_ajax.php?addkeys="+add+"&currentk="+currentk;
    http.open("GET", url, true); 
    http.onreadystatechange = addkeysValue; 
    http.send(null);
}

function addkeysValue(){ 
  if (http.readyState == 4){
    var backInner = http.responseText; 
    document.getElementById("addkeysbar").innerHTML = backInner;
  }
}

var uniq = function (arr) {   
var a = [],       
    o = {},       
    i,       
    v,       
    len = arr.length;   
    if (len < 2) {       
        return arr;   
    }   
    for (i = 0; i < len; i++) {       
        v = arr[i];       
        if (o[v] !== 1) {           
            a.push(v);           
            o[v] = 1;      
        }   
    }   
    return a;
}
function getsource(v){
	var re1=/^X*\d*([A-W]*)$/;
	var re2=/\d+/;
	var re3=/[A-W]+/;
	if(re1.test(v)){
		if(re2.test(v)) var m=parseInt(v.match(/\d/g).join(""));
		else var m=0;
		if(re3.test(v)) var n=parseInt(v.match(/[A-W]/g).length);
		else var n=0;
		var co=v.match(/[A-W]/g);
		document.getElementById('costs').value=m+n;
		document.getElementById('color').value=uniq(co.toString().toLowerCase().replace(/\,/ig,'').split('')).toString().replace(/\,/ig,'');
	}else{
		alert('输入的法术力不合法');
	}
}
</script>
<div class="addbar">
    <ul>
    <h2>添加卡牌</h2>
    <form name="addcard" method="post" action="ra_add.php">
    <li><label>名称(C/E)：</label><input name="name" type="text" value="" class="ipt" />&nbsp;<input name="ename" type="text" value="" class="ipt" /></li>
    <li><label>版本：</label>
        <label style="width:60px;">
        <select name="side">
            <option value="0">普通</option>
            <option value="1">正牌</option>
            <option value="2">倒转</option>
            <option value="3">右边</option>
            <option value="4">背面</option>
        </select>
        </label>
        
        <label style="width:60px;">
        <select name="getsubset" onchange="getsubsets(this.value)">
            <option value="1" selected="selected">扩展</option>
            <option value="2">核心</option>
            <option value="3">其他</option>
        </select>
        </label>
        <label id="subset" style="width:220px;">
        <select name="sets" onchange="getsetcounter(this.value)">
        <?php foreach($db->ig2_select('sets','isroot=1 and belong=1') as $rset){?>
            <option value="<?php echo $rset['id'] ?>" <?php echo $rset['id']==3?"selected='selected'":'' ?>> - <?php echo $rset['name'] ?> (<?php echo substr($rset['pub'],0,4) ?>)</option>
            <?php foreach($db->ig2_select('sets','pid='.$rset['id']) as $sset){?>
            <option value="<?php echo $sset['id'] ?>" <?php echo $sset['id']==3?"selected='selected'":'' ?>>&nbsp;&nbsp;<?php echo $sset['name'] ?></option>
            <?php }?>
        <?php }?>
        </select>
        </label>
    </li>
    <li><label>类别：</label>
        <label style="width:60px;"><input name="legendary" type="checkbox" value="1" /> 传奇</label>
        <label>
        <select name="suppercate" id="suppercate" onchange="getcate(this.value)">
            <option value="1">永久物</option>
            <option value="2">非永久物</option>
        </select>
        </label>
        <input name="catelist" id="catelist" type="hidden" value="" />
        <label id="catevalue" style="width:600px;">
			<?php foreach($db->ig2_select('cates','belong=1 and pid <> 5') as $cate1){?>
            <label style="width:68px;"><input name="cate[]" type="checkbox" value="<?php echo $cate1['id'] ?>" onchange="document.getElementById('catelist').value=document.getElementById('catelist').value+','+this.value;getsubcate(document.getElementById('catelist').value);" /> <?php echo $cate1['name'] ?></label>
            <?php }?>
        </label>
    </li>
    <div id="subcateValue"></div>
    <li><label>法术力：</label>
        <input name="cost" type="text" value="" class="ipt" onblur="getsource(this.value)" /> 
        <input name="costs" id="costs" type="text" value="" class="ipt short" />
        <span style="padding:0 5px;">颜色</span>
        <input name="color" id="color" type="text" value="" class="ipt short" />
    </li>
    <li><label>稀有度：</label>
        <input name="rarity" type="radio" value="6" /> 特殊        
        <input name="rarity" type="radio" value="4" /> 秘稀
        <input name="rarity" type="radio" value="3" /> 金
        <input name="rarity" type="radio" value="2" /> 银
        <input name="rarity" type="radio" value="1" checked="checked" /> 铁
        <input name="rarity" type="radio" value="5" /> 地
    </li>
    
    <li><label>关键字异能</label>
        <span id="addkeysbar"><input name="currentk" id="currentk" type="hidden" value="" /></span>
        <select name="keywords" id="keywords">
        <?php foreach($db->ig2_select('keywords','1') as $keys){?>
            <option value="<?php echo $keys['id'] ?>"><?php echo $keys['name'] ?></option>
        <?php }?>
        </select>
        <input name="addkeys" value="增加" type="button" onclick="addalertit(document.getElementById('keywords').value,document.getElementById('currentk').value)" />
    </li>
    <script language="javascript">
    function strreplace(str){
		document.getElementById(str.id).value=str.value.replace(/[\n]+/g, "<br>");
	}
    </script>
    <li><label>内文描述：</label>
        <textarea name="intext" id="intext" class="ara" onblur="strreplace(this)"></textarea>&nbsp;
        <textarea name="eintext" id="eintext" class="ara" onblur="strreplace(this)"></textarea></li>
    <li><label>背景描述：</label>
        <textarea name="flavor" id="flavor" class="ara" onblur="strreplace(this)"></textarea>&nbsp;
        <textarea name="eflavor" id="eflavor" class="ara" onblur="strreplace(this)"></textarea></li>
    <li><label>收集编号：</label>#&nbsp;<input name="serial" type="text" value="" class="ipt short" />&nbsp;/&nbsp;<span id="getsetcounters">249</span></li>
    <li><label>画家：</label><input name="painter" type="text" value="" class="ipt" /></li>
    <li><label>其他说明：</label><textarea name="note" class="ara"></textarea></li>
    <li style="border:none;"><label>&nbsp;</label><input name="subcd" type="submit" value="提交" /></li>
    </form>
    </ul>
</div>

<?php include_once "down.php";?>