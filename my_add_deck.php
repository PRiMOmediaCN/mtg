<?php include_once "top.php";
include_once "my_add_left.php";?>
<script language="javascript">
var http = createXMLHTTP(); 

//异步上传牌表
function insert_deck(){
    var fileObj = document.getElementById("decklist").files[0];
	if(fileObj){
		var upFileName=$('#decklist').val();
		var index1=upFileName.lastIndexOf(".");
		var index2=upFileName.length;
		var suffix=upFileName.substring(index1+1,index2);
		if(suffix!='txt'){
			console.log(suffix);
			alert('请上传txt格式的文档');
			return false;
		}
		document.getElementById('uploaddeck').innerHTML='<img src="images/loading.gif" width="100" />';
		var form = new FormData();
		form.append("decklist", fileObj);
		http.open("POST","ra_ajax.php", true);
		http.send(form);
		http.onreadystatechange=getValue;
	}else{
	    alert('请选择要上传的牌表文件');
	}
}

function getValue(){
    if (http.readyState == 4)  {
		if(http.status == 200 ){
		    document.getElementById("uploaddeck").innerHTML=http.responseText;
		}else{
		    alert('文件上传有误，http.status='+http.status+'，请重新上传或向管理员报告问题');
		    return false;
		}
    }
}

function checkform(){
	if($('#name').val()==''){
		alert('请输入套牌名称');
		return false;
	}
	if($('#decklist').val==''){
		alert('请选择上传的txt牌表文件');
		return false;
	}else{
		var upFileName=$('#decklist').val();
		var index1=upFileName.lastIndexOf(".");
		var index2=upFileName.length;
		var suffix=upFileName.substring(index1+1,index2);
		if(suffix!='txt'){
			console.log(suffix);
			alert('请上传txt格式的文档');
			return false;
		}
	}
	return true;
}
</script>
<div class="addbar">
    <ul>
    <h2>添加套牌</h2>
    <form name="addcard" method="post" action="ra_add.php" enctype="multipart/form-data" onSubmit="return checkform()">
    <input name="vo" type="hidden" value="<?php echo $vo['id']?>" />
    <li><label>环境</label>
        <select name="format">
			<option value="1">标准. T2</option>
			<option value="2">摩登. Mod</option>
			<option value="3">薪传. T1.5</option>
			<option value="5">特选. T1</option>
			<option value="4">指挥官. EDH</option>
   		</select>
   		<span> * 请注意，错误的环境选择有可能导致整套牌被删除</span>
    </li>
    <li><label>套牌名称</label><input name="name" id="name" class="ipt" placeholder="例如：艾斯波控制" /></li>
    <li><label>英文名称</label><input name="ename" class="ipt" placeholder="例如：esper control" /></li>
    <li><label>上传牌表</label>
    	<input id="decklist" name="decklist" class="ipt" type="file" style="width: 300px; margin-right: 10px;" /> 
    	<input name="subdecklist" type="button" value="上传" onClick="insert_deck()" /></li>
    <div class="uploaddeck" id="uploaddeck"></div>
    <li style="border:none;"><label>&nbsp;</label><input name="submydeck" type="submit" value="提交" /></li>
    </form>
    </ul>
</div>

<?php include_once "down.php";?>