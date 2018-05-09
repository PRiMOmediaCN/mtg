<?php include_once "top.php";
include_once "add_left.php";?>
<script language="javascript">
var http = createXMLHTTP(); 

//异步上传牌表
function insert_deck(){
	document.getElementById('uploaddeck').innerHTML='<img src="images/loading.gif" width="100" />';
    var fileObj = document.getElementById("decklist").files[0];
	if(fileObj){
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

function exchangeInputType(th){
    if(th.checked==true){
		$('#theFormat').show();
		$('#theMatch').hide();
		$('#player').val('System');
		$('#req').val('0');
		$('#playerbar').hide();
		$('#reqbar').hide();
	}else{
		$('#theFormat').hide();
		$('#theMatch').show();
		$('#player').val('');
		$('#req').val('');
		$('#playerbar').show();
		$('#reqbar').show();
	}
}
</script>
<div class="addbar">
    <ul>
    <h2>添加套牌</h2>
    <form name="addcard" method="post" action="ra_add.php" enctype="multipart/form-data">
    <input name="uid" value="<?php echo $vo['id']?>" type="hidden" />
    <li><label>属于比赛</label>
        <input type="checkbox" name="noMatch" value="1" onClick="exchangeInputType(this)" /> 否</li>
    <li><label>选择比赛</label>
        <select name="match" style="display:inhert;" id="theMatch">
            <?php 
			foreach($db->ig2_select('matchs','1 order by mdate desc') as $match){
				$game=$db->ig2_want('games','id='.$match['game']);	
		        $format=$db->ig2_want('formats','id='.$match['format']);
				?>
            <option value="<?php echo $match['id']?>"><?php echo $match['country'].' '.$match['city'].' '.strtoupper($game['abbr']).' '.date('Y',strtotime($match['mdate'])).' - '.$format['code']?></option>
            <?php }?>
        </select>
        
        <select name="theFormat" style="display:none;" id="theFormat">
            <?php 
			foreach($db->ig2_select('formats',1) as $format){
				?>
                <option value="<?php echo $format['id']?>"><?php echo $format['name'].' - '.$format['code']?></option>
                <?php 
			}
			?>
        </select>
    </li>
    <li><label>套牌名称</label><input name="name" class="ipt" placeholder="例如：艾斯波控制" /></li>
    <li><label>英文名称</label><input name="ename" class="ipt" placeholder="例如：esper control" /></li>
    <li><label>分类</label>
        <select name="dcate" class="ipt">
            <option value="快攻">快攻</option>
            <option value="控制">控制</option>
            <option value="快攻">科技</option>
            <option value="中速">中速</option>
            <option value="猛袭">猛袭</option>
        </select>
    </li>
    <li><label>名字分类</label><input name="dname" class="ipt" placeholder="例如：死亡阴影" /></li>
    <li><label>关键词</label><input name="dkwords" class="ipt" placeholder="英文逗号连接" /></li>
    <li id="playerbar"><label>牌手</label><input name="player" class="ipt" id="player" /></li>
    <li id="reqbar"><label>名次</label><input name="req" class="ipt" id="req" /></li>
    <li><label>上传牌表</label>
    	<input id="decklist" name="decklist" class="ipt" type="file" style="width:300px; margin-right: 10px;" /> 
    	<input name="subdecklist" type="button" value="上传" onClick="insert_deck()" /></li>
    <div class="uploaddeck" id="uploaddeck"></div>
    <li style="border:none;"><label>&nbsp;</label><input name="subdeck" type="submit" value="提交" /></li>
    </form>
    </ul>
</div>

<?php include_once "down.php";?>